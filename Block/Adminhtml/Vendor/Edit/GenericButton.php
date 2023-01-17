<?php

namespace Yohanes\Vendor\Block\Adminhtml\Vendor\Edit;

use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class GenericButton extends Container
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Contructor
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        $id = $this->registry->registry('editRecordId');
        return $id ? $id : null;
    }

    /**
     * Get URL
     *
     * @param string $route
     * @param array $param
     *
     * @return string
     */
    public function getUrl($route = '', $param = [])
    {
        return $this->urlBuilder->getUrl($route, $param);
    }
}
