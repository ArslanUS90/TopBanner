<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Api\Data;

interface EntityInterface
{
    const ENTITY_ID = 'entity_id';
    const ENTITY_NAME = 'name';
    const FROM_DATE = 'from_date';
    const TO_DATE = 'to_date';
    const DISPLAY_TEXT = 'display_text';
    const IS_CLICKABLE = 'is_clickable';
    const LINK_TEXT = 'link_text';
    const BAR_LINK_URL = 'bar_link_url';
    const IS_LINK_OPEN_IN_NEW_PAGE = 'is_link_open_in_new_page';
    const BANNER_TEMPLATE = 'banner_templates';
    const BAR_LAYOUT_POSITION = 'bar_layout_position';
    const IS_ACTIVE = 'is_active';
    const SORT_ORDER = 'sort_order';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /** @return int */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId);

    /** @return string */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /** @return string */
    public function getFromDate();

    /**
     * @param string $fromDate
     * @return $this
     */
    public function setFromDate(string $fromDate);

    /** @return string */
    public function getToDate();

    /**
     * @param string $toDate
     * @return $this
     */
    public function setToDate(string $toDate);

    /** @return string */
    public function getDisplayText();

    /**
     * @param string $displayText
     * @return $this
     */
    public function setDisplayText(string $displayText);

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function isClickable();

    /**
     * @param bool $isClickable
     * @return $this
     */
    public function setIsClickable(bool $isClickable);

    /** @return string */
    public function getLinkText();

    /**
     * @param string $linkText
     * @return $this
     */
    public function setLinkText(string $linkText);

    /** @return string */
    public function getBarLinkUrl();

    /**
     * @param string $barLinkUrl
     * @return $this
     */
    public function setBarLinkUrl(string $barLinkUrl);

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function isLinkOpenInNewPage();

    /**
     * @param bool $isLinkOpenInNewPage
     * @return $this
     */
    public function setIsLinkOpenInNewPage(bool $isLinkOpenInNewPage);

    /** @return string */
    public function getBannerTemplate();

    /**
     * @param string $bannerTemplate
     * @return $this
     */
    public function setBannerTemplate(string $bannerTemplate);

    /** @return string */
    public function getBarLayoutPosition();

    /**
     * @param string $barLayoutPosition
     * @return $this
     */
    public function setBarLayoutPosition(string $barLayoutPosition);

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function isActive();

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive);

    /** @return int */
    public function getSortOrder();

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder(int $sortOrder);

    /** @return string */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt);

    /** @return string */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);
}
