<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Serializer\Collection;

use Itspire\Common\Collection\CollectionWrapper;
use JMS\Serializer\Annotation as Serializer;

abstract class AbstractSerializableCollectionWrapper extends CollectionWrapper
{
    /**
     * @Serializer\Exclude(if="true")
     *
     * This property should never be serialized
     */
    protected string $supportedClass;
}
