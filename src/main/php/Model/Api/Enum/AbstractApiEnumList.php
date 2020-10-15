<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Serializer\Common\Model\Api\Enum;

use Itspire\Common\Model\Api\AbstractApiList;
use Itspire\Common\Util\EquatableInterface;

/** Notice : Serializer annotation for class and elements property should be defined on leaf class */
abstract class AbstractApiEnumList extends AbstractApiList
{
    /** Notice : override to limit or expand support */
    public function supports(EquatableInterface $element): bool
    {
        return $element instanceof ApiEnumInterface;
    }
}
