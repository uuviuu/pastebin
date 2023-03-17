<?php

namespace App\Enums;

abstract class Access extends Enum
{
    const PUBLIC = 'public';
    const UNLISTED = 'unlisted';
    const PRIVATE = 'private';
}