<?php

namespace Bronto\Connector\Tests\Unit\Helper;

use Bronto\Connector\Helper\Data;
use PHPUnit\Framework\TestCase;

/**
 * Class DataTest
 * @package Common\Connector\Tests\Unit\Helper
 */
class DataTest extends TestCase
{

    /**
     * @return Array
     */
    public function dataTestPerserveFixedProperties()
    {
        $data = [];
        $description = 'Tests data similar to what is stored as a Common Record';
        $fixedProperties = [
            'order' => [
                'tid' => 0
            ]
        ];
        $oldEventData =  [
            'order' =>  [
                'id' => '130',
                'storeId' => '1',
                'area' => 'frontend',
                'status' => 'PENDING',
                'tid' => 12345,
                'uniqueKey' => 'order.add.130',
            ],
        ];
        $newEventData =  [
            'order' =>  [
                'id' => '130',
                'storeId' => '1',
                'area' => 'frontend',
                'status' => 'PROCESSED',
                'tid' => null,
                'uniqueKey' => 'order.add.130',
            ],
        ];
        $expectedData =  [
            'order' =>  [
                'id' => '130',
                'storeId' => '1',
                'area' => 'frontend',
                'status' => 'PROCESSED',
                'tid' => 12345,
                'uniqueKey' => 'order.add.130',
            ],
        ];
        $data[] = [$description, $fixedProperties, $oldEventData, $newEventData, $expectedData];

        $description = 'Tests a single old event datum being preserved. Creates an entry in the new event data array';
        $fixedProperties = [
            'order' => [
                'tide' => 'With Bleach'
            ]
        ];
        $oldEventData = [
            'order' => [
                'tide' => 'Without Bleach',
                'gain' => 'No Pain'
            ]
        ];
        $newEventData = [
            'odor' => [
                'no' => 'detergent'
            ]
        ];
        $expectedData = [
            'odor' => [
                'no' => 'detergent'
            ],
            'order' => [
                'tide' => 'Without Bleach'
            ]
        ];
        $data[] = [$description, $fixedProperties, $oldEventData, $newEventData, $expectedData];

        $description = 'Tests empty fixedProperties array';
        $data[] = [$description, [], $oldEventData, $newEventData, $newEventData];

        $description = 'tests empty oldEventData array';
        $data[] = [$description, $fixedProperties, [], $newEventData, $newEventData];

        $description = 'tests empty newEventData array';
        $expectedData = [
            'order' => [
                'tide' => 'Without Bleach'
            ]
        ];
        $data[] = [$description, $fixedProperties, $oldEventData, [], $expectedData];


        return $data;
    }

    /**
     * @dataProvider dataTestPerserveFixedProperties
     */
    public function testPreserveFixedProperties($description, array $fixedProperties, array $oldEventData,
                                                array $newEventData, array $expectedData)
    {
        if (!class_exists('\Magento\Framework\App\Helper\AbstractHelper')) {
            $this->markTestSkipped(
                'Magento core class \\Magento\\Framework\\App\\Helper\\AbstractHelper is not loaded');
        }

        $newEventData = Data::preserveFixedProperties($fixedProperties, $oldEventData, $newEventData);
        $this->assertEquals($newEventData, $expectedData, $description);
    }
}
