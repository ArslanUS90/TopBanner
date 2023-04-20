<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use ArslanFarrukh\TopBanner\Helper\Data;
use ArslanFarrukh\TopBanner\Model\EntityFactory;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity;

class Edit extends Action
{
    const REGISTRY_KEY_CURRENT_ENTITY = 'row_data';

    /** @var PageFactory */
    private $resultPageFactory;

    /** @var Data */
    private $data;

    /** @var EntityFactory */
    private $entityFactory;

    /** @var Registry */
    private $coreRegistry;

    /** @var Entity */
    private $entityResource;

    /**
     * @param Context $context
     * @param Data $data
     * @param EntityFactory $entityFactory
     * @param Registry $coreRegistry
     * @param Entity $entityResource
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Data $data,
        EntityFactory $entityFactory,
        Registry $coreRegistry,
        Entity $entityResource,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->data = $data;
        $this->entityFactory = $entityFactory;
        $this->coreRegistry = $coreRegistry;
        $this->entityResource = $entityResource;
        $this->resultPageFactory = $resultPageFactory;
    }

    /** @return ResponseInterface|Redirect|ResultInterface|void */
    public function execute()
    {
        if ($this->data->getConfig('arslan_top_banner_bar/general/enable') == 0) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('admin/dashboard/index', ['_current' => true]);
        }

        $entityId = $this->getRequest()->getParam('entity_id');
        /** @var $model \ArslanFarrukh\TopBanner\Model\Entity */
        $model = $this->entityFactory->create();
        if ($entityId) {
            $this->entityResource->load($model, $entityId);
            if (!$model->getEntityId()) {
                $this->messageManager->addErrorMessage(__('This Top Banner bar no longer exist.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->coreRegistry->register(self::REGISTRY_KEY_CURRENT_ENTITY, $model);
        $resultPage = $this->resultPageFactory->create();
        $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(
            isset($model) && $model->getEntityId() ? __('Edit %1', $model->getName()) :
                __('New Top Banner')
        );

        return $resultPage;
    }

    /** @return $this */
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Magento_Backend::marketing')
            ->_addBreadcrumb(__('ArslanFarrukh Top Banner'), __('ArslanFarrukh Top Banner'));
        return $this;
    }
}
