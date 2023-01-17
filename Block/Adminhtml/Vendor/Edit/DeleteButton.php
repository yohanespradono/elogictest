<?php

namespace Yohanes\Vendor\Block\Adminhtml\Vendor\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Block constructor add buttons
     */
    public function _construct()
    {
        $this->addButton(
            'delete_button',
            $this->getButtonData()
        );
        parent::_construct();
    }

    /**
     * Return button attributes in array
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];

        if ($this->getId()) {
            $data = [
                'label' => __('Delete'),
                'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete?') . '\',
                \'' . $this->getDeleteUrl() . '\')',
                'class' => 'delete',
                'sort_order' => 20];
        }

        return $data;
    }

    /**
     * Get Delete URL
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getId()]);
    }
}
