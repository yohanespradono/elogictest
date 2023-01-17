<?php

namespace Yohanes\Vendor\Api\Data;

interface VendorInterface
{
    public const ID = 'id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const IMAGE = 'image';

    /**
     * Get Vendor ID
     *
     * @return int
     */
    public function getId();

    /**
     * Get Vendor Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get Vendor Description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get Vendor Image
     *
     * @return string
     */
    public function getImage();

    /**
     * Set Vendor ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set Vendor Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Set Vendor Description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Set Vendor Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image);
}
