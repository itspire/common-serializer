<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Serializer\Test\Functional\Enum;

use Itspire\Common\Serializer\Test\Fixtures\Enum\TestBaseApiEnum;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;

class BaseApiEnumTest extends TestCase
{
    private static ?SerializerInterface $serializer = null;
    private ?TestBaseApiEnum $testBaseEnum = null;

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

        $this->testBaseEnum = new TestBaseApiEnum();
        $this->testBaseEnum->setCode('TEST')->setDescription('test');
    }

    protected function tearDown(): void
    {
        unset($this->testBaseEnum);

        parent::tearDown();
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
        static::assertEquals($this->testBaseEnum->getUniqueIdentifier(), $deserializedResult->getUniqueIdentifier());
        static::assertEquals($this->testBaseEnum->getDescription(), $deserializedResult->getDescription());
    }
}
