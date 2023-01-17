<?php

namespace Yohanes\Vendor\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;

use Yohanes\Vendor\Api\VendorRepositoryInterface;
use Yohanes\Vendor\Model\VendorFactory;

class Save extends Action implements HttpPostActionInterface
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Yohanes_Vendor::vendor_create';

    /**
     * @var VendorRepositoryInterface
     */
    protected $vendorRepository;

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * Magento Catalog Image uploader
     *
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Constructor
     *
     * @param Context $context
     * @param VendorRepositoryInterface $vendorRepository
     * @param VendorFactory $vendorFactory
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        VendorRepositoryInterface $vendorRepository,
        VendorFactory $vendorFactory,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->vendorRepository = $vendorRepository;
        $this->vendorFactory = $vendorFactory;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $vendor = $this->getRequest()->getParam('yohanes_vendor_vendor');

            if (array_key_exists('entity_id', $vendor)) {
                $model = $this->vendorRepository->getById($vendor['entity_id']);
            } else {
                $model = $this->vendorFactory->create();
            }

            if (isset($vendor['image']) && count($vendor['image'])) {
                if (!empty($vendor['image'][0]['file'])) {// new file upload
                    $this->imageUploader->moveFileFromTmp($vendor['image'][0]['name']);
                }
                $vendor['image'] = $vendor['image'][0]['name'];
            }

            $model->setData($vendor);
            $model = $this->vendorRepository->save($model);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
