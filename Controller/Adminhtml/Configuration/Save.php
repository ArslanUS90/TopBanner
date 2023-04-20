<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Configuration;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterfaceFactory;
use ArslanFarrukh\TopBanner\Model\Repository\TemplatesRepository;
use ArslanFarrukh\TopBanner\Model\Uploader;

class Save extends Action
{
    /** @var TemplatesConfigurationInterfaceFactory */
    private $templateConfigurationFactory;

    /** @var TemplatesRepository */
    private $templatesRepository;

    /** @var Redirect */
    private $redirectResult;

    /** @var Uploader */
    private $uploader;

    /** @var TypeListInterface */
    private $typeList;

    /**
     * @param TemplatesConfigurationInterfaceFactory $templatesConfigurationInterfaceFactory
     * @param TemplatesRepository $repository
     * @param TypeListInterface $typeList
     * @param Redirect $redirect
     * @param Uploader $uploader
     * @param Context $context
     */
    public function __construct(
        TemplatesConfigurationInterfaceFactory $templatesConfigurationInterfaceFactory,
        TemplatesRepository $repository,
        TypeListInterface $typeList,
        Redirect $redirect,
        Uploader $uploader,
        Context $context
    ) {
        parent::__construct($context);
        $this->typeList = $typeList;
        $this->redirectResult = $redirect;
        $this->templateConfigurationFactory = $templatesConfigurationInterfaceFactory;
        $this->templatesRepository = $repository;
        $this->uploader = $uploader;
    }

    /** @return bool */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('ArslanFarrukh_TopBanner::configuration');
    }

    /** @return ResponseInterface|Redirect|ResultInterface */
    public function execute()
    {
        try {
            $this->redirectResult = $this->resultRedirectFactory->create();
            $postData = $this->getRequest()->getPostValue();
            if (isset($postData['image'])) {
                if (isset($postData['image'][0]['file'])) {
                    $this->uploader->moveFileFromTmp($postData['image'][0]['file']);
                    $postData['image'] = $postData['image'][0]['file'];
                } else {
                    $postData['image'] = $postData['image'][0]['name'];
                }
            } else {
                $postData['image'] = null;
            }

            $configuration = $this->templateConfigurationFactory->create();
            $configuration->addData($postData);

            $this->templatesRepository->save($configuration);
            $this->typeList->cleanType("full_page");
            $this->messageManager->addSuccessMessage(
                __('Top Banner Template Design has been saved')
            );

            return $this->redirectResult->setPath('*/*/');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (Exception $exception) {
            $this->messageManager->addExceptionMessage(
                $exception,
                __('Something went wrong while saving the record.')
            );
        }
        $this->messageManager->addErrorMessage(
            __('Something went wrong while saving the record. Please Try Again')
        );

        return $this->redirectResult->setPath('*/*/');
    }
}
