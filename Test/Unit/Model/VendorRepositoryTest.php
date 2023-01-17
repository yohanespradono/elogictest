<?php

namespace Yohanes\Vendor\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yohanes\Vendor\Model\VendorRepository;

class VendorRepositoryTest extends TestCase
{
    /**
     * Test subject.
     *
     * @var VendorRepository
     */
    protected $vendorRepository;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Yohanes\Vendor\Model\ResourceModel\Vendor|(\Yohanes\Vendor\Model\ResourceModel\Vendor&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected $vendorResourceModelMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Yohanes\Vendor\Model\VendorFactory|(\Yohanes\Vendor\Model\VendorFactory&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected $vendorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Yohanes\Vendor\Model\VendorFactory|(\Yohanes\Vendor\Model\VendorFactory&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected $vendorFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->objectManager = new ObjectManager($this);
        $this->vendorResourceModelMock = $this->createMock(\Yohanes\Vendor\Model\ResourceModel\Vendor::class);
        $this->vendorFactoryMock = $this->createPartialMock(
            \Yohanes\Vendor\Model\VendorFactory::class,
            ['create']
        );
        $this->vendorMock = $this->getMockBuilder(
            \Yohanes\Vendor\Model\Vendor::class,
        )->setMethods([
            'load',
            'getId'
        ])->disableOriginalConstructor()->getMock();
        $data = [
            'id' => 1,
            'name' => 'Yohanes Pradono',
            'description' => "Lorem ipsum dolor sit amet",
            'image' => 'yohanes.png'
        ];

        $this->vendorMock->setData($data);

        $this->vendorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->returnValue($this->vendorMock));

        $this->vendorMock->expects($this->once())->method('load');
        $this->vendorMock->expects($this->once())->method('getId')->willReturn(1);

        $this->vendorRepository = $this->objectManager->getObject(
            VendorRepository::class,
            ['vendorFactory' => $this->vendorFactoryMock, 'resourceModel' => $this->vendorResourceModelMock]
        );
    }

    public function testGetById(): void
    {
        $result = $this->vendorRepository->getById(1);

        $data = [
            'id' => 1,
            'name' => 'Yohanes Pradono',
            'description' => "Lorem ipsum dolor sit amet",
            'image' => 'yohanes.png'
        ];
        $this->assertEquals($data, $result->getData());
    }

    public function testDeleteByIdShouldReturnTrue()
    {
        $result = $this->vendorRepository->deleteById(1);
        $this->assertTrue($result);
    }

    public function testSaveShouldReturnVendor()
    {
        $this->vendorResourceModelMock->expects($this->once())->method('save')->with($this->vendorMock);
        $result = $this->vendorRepository->save($this->vendorMock);

        $data = [
            'id' => 1,
            'name' => 'Yohanes Pradono',
            'description' => "Lorem ipsum dolor sit amet",
            'image' => 'yohanes.png'
        ];
        $this->assertEquals($data, $result->getData());
    }
}
