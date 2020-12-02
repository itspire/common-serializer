<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Serializer\Enum;

use Itspire\Common\Util\EquatableTrait;
use JMS\Serializer\Annotation as Serializer;

abstract class AbstractSerializableEnum implements SerializableEnumInterface
{
    use EquatableTrait;

    /**
     * Code is set to string because it can contains user-defined string based codes (i.e : ws exception codes)
     *
     * @Serializer\XmlAttribute
     * @Serializer\SerializedName("code")
     * @Serializer\Type("string")
     */
    private string $code = '';

    /**
     * @Serializer\XmlAttribute
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     */
    private ?string $description = null;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): SerializableEnumInterface
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): SerializableEnumInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getUniqueIdentifier(): ?string
    {
        return $this->code;
    }
}
