<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Helper;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\StoreManagerInterface;
use ArslanFarrukh\TopBanner\Model\EntityFactory;

class Data extends AbstractHelper
{
    /** @var EntityFactory */
    private $entityFactory;

    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var CustomerSession */
    private $customerSession;

    /** @var HttpContext */
    private $httpContext;

    /** @var ResourceConnection */
    private $resourceConnection;

    /**
     * Data constructor.
     * @param Context $context
     * @param EntityFactory $entityFactory
     * @param StoreManagerInterface $storeManager
     * @param CustomerSession $customerSession
     * @param HttpContext $httpContext
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Context $context,
        EntityFactory $entityFactory,
        StoreManagerInterface $storeManager,
        CustomerSession $customerSession,
        HttpContext $httpContext,
        ResourceConnection $resourceConnection
    ) {
        parent::__construct($context);
        $this->entityFactory = $entityFactory;
        $this->storeManager =  $storeManager;
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $config
     * @return mixed
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue($config, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param $entityId
     * @return AbstractDb|AbstractCollection|null
     */
    public function getTopBarCollection($entityId = null)
    {
        $barEntity = $this->entityFactory->create();
        $collection = $barEntity->getCollection();
        if ($entityId) {
            $topBannerStoreTable = $this->resourceConnection->getTableName('arslan_top_banner_bar_store');
            $topBannerCustomerGroupTable = $this->resourceConnection->getTableName('arslan_top_banner_bar_customer_group');

            $collection
                ->join(
                    ['st'=>$topBannerStoreTable],
                    "main_table.entity_id = st.entity_id"
                )
                ->join(
                    ['ct' => $topBannerCustomerGroupTable],
                    "main_table.entity_id = ct.entity_id"
                )
                ->addFieldToFilter('main_table.entity_id', ['eq' => $entityId])
                ->addFieldToFilter('main_table.from_date', ['lteq' => date("Y-m-d")])
                ->addFieldToFilter('main_table.to_date', [['null' => true],['gteq' => date("Y-m-d")]])
                ->addFieldToFilter('main_table.is_active', ['eq' => 1]);
        } else {
            $collection->addFieldToFilter('from_date', ['lteq' => date("Y-m-d")])
                ->addFieldToFilter(
                    'to_date',
                    [['null' => true], ['gteq' => date("Y-m-d")], ['eq' => "0000-00-00"]]
                )
                ->addFieldToFilter('is_active', ['eq' => 1])
                ->setOrder('sort_order', 'ASC');
        }
        return $collection;
    }

    /**
     * @return array|false
     * @throws NoSuchEntityException
     */
    public function getTopBar()
    {
        $collection = $this->getTopBarCollection();
        if ($collection->getData()) {
            foreach ($collection as $barItem) {
                if ($this->isStoreMatched($barItem['store_id']) &&
                    $this->isCustomerGroupMatched($barItem['customer_group_id'])) {
                    return $barItem->getData();
                }
            }
        }
        return false;
    }

    /**
     * @param $storeId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isStoreMatched($storeId)
    {
        $currentStoreId =  $this->storeManager->getStore()->getId();
        if (in_array(0, $storeId) || in_array($currentStoreId, $storeId)) {
            return true;
        }
        return false;
    }

    /**
     * @param $customerGroupId
     * @return bool
     */
    public function isCustomerGroupMatched($customerGroupId)
    {
        $isLoggedIn = $this->customerSession->isLoggedIn() ? $this->customerSession->isLoggedIn() : $this->isLoggedIn();
        $currentCustomerGroupId = $isLoggedIn ? $this->customerSession->getCustomer()->getGroupId() : 0;
        if (in_array($currentCustomerGroupId, $customerGroupId)) {
            return true;
        }
        return false;
    }

    /** @return bool */
    public function isLoggedIn()
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
