<?php

namespace Yohanes\Vendor\Test\Unit\Model;

use Magento\Framework\DB\Adapter\ConnectionException;
use Magento\Framework\DB\Adapter\DeadlockException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException as TemporaryCouldNotSaveException;
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

    /**
     * @inheritdoc
     */
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

        $this->vendorRepository = $this->objectManager->getObject(
            VendorRepository::class,
            ['vendorFactory' => $this->vendorFactoryMock, 'resourceModel' => $this->vendorResourceModelMock]
        );
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        $this->objectManager = null;
        $this->vendorResourceModelMock = null;
        $this->vendorFactoryMock = null;
        $this->vendorMock = null;
    }

    public function testGetById(): void
    {
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
        $this->vendorMock->expects($this->once())->method('getId')->willReturn($data['id']);

        $result = $this->vendorRepository->getById(1);
        $this->assertEquals($data, $result->getData());
    }

    public function testDeleteByIdShouldReturnTrue()
    {
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
        $this->vendorMock->expects($this->once())->method('getId')->willReturn($data['id']);

        $result = $this->vendorRepository->deleteById(1);
        $this->assertTrue($result);
    }

    public function testSaveShouldReturnVendor()
    {
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
        $this->vendorResourceModelMock->expects($this->once())->method('save')->with($this->vendorMock);
        $result = $this->vendorRepository->save($this->vendorMock);

        $this->assertEquals($data, $result->getData());
    }

    public function testSaveThrowsConnectionException()
    {
        $this->vendorResourceModelMock->expects($this->once())
            ->method('save')
            ->willThrowException(new ConnectionException(__('Database connection error')));
        $this->expectException(TemporaryCouldNotSaveException::class);
        $this->vendorRepository->save($this->vendorMock);
    }

    public function testSaveThrowsAnyException()
    {
        $this->vendorResourceModelMock->expects($this->once())
            ->method('save')
            ->willThrowException(new DeadlockException(__('Database deadlock found when trying to get lock')));
        $this->expectException(\Exception::class);
        $this->vendorRepository->save($this->vendorMock);
    }
}
