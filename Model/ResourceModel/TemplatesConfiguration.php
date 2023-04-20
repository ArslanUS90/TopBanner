<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterface;

class TemplatesConfiguration extends AbstractDb
{
    const MAIN_TABLE = "arslan_top_banner_templates";

    /** @var string */
    protected $_idFieldName = TemplatesConfigurationInterface::ID;

    /** @inheirtDoc */
    protected function _construct()
    {
        $this->_init(
            self::MAIN_TABLE,
            TemplatesConfigurationInterface::ID
        );
    }
}
