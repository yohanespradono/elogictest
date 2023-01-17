<?php

namespace Yohanes\Vendor\Model\Vendor;

use Magento\Store\Model\StoreManagerInterface;
use Yohanes\Vendor\Model\ResourceModel\Vendor\CollectionFactory;
use Yohanes\Vendor\Model\Vendor;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $vendorCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $vendorCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $vendorCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get vendor data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];
        /** @var Vendor $vendor */
        foreach ($items as $vendor) {
            if ($vendor->getImage()) {
                $image[0]['name'] = $vendor->getImage();
                $image[0]['url'] = $this->getMediaUrl().$vendor->getImage();
            }
            $this->loadedData[$vendor->getId()]['yohanes_vendor_vendor'] = $vendor->getData();
            if (isset($image)) {
                $this->loadedData[$vendor->getId()]['yohanes_vendor_vendor']['image'] = $image;
            }
        }

        return $this->loadedData;
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
