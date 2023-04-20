<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Ui\Component\MassAction\Filter;
use ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;
use ArslanFarrukh\TopBanner\Model\EntityFactory;
use function __;

class MassDelete extends Entity implements HttpPostActionInterface
{
    /** @var Filter */
    private $filter;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param EntityFactory $entityFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        EntityFactory $entityFactory,
        Filter $filter
    ) {
        parent::__construct($context, $coreRegistry, $entityFactory);
        $this->filter = $filter;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->entityFactory->create()->getCollection());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }
        try {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong. Please try again.'));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
