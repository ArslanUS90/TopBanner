<?php declare(strict_types=1);

namespace ArslanFarrukh\TopBanner\Ui\Component\Listing\Column;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use ArslanFarrukh\TopBanner\Model\Repository\TemplatesRepository;

class TemplateSource extends AbstractSource
{
    /** @var TemplatesRepository */
    private $repository;

    /** @param TemplatesRepository $repository */
    public function __construct(
        TemplatesRepository $repository
    ) {
        $this->repository = $repository;
    }

    /** @return array */
    public function getAllOptions()
    {
        $collection = $this->repository->getList();
        $items = $collection->getItems();
        $names = [];

        foreach ($items as $item) {
            $name = [
                'label' => __($item->getName()),
                'value' => $item->getEntityId()
            ];
            $names[] = $name;
        }

        return $names;
    }
}
