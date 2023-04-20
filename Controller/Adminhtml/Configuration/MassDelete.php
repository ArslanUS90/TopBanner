<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Configuration;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterface;
use ArslanFarrukh\TopBanner\Model\Repository\TemplatesRepository;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration\CollectionFactory;

class MassDelete extends Action
{
    /** @var TypeListInterface */
    private $typeList;

    /** @var CollectionFactory */
    private $collectionFactory;

    /** @var TemplatesRepository */
    private $repository;

    /** @var Filter */
    private $filter;

    /**
     * @param TypeListInterface $typeList
     * @param CollectionFactory $collectionFactory
     * @param TemplatesRepository $repository
     * @param Filter $filter
     * @param Context $context
     */
    public function __construct(
        TypeListInterface $typeList,
        CollectionFactory $collectionFactory,
        TemplatesRepository $repository,
        Filter $filter,
        Context $context
    ) {
        parent::__construct($context);
        $this->typeList = $typeList;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->repository = $repository;
    }

    /** @return bool */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ArslanFarrukh_TopBanner::configuration');
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection(
            $this->collectionFactory->create()
        );

        /** @var TemplatesConfigurationInterface $item */
        foreach ($collection->getItems() as $item) {
            try {
                $this->repository->deleteById((int)$item->getId());
            } catch (CouldNotDeleteException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        }
        $this->typeList->cleanType("full_page");

        return $this->resultFactory->create(
            ResultFactory::TYPE_REDIRECT
        )->setPath('*/*/index');
    }
}
