<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Fixtures\Model\Api\Enum;

use Itspire\Serializer\Common\Model\Api\Enum\AbstractApiEnum;
use JMS\Serializer\Annotation as Serializer;

/** @Serializer\XmlRoot("test_enum") */
class TestApiEnum extends AbstractApiEnum
{
}
