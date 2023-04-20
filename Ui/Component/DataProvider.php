<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Ui\Component;

use Magento\Ui\DataProvider\AbstractDataProvider;
use ArslanFarrukh\TopBanner\Model\ResourceModel\Entity\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /** @var CollectionFactory */
    protected $collection;

    /** @var array */
    private $loadedData;

    /**
     * @param CollectionFactory $collectionFactory
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
    }

    /** @return array */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            if ($item->getData('to_date') == "0000-00-00") {
                $item->setData('to_date', "");
            }
            $this->loadedData[$item->getData('entity_id')] = $item->getData();
        }

        return $this->loadedData;
    }

}
