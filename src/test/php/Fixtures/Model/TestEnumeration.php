<?php

/**
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Test\Fixtures\Model;

use Itspire\Common\Enumeration\AbstractEnumeration;

/**
 * Class TestEnumeration
 *
 * @author Ryan RAJKOMAR
 */
class TestEnumeration extends AbstractEnumeration
{
    /** @var array TEST */
    public const TEST = [0, 'test'];

    /** @var array TEST1 */
    public const TEST1 = [1, 'test1'];
}
