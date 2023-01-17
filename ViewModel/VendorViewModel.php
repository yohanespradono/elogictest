<?php

namespace Yohanes\Vendor\ViewModel;

use Magento\Store\Model\StoreManagerInterface;
use Yohanes\Vendor\Api\VendorRepositoryInterface;
use Yohanes\Vendor\Model\Vendor as VendorModel;

class VendorViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    /**
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /**
     * @var VendorRepositoryInterface
     */
    public $vendorRepository;

    /**
     * @var VendorModel
     */
    public $vendor;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param \Magento\Framework\Registry $registry
     * @param VendorRepositoryInterface $vendorRepository
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        VendorRepositoryInterface $vendorRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->registry = $registry;
        $this->vendorRepository = $vendorRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * Get Viewed Product Model Object
     *
     * @return \Magento\Catalog\Model\Product|\Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct()
    {
        $product = $this->registry->registry('current_product');
        if ($vendorId = $product->getVendorId()) {
            $this->vendor = $this->vendorRepository->getById($vendorId);
        }
        return $this->registry->registry('current_product');
    }

    /**
     * Get Vendor Model
     *
     * @return VendorModel
     */
    public function getVendor()
    {
        if ($this->vendor === null) {
            $this->getProduct();
        }
        return $this->vendor;
    }

    /**
     * Get Vendor Name
     *
     * @return string
     */
    public function getName()
    {
        if ($this->vendor === null) {
            $this->getProduct();
        }
        return $this->vendor->getName();
    }

    /**
     * Get Vendor Description
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->vendor === null) {
            $this->getProduct();
        }
        return $this->vendor->getDescription();
    }

    /**
     * Get Vendor Image URL
     *
     * @return string
     */
    public function getImageUrl()
    {
        if ($this->vendor === null) {
            $this->getProduct();
        }
        return $this->getMediaUrl().$this->vendor->getImage();
    }

    /**
     * Get Magento Media URL
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'vendor/image/';

        return $mediaUrl;
    }
}
