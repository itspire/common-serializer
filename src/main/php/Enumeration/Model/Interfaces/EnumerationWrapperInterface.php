<?php

/**
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Enumeration\Model\Interfaces;

use Itspire\Common\Utils\EquatableInterface;

interface EnumerationWrapperInterface extends EquatableInterface
{
    public function getCode(): string;

    public function setCode(string $code): EnumerationWrapperInterface;

    public function getDescription(): ?string;

    public function setDescription(string $description): EnumerationWrapperInterface;
}
