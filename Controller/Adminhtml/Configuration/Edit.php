<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Configuration;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterface;
use ArslanFarrukh\TopBanner\Model\Repository\TemplatesRepository;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'ArslanFarrukh_TopBanner::configuration';

    /** @var PageFactory */
    private $resultPageFactory;

    /** @var TemplatesRepository */
    private $templatesRepository;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param TemplatesRepository $templatesRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        TemplatesRepository $templatesRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $pageFactory;
        $this->templatesRepository = $templatesRepository;
    }

    /** @return ResponseInterface|Redirect|ResultInterface|Page */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam(TemplatesConfigurationInterface::ID);
        $configuration = null;

        if (isset($id)) {
            try {
                $configuration = $this->templatesRepository->getById((int)$id);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }

        $resultPage->getConfig()->getTitle()->prepend(
            isset($configuration) ? __('Edit Top Banner Template Design %1', $configuration->getId()) :
                __('New Top Banner Template')
        );

        empty($params['entity_id']) ? $resultPage->getConfig()->getTitle()->set(
            __('Create New Top Banner Template')
        ) : $resultPage->getConfig()->getTitle()->set(
            __('Edit Top Banner Template Design')
        );

        return $resultPage;
    }
}
