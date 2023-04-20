<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\ResourceModel\Entity\Relation;

use Exception;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\AttributeInterface;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity;

class ReadHandler implements AttributeInterface
{
    /** @var MetadataPool */
    private $metadataPool;

    /** @var Entity */
    private $resourceEntity;

    /**
     * @param MetadataPool $metadataPool
     * @param Entity $resourceEntity
     */
    public function __construct(
        MetadataPool $metadataPool,
        Entity $resourceEntity
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceEntity = $resourceEntity;
    }

    /**
     * @param $entityType
     * @param $entityData
     * @param array $arguments
     * @return array
     * @throws Exception
     */
    public function execute($entityType, $entityData, $arguments = [])
    {
        $linkField = $this->metadataPool->getMetadata($entityType)->getLinkField();
        $entityId = $entityData[$linkField];

        $entityData['store_id'] = $this->resourceEntity->lookupStoreIds($entityId);
        $entityData['customer_group_id'] = $this->resourceEntity->lookupCustomerGroupIds($entityId);

        return $entityData;
    }
}
