<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\ResourceModel\Entity;

use Exception;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use ArslanFarrukh\TopBanner\Api\Data\EntityInterface;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'entity_id';

    /** @var MetadataPool */
    private $metadataPool;

    /** @var Entity */
    private $resourceEntity;

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param MetadataPool $metadataPool
     * @param Entity $resourceEntity
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface    $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        MetadataPool $metadataPool,
        Entity $resourceEntity,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceEntity = $resourceEntity;
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
    }

    /** @return void */
    protected function _construct()
    {
        $this->_init(
            \ArslanFarrukh\TopBanner\Model\Entity::class,
            Entity::class
        );
    }

    /**
     * @return AbstractCollection
     * @throws Exception
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(EntityInterface::class);
        $this->performAfterLoad($entityMetadata->getLinkField(), 'store');
        $this->performAfterLoad($entityMetadata->getLinkField(), 'customer_group');
        return parent::_afterLoad();
    }

    /**
     * @param $linkField
     * @param $entityType
     * @return $this
     * @throws Exception
     */
    protected function performAfterLoad($linkField, $entityType)
    {
        $linkedFieldIds = $this->getColumnValues($linkField);
        if (count($linkedFieldIds)) {
            $result = $this->resourceEntity->getAssociatedEntityIds($linkedFieldIds, $entityType, 1);
            if ($result) {
                $entityId = $entityType . '_id';
                $storesData = [];
                foreach ($result as $storeData) {
                    $storesData[$storeData[$linkField]][] = $storeData[$entityId];
                }
                foreach ($this as $item) {
                    $linkedFieldId = $item->getData($linkField);
                    if (!isset($storesData[$linkedFieldId])) {
                        continue;
                    }
                    $item->setData($entityId, $storesData[$linkedFieldId]);
                }
            }
        }

        return $this;
    }
}
