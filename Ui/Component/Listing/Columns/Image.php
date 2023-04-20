<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Ui\Component\Listing\Columns;

use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Image extends Column
{
    /** @var StoreManagerInterface */
    private $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param ImageHelper $imageHelper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $filename = $item[$fieldName];
                $url = $this->storeManager->getStore()->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . "arslan_topbanner/templates/image" . $filename;
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_orig_src'] = $url;
            }
        }
        return $dataSource;
    }
}
