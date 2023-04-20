<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Configuration;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /** @var PageFactory */
    private $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /** @return bool */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ArslanFarrukh_TopBanner::configuration');
    }

    /** @return ResponseInterface|ResultInterface|Page */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'ArslanFarrukh_TopBanner::configuration'
        );
        $resultPage->getConfig()->getTitle()->prepend(
            __('Top Banner Template Configuration')
        );

        return $resultPage;
    }
}
