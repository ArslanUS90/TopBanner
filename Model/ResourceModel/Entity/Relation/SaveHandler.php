<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\ResourceModel\Entity\Relation;

use Exception;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\AttributeInterface;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity;

class SaveHandler implements AttributeInterface
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
        if (isset($entityData['store_id'])) {
            $storeIds = $entityData['store_id'];
            if (!is_array($storeIds)) {
                $storeIds = explode(',', (string)$storeIds);
            }
            $this->resourceEntity->bindBarToEntity($entityData[$linkField], $storeIds, 'store');
        }

        if (isset($entityData['customer_group_id'])) {
            $customerGroupIds = $entityData['customer_group_id'];
            if (!is_array($customerGroupIds)) {
                $customerGroupIds = explode(',', (string)$customerGroupIds);
            }
            $this->resourceEntity->bindBarToEntity($entityData[$linkField], $customerGroupIds, 'customer_group');
        }
        return $entityData;
    }
}
