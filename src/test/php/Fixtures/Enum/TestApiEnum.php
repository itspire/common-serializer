<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Serializer\Test\Fixtures\Enum;

use Itspire\Common\Serializer\Enum\AbstractSerializableEnum;
use JMS\Serializer\Annotation as Serializer;

/** @Serializer\XmlRoot("test_enum") */
class TestApiEnum extends AbstractSerializableEnum
{
}
