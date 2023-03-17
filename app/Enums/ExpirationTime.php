<?php

namespace App\Enums;

abstract class ExpirationTime extends Enum
{
    const TEN_MIN = '10 минут';
    const HOUR = '1 час';
    const THREE_HOURS = '3 часа';
    const DAY = '1 день';
    const WEEK = '1 неделя';
    const MONTH = '1 месяц';
    const INFINITELY = 'Неограниченно';
}