<?php

namespace Yohanes\Vendor\Model\Attribute\Source\Vendor;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;

class Options extends AbstractSource implements OptionSourceInterface
{
    /**
     * @var \Yohanes\Vendor\Model\ResourceModel\Vendor\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Constructor
     *
     * @param \Yohanes\Vendor\Model\ResourceModel\Vendor\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Yohanes\Vendor\Model\ResourceModel\Vendor\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $collection = $this->collectionFactory->create();
            foreach ($collection as $item) {
                $this->_options[] = ['value' => $item->getEntityId(), 'label' => $item->getName()];
            }
        }
        return $this->_options;
    }
}
