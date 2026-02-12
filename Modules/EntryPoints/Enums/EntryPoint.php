<?php

namespace Modules\EntryPoints\Enums;

enum EntryPointType: string
{
    case LAND = 'land_crossing';
    case INTL_AIRPORT = 'international_airport';
    case DOMESTIC_AIRPORT = 'domestic_airport';
    case SEAPORT = 'seaport';
    case RIVER_PORT = 'river_port';
}
