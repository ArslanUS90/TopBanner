<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;
use ArslanFarrukh\TopBanner\Model\EntityFactory;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity as EntityResource;
use function __;

class Delete extends Entity implements ActionInterface
{
    /** @var EntityResource */
    private $entityResouce;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param EntityFactory $entityFactory
     * @param EntityResource $entityResouce
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        EntityFactory $entityFactory,
        EntityResource $entityResouce
    ) {
        parent::__construct($context, $coreRegistry, $entityFactory);
        $this->entityResouce = $entityResouce;
    }

    /** @return ResponseInterface|ResultInterface|void */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        if ($entityId) {
            try {
                $model = $this->entityFactory->create();
                $this->entityResouce->load($model, $entityId);
                $this->entityResouce->delete($model);
                $this->messageManager->addSuccessMessage(__('The top banner is deleted successfully.'));
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['entity_id' => $entityId]);
                return;
            }
        }
        $this->messageManager->addError(__('We can\'t find a bar to delete.'));
    }
}
