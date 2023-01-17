<?php

namespace Yohanes\Vendor\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Yohanes\Vendor\Api\Data\VendorInterface;

class Vendor extends AbstractModel implements IdentityInterface, VendorInterface
{
    public const CACHE_TAG = 'yohanes_vendor_vendor';

    /**
     * Cache identifier
     *
     * @var string
     */
    protected $_cacheTag = 'yohanes_vendor_vendor';

    /**
     * Event name prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'yohanes_vendor_vendor';

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Yohanes\Vendor\Model\ResourceModel\Vendor::class);
    }

    /**
     * Cache identifier for single entity
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
}
