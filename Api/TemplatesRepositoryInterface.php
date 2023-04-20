<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterface;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration\Collection;

interface TemplatesRepositoryInterface
{
    /**
     * @param TemplatesConfigurationInterface $configuration
     * @return TemplatesConfigurationInterface
     * @throws CouldNotSaveException
     */
    public function save(TemplatesConfigurationInterface $configuration);

    /**
     * @param int $id
     * @return TemplatesConfigurationInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id):TemplatesConfigurationInterface;

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool;

    /**
     * @param TemplatesConfigurationInterface $configuration
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TemplatesConfigurationInterface $configuration): bool;

    /**
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getList(): Collection;
}
