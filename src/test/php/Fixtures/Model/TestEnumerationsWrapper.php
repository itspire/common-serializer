<?php

/**
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Fixtures\Model;

use Doctrine\Common\Collections as DoctrineCollections;
use Itspire\Serializer\Common\Enumeration\Model\AbstractEnumerationsWrapper;
use JMS\Serializer\Annotation as Serializer;

/** @Serializer\XmlRoot("test_enums") */
class TestEnumerationsWrapper extends AbstractEnumerationsWrapper
{
    /**
     * @Serializer\XmlList(inline = true, entry = "test_enum")
     * @Serializer\Type("ArrayCollection<Itspire\Serializer\Common\Test\Fixtures\Model\TestEnumerationWrapper>")
     */
    protected ?DoctrineCollections\Collection $values = null;
}
