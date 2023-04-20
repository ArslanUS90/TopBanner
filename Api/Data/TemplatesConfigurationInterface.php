<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Api\Data;

interface TemplatesConfigurationInterface
{
    const ID = "entity_id";
    const NAME = "name";
    const BACKGROUND_COLOR = "background_color";
    const FONT_COLOR = "font_color";
    const IMAGE = "image";

    /** @return int */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id);

    /** @return string */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);

    /** @return string */
    public function getBackgroundColor();

    /**
     * @param string $backgroundColor
     * @return void
     */
    public function setBackgroundColor($backgroundColor);

    /** @return string */
    public function getFontColor(): string;

    /**
     * @param string $fontColor
     * @return void
     */
    public function setFontColor($fontColor);

    /** @return string */
    public function getImage(): string;

    /**
     * @param string $image
     * @return void
     */
    public function setImage($image);
}
