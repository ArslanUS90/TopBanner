<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;

use function __;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use ArslanFarrukh\TopBanner\Controller\Adminhtml\Entity;
use ArslanFarrukh\TopBanner\Model\EntityFactory;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity as EntityResource;

class Save extends Entity implements HttpPostActionInterface
{
    /** @var DateTime */
    private $dateTime;

    /** @var EntityResource */
    private $entityResource;

    /** @var ResourceConnection */
    private $resourceConnection;

    /** @var CollectionFactory */
    private $collectionFactory;

    /** @var TypeListInterface */
    private $typeList;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param EntityFactory $entityFactory
     * @param DateTime $dateTime
     * @param EntityResource $entityResource
     * @param ResourceConnection $resourceConnection
     * @param CollectionFactory $collectionFactory
     * @param TypeListInterface $typeList
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        EntityFactory $entityFactory,
        DateTime $dateTime,
        EntityResource $entityResource,
        ResourceConnection $resourceConnection,
        CollectionFactory $collectionFactory,
        TypeListInterface $typeList
    ) {
        parent::__construct($context, $coreRegistry, $entityFactory);
        $this->dateTime = $dateTime;
        $this->entityResource = $entityResource;
        $this->resourceConnection = $resourceConnection;
        $this->collectionFactory = $collectionFactory;
        $this->typeList = $typeList;
    }

    /** @return ResponseInterface|ResultInterface|void */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $data['from_date'] = $this->dateTime->date(
            \Magento\Framework\Stdlib\DateTime::DATE_PHP_FORMAT,
            $data['from_date']
        );
        if ($data['to_date'] != "") {
            $data['to_date'] = $this->dateTime->date(
                \Magento\Framework\Stdlib\DateTime::DATE_PHP_FORMAT,
                $data['to_date']
            );
        }
        if (isset($data['store_id'])) {
            $data['store_id'] = implode(',', $data['store_id'] ?? []);
        }
        $data['bar_layout_position'] = 'page_top';
        if ($data) {
            try {
                if (empty($data['entity_id'])) {
                    unset($data['entity_id']);
                }
                /** @var $model \ArslanFarrukh\TopBanner\Model\Entity */
                $model = $this->entityFactory->create();
                $entityId = (int)$this->getRequest()->getParam('entity_id');
                if ($entityId) {
                    $this->entityResource->load($model, $entityId);
                }
                $model->setData($data);
                $this->entityResource->save($model);

                $connection = $this->resourceConnection->getConnection();
                $customerGroups = $this->collectionFactory->create();

                if ($entityId) {
                    $query = $connection->select()->from('arslan_top_banner_bar_customer_group', ['customer_group_id'])
                        ->where('entity_id = ?', $entityId);
                    $result = $connection->fetchCol($query);
                    foreach ($customerGroups as $customerGroup) {
                        if (!in_array($customerGroup->getId(), $result)) {
                            $array = [
                                'entity_id' => $entityId,
                                'customer_group_id' => $customerGroup->getId()
                            ];
                            $connection->insert('arslan_top_banner_bar_customer_group', $array);
                        }
                    }
                } else {
                    $query = $connection->select()->from('arslan_top_banner_bar', ['entity_id'])
                        ->order('entity_id DESC')
                        ->limit(1);
                    $result = $connection->fetchCol($query);
                    foreach ($customerGroups as $customerGroup) {
                        $array = [
                            'entity_id' => $result[0],
                            'customer_group_id' => $customerGroup->getId()
                        ];
                        $connection->insert('arslan_top_banner_bar_customer_group', $array);
                    }
                }
                $this->typeList->cleanType("full_page");
                $this->messageManager->addSuccessMessage(__('The Top Banner bar is saved successfully.'));
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the Top Banner data. Please review the error log.')
                );
                $this->_redirect('*/*/edit', ['entity_id' => (int)$this->getRequest()->getParam('entity_id')]);
                return;
            }
        }
    }
}
