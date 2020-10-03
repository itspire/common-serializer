<?php

/**
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Enumeration\Model;

use Doctrine\Common\Collections as DoctrineCollections;
use Itspire\Common\Collections\CollectionHolderInterface;
use Itspire\Common\Collections\CollectionHolderTrait;
use Itspire\Serializer\Common\Enumeration\Model\Interfaces\EnumerationsWrapperInterface;
use Itspire\Serializer\Common\Enumeration\Model\Interfaces\EnumerationWrapperInterface;

abstract class AbstractEnumerationsWrapper implements EnumerationsWrapperInterface, CollectionHolderInterface
{
    use CollectionHolderTrait;

    /** Warning : property should be redefined on child classes to add the proper serialization information */
    protected ?DoctrineCollections\Collection $values = null;

    public function __construct(?DoctrineCollections\Collection $values = null)
    {
        $this->values = $values ?? new DoctrineCollections\ArrayCollection();
    }

    public function addEnumValue(EnumerationWrapperInterface $enumValue): EnumerationsWrapperInterface
    {
        if (0 === $this->values->count() || false === $this->checkEquatableExists($this->values, $enumValue)) {
            $this->values->add($enumValue);
        }

        return $this;
    }

    public function removeEnumValue(EnumerationWrapperInterface $enumValue): EnumerationsWrapperInterface
    {
        $filteredEnumValues = $this->filterEquatableExists($this->values, $enumValue);

        if (1 === $filteredEnumValues->count()) {
            $filteredEnumValue = $filteredEnumValues->first();
            $this->values->removeElement($filteredEnumValue);
        }

        return $this;
    }

    public function getEnumValues(): DoctrineCollections\Collection
    {
        return $this->values;
    }
}
