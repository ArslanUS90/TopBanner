<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Ui;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration\CollectionFactory;
use ArslanFarrukh\TopBanner\Helper\ImageHelper;

class DataProvider extends AbstractDataProvider
{
    const IMAGE_TMP_PATH = 'arslan_topbanner/tmp/bannertemplates/image';

    const IMAGE_PATH = 'arslan_topbanner/templates/image';

    const FILE_TMP_PATH = 'arslan_topbanner/tmp/bannertemplates/file';

    /** @var ImageHelper */
    private $imageHelper;

    /** @var CollectionFactory */
    protected $collection;

    /** @var array */
    private $loadedData;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ImageHelper $imageHelper
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ImageHelper $imageHelper,
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->imageHelper = $imageHelper;
    }

    /**
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getEntityId()] = $item->getData();
            if ($item->getData('image') != null) {
                $image = [];
                $image[0]['name'] = $item->getData('image');
                $image[0]['url'] = $this->imageHelper->getImageUrl($image[0]['name']);
                $this->loadedData[$item->getEntityId()]['image'] = $image;
            }
        }
        return $this->loadedData;
    }
}
