<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Block\Entity;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Locale\CurrencyInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use ArslanFarrukh\TopBanner\Helper\Data;
use ArslanFarrukh\TopBanner\Helper\ImageHelper;
use ArslanFarrukh\TopBanner\Model\Repository\TemplatesRepository;

class TopBannerImage extends Template
{
    /** @var ImageHelper */
    private $imageHelper;

    /** @var Data */
    private $barDataHelper;

    /** @var TemplatesRepository */
    private $repository;

    /**
     * @param Context $context
     * @param ImageHelper $imageHelper
     * @param TemplatesRepository $templatesRepository
     * @param CurrencyInterface $localeCurrency
     * @param StoreManagerInterface $storeManager
     * @param Data $barDataHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ImageHelper $imageHelper,
        TemplatesRepository $templatesRepository,
        CurrencyInterface $localeCurrency,
        StoreManagerInterface $storeManager,
        Data $barDataHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->imageHelper = $imageHelper;
        $this->localeCurrency = $localeCurrency;
        $this->storeManager = $storeManager;
        $this->barDataHelper = $barDataHelper;
        $this->repository = $templatesRepository;
    }

    /** @return string */
    public function getConfig($config)
    {
        return $this->barDataHelper->getConfig($config);
    }

    /**
     * @return bool|mixed
     * @throws NoSuchEntityException
     */
    public function getTopBannerBar()
    {
        return $this->barDataHelper->getTopBar();
    }

    /**
     * @param $templateId
     * @return array|mixed|null
     * @throws NoSuchEntityException
     */
    public function getTemplateData($templateId)
    {
        return $this->repository->getById($templateId)->getData();
    }

    /**
     * @param $imageName
     * @return string
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getImage($imageName)
    {
        return $this->imageHelper->getImageUrl($imageName);
    }
}
