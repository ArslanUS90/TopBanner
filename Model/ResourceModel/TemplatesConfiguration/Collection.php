<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration;

use ArslanFarrukh\TopBanner\Api\Data\TemplatesConfigurationInterface;
use ArslanFarrukh\TopBanner\Model\ResourceModel\TemplatesConfiguration as ResourceModel;
use ArslanFarrukh\TopBanner\Model\TemplatesConfiguration as Model;
use Magento\Catalog\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = TemplatesConfigurationInterface::ID;

    /** @inheirtDoc */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(Model::class, ResourceModel::class);
    }
}
