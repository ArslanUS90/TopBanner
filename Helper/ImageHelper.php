<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Helper;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use ArslanFarrukh\TopBanner\Model\Uploader;
use ArslanFarrukh\TopBanner\Ui\DataProvider;

class ImageHelper
{
    /** @var Uploader */
    private $uploader;

    /** @param Uploader $uploader */
    public function __construct(
        Uploader $uploader
    ) {
        $this->uploader  = $uploader;
    }

    /**
     * @param string $imagePath
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getImageUrl($imagePath)
    {
        if ($imagePath && is_string($imagePath)) {
            $url = $this->uploader->getBaseUrl() . DataProvider::IMAGE_PATH . DIRECTORY_SEPARATOR . $imagePath;
        } else {
            throw new LocalizedException(
                __('Something went wrong while getting the image url.')
            );
        }
        return $url;
    }
}
