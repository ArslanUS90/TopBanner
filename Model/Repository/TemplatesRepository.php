<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\Repository;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterface;
use ArslanFarrukh\TopBanner\Api\TemplatesRepositoryInterface;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration as ResourceModel;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration\Collection;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration\CollectionFactory;
use ArslanFarrukh\TopBanner\Model\TemplatesConfigurationFactory as ModelFactory;

class TemplatesRepository implements TemplatesRepositoryInterface
{
    /** @var ModelFactory */
    private $modelFactory;

    /** @var ResourceModel */
    private $resourceModel;

    /** @var CollectionFactory */
    private $collectionFactory;

    /**
     * @param ModelFactory $model
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ModelFactory $model,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $model;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param TemplatesConfigurationInterface $configuration
     * @return TemplatesConfigurationInterface
     * @throws CouldNotSaveException
     */
    public function save(TemplatesConfigurationInterface $configuration)
    {
        try {
            if ($configuration->getId()) {
                $configuration = $this->getById((int)$configuration->getId())->addData($configuration->getData());
            }
            $this->resourceModel->save($configuration);
        } catch (Exception $exception) {
            if ($configuration->getId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save configuration with ID %1. Error: %2',
                        [$configuration->getId(), $exception->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(
                __('Unable to save new configuration. Error: %1', $exception->getMessage())
            );
        }

        return $configuration;
    }

    /**
     * @param int $id
     * @return TemplatesConfigurationInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): TemplatesConfigurationInterface
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $id);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('Configuration with specified ID "%1" not found.', $id));
        }
        return $model;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        $model = $this->getById($id);
        return $this->delete($model);
    }

    /**
     * @param TemplatesConfigurationInterface $configuration
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TemplatesConfigurationInterface $configuration): bool
    {
        try {
            $this->resourceModel->delete($configuration);
        } catch (Exception $exception) {
            if ($configuration->getId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove configuration with ID %1. Error: %2',
                        [$configuration->getId(), $exception->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(
                __(
                    'Unable to remove configuration. Error: %1',
                    $exception->getMessage()
                )
            );
        }
        return true;
    }

    /** @return Collection */
    public function getList(): Collection
    {
        return $this->collectionFactory->create();
    }
}
