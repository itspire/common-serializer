<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Model\Api\Enum;

use Itspire\Common\Model\Api\ApiObjectInterface;

interface ApiEnumInterface extends ApiObjectInterface
{
    public function getCode(): string;

    public function setCode(string $code): ApiEnumInterface;

    public function getDescription(): ?string;

    public function setDescription(string $description): ApiEnumInterface;
}
