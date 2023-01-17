<?php

namespace Yohanes\Vendor\Model\ResourceModel\Vendor;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Which column represent the key?
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Event name prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'yohanes_vendor_vendor_collection';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'vendor_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Yohanes\Vendor\Model\Vendor::class, \Yohanes\Vendor\Model\ResourceModel\Vendor::class);
    }
}
