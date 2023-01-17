<?php

namespace Yohanes\Vendor\Model;

use Magento\Eav\Model\Entity\Attribute\Exception as AttributeException;
use Magento\Framework\DB\Adapter\ConnectionException;
use Magento\Framework\DB\Adapter\DeadlockException;
use Magento\Framework\DB\Adapter\LockWaitException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException as TemporaryCouldNotSaveException;
use Magento\Framework\Exception\ValidatorException;
use Yohanes\Vendor\Model\ResourceModel\Vendor as VendorResourceModel;
use Yohanes\Vendor\Model\VendorFactory;

class VendorRepository implements \Yohanes\Vendor\Api\VendorRepositoryInterface
{

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var VendorResourceModel
     */
    protected $resourceModel;

    /**
     * Constructor
     *
     * @param VendorFactory $vendorFactory
     * @param VendorResourceModel $resourceModel
     */
    public function __construct(
        VendorFactory $vendorFactory,
        VendorResourceModel $resourceModel
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->resourceModel = $resourceModel;
    }
    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        // @TODO we can implement cache here
        $vendor = $this->vendorFactory->create();

        $vendor->load($id);
        if (!$vendor->getId()) {
            throw new NoSuchEntityException(
                __("The vendor that was requested doesn't exist. Verify the vendor and try again.")
            );
        }

        return $vendor;
    }

    /**
     * @inheritDoc
     */
    public function save($vendor)
    {
        try {
            $this->resourceModel->save($vendor);
        } catch (ConnectionException $exception) {
            throw new TemporaryCouldNotSaveException(
                __('Database connection error'),
                $exception,
                $exception->getCode()
            );
        } catch (DeadlockException $exception) {
            throw new TemporaryCouldNotSaveException(
                __('Database deadlock found when trying to get lock'),
                $exception,
                $exception->getCode()
            );
        } catch (LockWaitException $exception) {
            throw new TemporaryCouldNotSaveException(
                __('Database lock wait timeout exceeded'),
                $exception,
                $exception->getCode()
            );
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The vendor was unable to be saved. Please try again.'),
                $e
            );
        }

        // @TODO: force reload for now. use Cache later
        $vendorId = $vendor->getId();
        $vendor = $this->vendorFactory->create();
        $vendor->load($vendorId);
        return $vendor;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): bool
    {
        $vendor = $this->getById($id);
        try {
            $this->resourceModel->delete($vendor);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()), $e);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('The vendor with ID:"%1" couldn\'t be removed.', $id),
                $e
            );
        }

        return true;
    }
}
