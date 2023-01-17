<?php

namespace Yohanes\Vendor\Test\Unit\Model\Attribute\Source\Vendor;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Yohanes\Vendor\Model\Attribute\Source\Vendor\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{

    /**
     *
     * @var Options
     */
    protected $options;

    /**
     * @var object
     */
    protected $collectionFactoryMock;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->collectionFactoryMock = $this->createPartialMock(
            \Yohanes\Vendor\Model\ResourceModel\Vendor\CollectionFactory::class,
            ['create']
        );

        $this->options = $this->objectManager->getObject(
            Options::class,
            ['collectionFactory' => $this->collectionFactoryMock]
        );
    }

    public function testReturnArray()
    {
        $collectionMock = $this->createMock(\Yohanes\Vendor\Model\ResourceModel\Vendor\Collection::class);

        $this->collectionFactoryMock->expects(
            $this->once()
        )->method('create')->willReturn(
            $collectionMock
        );

        $option1 = $this->objectManager->getObject(\Yohanes\Vendor\Model\Vendor::class);
        $option1->setEntityId(12345);
        $option1->setName('Yohanes Pradono');
        $options = [
            $option1
        ];
        $expectedOptions = [
            [
                'value' => 12345,
                'label' => 'Yohanes Pradono',
            ]
        ];

        $iterator = new \ArrayIterator($options);
        $collectionMock->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue($iterator));

        $this->assertEquals($expectedOptions, $this->options->getAllOptions());
    }
}
