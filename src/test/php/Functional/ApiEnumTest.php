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
use Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\TestApiEnumList;
use Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\TestApiEnum;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;

class ApiEnumTest extends TestCase
{
    private static ?SerializerInterface $serializer = null;
    private ?TestApiEnum $testEnum = null;
    private ?TestApiEnumList $testEnumList = null;

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

        $this->testEnum = (new TestApiEnum())->setCode('TEST')->setDescription('test');
        $testEnum = (new TestApiEnum())->setCode('TEST1')->setDescription('test1');

        $this->testEnumList = (new TestApiEnumList())->addElement($this->testEnum)->addElement($testEnum);
    }

    protected function tearDown(): void
    {
        unset($this->testEnumList, $this->testEnum);

        parent::tearDown();
    }

    /** @test */
    public function initWithInvalidArgumentErrorTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'At least one element in the collection is not supported by ' . TestApiEnumList::class
        );

        new TestApiEnumList(new ArrayCollection([new DummyEnum()]));
    }

    /** @test */
    public function addInvalidArgumentErrorTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'At least one element in the collection is not supported by ' . TestApiEnumList::class
        );

        $this->testEnumList->addElement(new DummyEnum());
    }

    /** @test */
    public function serializeTestEnumTest(): void
    {
        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_api_enum.xml'),
            static::$serializer->serialize($this->testEnum, 'xml')
        );
    }

    /** @test */
    public function serializeTestEnumListTest(): void
    {
        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_api_enums_list.xml'),
            static::$serializer->serialize($this->testEnumList, 'xml')
        );
    }

    /** @test */
    public function deserializeTestEnumTest(): void
    {
        /** @var \SimpleXMLElement $testEnumXml */
        $testEnumXml = simplexml_load_string(
            file_get_contents(realpath('src/test/resources/test_api_enum.xml'))
        );

        /** @var TestApiEnum $deserializedResult */
        $deserializedResult = static::$serializer->deserialize($testEnumXml->asXML(), TestApiEnum::class, 'xml');

        static::assertEquals($this->testEnum->getCode(), $deserializedResult->getCode());
        static::assertEquals($this->testEnum->getDescription(), $deserializedResult->getDescription());
    }

    /** @test */
    public function deserializeTestEnumListTest(): void
    {
        /** @var \SimpleXMLElement $testEnumsXml */
        $testEnumsXml = simplexml_load_string(
            file_get_contents(realpath('src/test/resources/test_api_enums_list.xml'))
        );

        /** @var TestApiEnumList $deserializedResult */
        $deserializedResult = static::$serializer->deserialize($testEnumsXml->asXML(), TestApiEnumList::class, 'xml');

        static::assertEquals($this->testEnumList->getElements()->count(), $deserializedResult->getElements()->count());

        $deserializedResultEnum = $deserializedResult->getElements()->first();

        static::assertEquals($this->testEnum->getCode(), $deserializedResultEnum->getCode());
        static::assertEquals($this->testEnum->getDescription(), $deserializedResultEnum->getDescription());
    }
}
