<?php

namespace Yohanes\Vendor\Controller\Adminhtml\Vendor;

use Yohanes\Vendor\Api\VendorRepositoryInterface;

class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;

    /**
     * @var VendorRepositoryInterface
     */
    protected $vendorRepository;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request,
        VendorRepositoryInterface $vendorRepository
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->vendorRepository = $vendorRepository;
        return parent::__construct($context);
    }

    /**
     * Main method
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->_request->getParam('id');
        $this->vendorRepository->deleteById($id);
        return $this->_redirect('vendor/vendor/index');
    }
}
