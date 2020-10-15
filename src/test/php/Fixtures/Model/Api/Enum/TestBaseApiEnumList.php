<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum;

use Doctrine\Common\Collections as DoctrineCollections;
use Itspire\Serializer\Common\Model\Api\Enum\AbstractApiEnumList;
use JMS\Serializer\Annotation as Serializer;

class TestBaseApiEnumList extends AbstractApiEnumList
{
    /** @Serializer\Type("ArrayCollection<Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum\TestBaseApiEnum>") */
    protected ?DoctrineCollections\Collection $elements = null;
}
