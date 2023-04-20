<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;

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
     * @param PageFactory $pageFactory
     * @param Context $context
     */
    public function __construct(
        PageFactory $pageFactory,
        Context $context
    ) {
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    /** @return ResponseInterface|ResultInterface|Page */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Top Banners"));
        return $resultPage;
    }
}
