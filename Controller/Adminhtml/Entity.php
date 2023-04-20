<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use ArslanFarrukh\TopBanner\Model\EntityFactory;
use function __;

abstract class Entity extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ArslanFarrukh_TopBanner::top_banner_management';

    /** @var Registry */
    protected $coreRegistry;

    /** @var EntityFactory */
    protected $entityFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        EntityFactory $entityFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->entityFactory = $entityFactory;
    }

    /** @return $this */
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Magento_Backend::marketing')
            ->_addBreadcrumb(__('ArslanFarrukh Top Banner'), __('ArslanFarrukh Top Banner'));
        return $this;
    }
}
