<?php

/**
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Functional;

use Itspire\Serializer\Common\Test\Fixtures\Model\TestEnumeration;
use Itspire\Serializer\Common\Test\Fixtures\Model\TestEnumerationsWrapper;
use Itspire\Serializer\Common\Test\Fixtures\Model\TestEnumerationWrapper;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class EnumerationWrapperTest extends TestCase
{
    /** @var SerializerInterface $serializer */
    private static $serializer;

    /** @var TestEnumerationWrapper $testEnumerationWrapper */
    private $testEnumerationWrapper;

    /** @var TestEnumerationsWrapper $testEnumerationsWrapper */
    private $testEnumerationsWrapper;

    public static function setUpBeforeClass(): void
    {
        if (null === self::$serializer) {
            // obtaining the serializer
            $serializerBuilder = SerializerBuilder::create();
            self::$serializer = $serializerBuilder->build();
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $testEnumeration = new TestEnumeration(TestEnumeration::TEST);
        $testEnumeration1 = new TestEnumeration(TestEnumeration::TEST1);

        $this->testEnumerationWrapper = (new TestEnumerationWrapper())
            ->setCode($testEnumeration->getCode())
            ->setDescription($testEnumeration->getDescription());

        $testEnumerationWrapper = (new TestEnumerationWrapper())
            ->setCode($testEnumeration1->getCode())
            ->setDescription($testEnumeration1->getDescription());

        $this->testEnumerationsWrapper = (new TestEnumerationsWrapper())
            ->addEnumValue($this->testEnumerationWrapper)
            ->addEnumValue($testEnumerationWrapper);
    }

    protected function tearDown(): void
    {
        unset($this->testEnumerationsWrapper, $this->testEnumerationWrapper);

        parent::tearDown();
    }

    /** @test */
    public function serializePermissionTest(): void
    {
        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_enum.xml'),
            static::$serializer->serialize($this->testEnumerationWrapper, 'xml')
        );
    }

    /** @test */
    public function serializePermissionsSingleTest(): void
    {
        $this->testEnumerationsWrapper->removeEnumValue($this->testEnumerationWrapper);

        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_enums_single.xml'),
            static::$serializer->serialize($this->testEnumerationsWrapper, 'xml')
        );
    }

    /** @test */
    public function serializePermissionsListTest(): void
    {
        static::assertXmlStringEqualsXmlFile(
            realpath('src/test/resources/test_enums_list.xml'),
            static::$serializer->serialize($this->testEnumerationsWrapper, 'xml')
        );
    }

    /** @test */
    public function deserializePermissionTest(): void
    {
        /** @var SimpleXMLElement $testEnumerationXml */
        $testEnumerationXml = simplexml_load_file(realpath('src/test/resources/test_enum.xml'));

        /** @var TestEnumerationWrapper $deserializedResult */
        $deserializedResult = static::$serializer->deserialize(
            $testEnumerationXml->asXML(),
            TestEnumerationWrapper::class,
            'xml'
        );

        static::assertEquals($this->testEnumerationWrapper->getCode(), $deserializedResult->getCode());
        static::assertEquals($this->testEnumerationWrapper->getDescription(), $deserializedResult->getDescription());
    }

    /** @test */
    public function deserializePermissionsTest(): void
    {
        /** @var SimpleXMLElement $testEnumerationsXml */
        $testEnumerationsXml = simplexml_load_file(realpath('src/test/resources/test_enums_list.xml'));

        /** @var TestEnumerationsWrapper $deserializedResult */
        $deserializedResult = static::$serializer->deserialize(
            $testEnumerationsXml->asXML(),
            TestEnumerationsWrapper::class,
            'xml'
        );

        static::assertEquals(
            $this->testEnumerationsWrapper->getEnumValues()->count(),
            $deserializedResult->getEnumValues()->count()
        );

        $deserializedResultEnum = $deserializedResult->getEnumValues()->first();

        static::assertEquals($this->testEnumerationWrapper->getCode(), $deserializedResultEnum->getCode());
        static::assertEquals(
            $this->testEnumerationWrapper->getDescription(),
            $deserializedResultEnum->getDescription()
        );
    }
}
