<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use ArslanFarrukh\TopBanner\Api\Data\EntityInterface;

class Entity extends AbstractModel implements EntityInterface, IdentityInterface
{
    const CACHE_TAG = 'arslan_top_banner_bar_entity';

    protected $_eventPrefix = 'arslan_top_banner_bar_entity';

    protected $_eventObject = 'entity';

    /** @return void */
    protected function _construct()
    {
        $this->_init(ResourceModel\Entity::class);
    }

    /** @return array */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /** @return int */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /** @return string */
    public function getName()
    {
        return $this->getData(self::ENTITY_NAME);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        return $this->setData(self::ENTITY_NAME, $name);
    }

    /**
     * @param string $fromDate
     * @return $this
     */
    public function setFromDate($fromDate)
    {
        return $this->setData(self::FROM_DATE, $fromDate);
    }

    /** @return string|null */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /** @return string|null */
    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    /**
     * @param string $toDate
     * @return $this
     */
    public function setToDate($toDate)
    {
        return $this->setData(self::TO_DATE, $toDate);
    }

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function isActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * @param bool $isActive
     * @return Entity
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /** @return int */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /** @return string */
    public function getDisplayText()
    {
        return $this->getData(self::DISPLAY_TEXT);
    }

    /**
     * @param string $displayText
     * @return $this
     */
    public function setDisplayText($displayText)
    {
        return $this->setData(self::DISPLAY_TEXT, $displayText);
    }

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function isClickable()
    {
        return $this->getData(self::IS_CLICKABLE);
    }

    /**
     * @param bool isClickable
     * @return Entity
     */
    public function setIsClickable($isClickable)
    {
        return $this->setData(self::IS_CLICKABLE, $isClickable);
    }

    /** @return string */
    public function getBarLinkUrl()
    {
        return $this->getData(self::BAR_LINK_URL);
    }

    /**
     * @param string $barLinkUrl
     * @return $this
     */
    public function setBarLinkUrl($barLinkUrl)
    {
        return $this->setData(self::BAR_LINK_URL, $barLinkUrl);
    }

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function isLinkOpenInNewPage()
    {
        return $this->getData(self::IS_LINK_OPEN_IN_NEW_PAGE);
    }

    /**
     * @param bool $isLinkOpenInNewPage
     * @return Entity
     */
    public function setIsLinkOpenInNewPage($isLinkOpenInNewPage)
    {
        return $this->setData(self::IS_LINK_OPEN_IN_NEW_PAGE, $isLinkOpenInNewPage);
    }

    /** @return string */
    public function getBarLayoutPosition()
    {
        return $this->getData(self::BAR_LAYOUT_POSITION);
    }

    /**
     * @param string $barLayoutPosition
     * @return $this
     */
    public function setBarLayoutPosition($barLayoutPosition)
    {
        return $this->setData(self::BAR_LAYOUT_POSITION, $barLayoutPosition);
    }

    /** @return array|mixed|string|null */
    public function getLinkText()
    {
        return $this->getData(self::LINK_TEXT);
    }

    /**
     * @param $linkText
     * @return Entity|string
     */
    public function setLinkText($linkText)
    {
        return $this->setData(self::LINK_TEXT, $linkText);
    }

    /** @return array|mixed|string|null */
    public function getBannerTemplate()
    {
        return $this->getData(self::BANNER_TEMPLATE);
    }

    /**
     * @param string $bannerTemplate
     * @return $this
     */
    public function setBannerTemplate(string $bannerTemplate)
    {
        return $this->setData(self::BANNER_TEMPLATE, $bannerTemplate);
    }
}
