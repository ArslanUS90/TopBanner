<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\Entity\Source;

use Magento\Framework\Data\OptionSourceInterface;
use ArslanFarrukh\TopBanner\Model\Entity;
use function __;

class Status implements OptionSourceInterface
{
    const STATUS_DISABLED = 0;

    const STATUS_ENABLED = 1;

    /** @var Entity */
    private $entity;

    /** @param Entity $entity */
    public function __construct(
        Entity $entity
    ) {
        $this->entity = $entity;
    }

    /** @return array */
    public function toOptionArray()
    {
        $options = [];
        foreach (self::getOptionArray() as $index => $value) {
            $options[] = ['value' => $index, 'label' => $value];
        }
        return $options;
    }

    /** @return array */
    public function getOptionArray()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
