<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum;

use Doctrine\Common\Collections as DoctrineCollections;
use Itspire\Common\Util\EquatableInterface;
use Itspire\Serializer\Common\Model\Api\Enum\AbstractApiEnumList;
use JMS\Serializer\Annotation as Serializer;

/** @Serializer\XmlRoot("test_enums") */
class TestApiEnumList extends AbstractApiEnumList
{
    /**
     * @Serializer\XmlList(inline = true, entry = "test_enum")
     * @Serializer\Type("ArrayCollection<Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\TestApiEnum>")
     */
    protected ?DoctrineCollections\Collection $elements = null;

    public function supports(EquatableInterface $element): bool
    {
        return $element instanceof TestApiEnum;
    }
}
