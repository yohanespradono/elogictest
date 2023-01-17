<?php

namespace Yohanes\Vendor\Test\Unit\Model\Vendor;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Yohanes\Vendor\Model\ResourceModel\Vendor\CollectionFactory;
use Yohanes\Vendor\Model\ResourceModel\Vendor\Collection;
use Yohanes\Vendor\Model\Vendor;
use Yohanes\Vendor\Model\Vendor\DataProvider;
use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Collection|(Collection&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected $collectionMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->objectManager = new ObjectManager($this);
        $this->collectionMock = $this->createMock(Collection::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->objectManager = null;
        $this->collectionMock = null;
        $this->vendorCollectionFactoryMock = null;
    }

    public function testGetData()
    {
        $this->vendorCollectionFactoryMock = $this->createPartialMock(CollectionFactory::class, ['create']);
        $this->vendorCollectionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);
        $vendor = $this->objectManager->getObject(Vendor::class);
        $vendor->setId(12345);
        $vendor->setName('Yohanes Pradono');
        $vendor->setDescription('Lorem ipsum dolor sit amet');
        $array = [
            $vendor
        ];
        $this->collectionMock->expects($this->once())->method('getItems')->willReturn($array);
        $dataProvider = $this->objectManager->getObject(
            DataProvider::class,
            [
                'vendorCollectionFactory' => $this->vendorCollectionFactoryMock
            ]
        );

        $expected = [
            12345 => [
                'yohanes_vendor_vendor' => [
                    'id' => 12345,
                    'name' => 'Yohanes Pradono',
                    'description' => 'Lorem ipsum dolor sit amet',
                ]
            ]
        ];

        $result = $dataProvider->getData();
        $this->assertEquals($expected, $result);
    }
}
