<?php

namespace Yohanes\Vendor\Api;

interface VendorRepositoryInterface
{
    /**
     * Get Vendor
     *
     * @param int $id
     * @return Data\VendorInterface
     */
    public function getById($id);

    /**
     * Save Vendor
     *
     * @param Data\VendorInterface $vendor
     * @return Data\VendorInterface
     */
    public function save($vendor);

    /**
     * Delete Vendor By ID
     *
     * @param int $id
     * @return bool
     */
    public function deleteById($id);
}
