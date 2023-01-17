<?php

namespace Yohanes\Vendor\Model\ResourceModel;

class Vendor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initial method
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('yohanes_vendor', 'entity_id');
    }
}
