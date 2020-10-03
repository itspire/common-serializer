<?php

/**
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Enumeration\Model\Interfaces;

use Doctrine\Common\Collections as DoctrineCollections;
use JMS\Serializer\Annotation as Serializer;

/** @Serializer\XmlRoot("enums") */
interface EnumerationsWrapperInterface
{
    public function addEnumValue(EnumerationWrapperInterface $enumValue): EnumerationsWrapperInterface;

    public function removeEnumValue(EnumerationWrapperInterface $enumValue): EnumerationsWrapperInterface;

    public function getEnumValues(): DoctrineCollections\Collection;
}