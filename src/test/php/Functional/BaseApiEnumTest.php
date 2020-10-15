<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Functional;

use Doctrine\Common\Collections\ArrayCollection;
use Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\DummyEnum;
use Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\TestBaseApiEnumList;
use Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\TestBaseApiEnum;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;

class BaseApiEnumTest extends TestCase
{
    private static ?SerializerInterface $serializer = null;
    private ?TestBaseApiEnum $testBaseEnum = null;
    private ?TestBaseApiEnumList $testBaseEnumList = null;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        if (null === self::$serializer) {
            // obtaining the serializer
            $serializerBuilder = SerializerBuilder::create();
            self::$serializer = $serializerBuilder->build();
        }
    }

    public static function tearDownAfterClass(): void
    {
        static::$serializer = null;
        parent::tearDownAfterClass();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testBaseEnum = (new TestBaseApiEnum())->setCode('TEST')->setDescription('test');
        $testBaseEnum = (new TestBaseApiEnum())->setCode('TEST1')->setDescription('test1');

        $this->testBaseEnumList = (new TestBaseApiEnumList())
            ->addElement($this->testBaseEnum)
            ->addElement($testBaseEnum);
    }

    protected function tearDown(): void
    {
        unset($this->testBaseEnumList, $this->testBaseEnum);

        parent::tearDown();
    }

    /** @test */
    public function initWithSiblingElementTest(): void
    {
        $testDummyEnum = (new DummyEnum())->setCode('TEST1')->setDescription('test1');

        $testBaseApiEnumList = new TestBaseApiEnumList(new ArrayCollection([$testDummyEnum]));

        static::assertEquals(1, $testBaseApiEnumList->getElements()->count());

        $testDummyEnumFromList = $testBaseApiEnumList->getElements()->first();

        static::assertEquals($testDummyEnumFromList->getCode(), $testDummyEnum->getCode());
        static::assertEquals($testDummyEnumFromList->getDescription(), $testDummyEnum->getDescription());
    }

    /** @test */
    public function addElementTest(): void
    {
        $testDummyEnum = (new DummyEnum())->setCode('TEST1')->setDescription('test1');

        $this->testBaseEnumList->addElement($testDummyEnum);

        static::assertEquals(3, $this->testBaseEnumList->getElements()->count());

        $testDummyEnumFromList = $this->testBaseEnumList->getElements()->last();

        static::assertEquals($testDummyEnumFromList->getUniqueIdentifier(), $testDummyEnum->getUniqueIdentifier());
        static::assertEquals($testDummyEnumFromList->getCode(), $testDummyEnum->getCode());
        static::assertEquals($testDummyEnumFromList->getDescription(), $testDummyEnum->getDescription());
    }

    /** @test */
    public function serializeTestEnumTest(): void
    {
        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_base_api_enum.xml'),
            static::$serializer->serialize($this->testBaseEnum, 'xml')
        );
    }

    /** @test */
    public function serializeTestEnumListTest(): void
    {
        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_base_api_enums_list.xml'),
            static::$serializer->serialize($this->testBaseEnumList, 'xml')
        );
    }

    /** @test */
    public function deserializeTestEnumTest(): void
    {
        /** @var \SimpleXMLElement $testBaseEnumXml */
        $testBaseEnumXml = simplexml_load_string(
            file_get_contents(realpath('src/test/resources/test_base_api_enum.xml'))
        );

        /** @var TestBaseApiEnum $deserializedResult */
        $deserializedResult = static::$serializer->deserialize(
            $testBaseEnumXml->asXML(),
            TestBaseApiEnum::class,
            'xml'
        );

        static::assertEquals($this->testBaseEnum->getCode(), $deserializedResult->getCode());
        static::assertEquals($this->testBaseEnum->getDescription(), $deserializedResult->getDescription());
    }

    /** @test */
    public function deserializeTestEnumListTest(): void
    {
        /** @var \SimpleXMLElement $testBaseEnumsXml */
        $testBaseEnumsXml = simplexml_load_string(
            file_get_contents(realpath('src/test/resources/test_base_api_enums_list.xml'))
        );

        /** @var TestBaseApiEnumList $deserializedResult */
        $deserializedResult = static::$serializer->deserialize(
            $testBaseEnumsXml->asXML(),
            TestBaseApiEnumList::class,
            'xml'
        );

        static::assertEquals(
            $this->testBaseEnumList->getElements()->count(),
            $deserializedResult->getElements()->count()
        );

        $deserializedResultEnum = $deserializedResult->getElements()->first();

        static::assertEquals($this->testBaseEnum->getCode(), $deserializedResultEnum->getCode());
        static::assertEquals($this->testBaseEnum->getDescription(), $deserializedResultEnum->getDescription());
    }
}
