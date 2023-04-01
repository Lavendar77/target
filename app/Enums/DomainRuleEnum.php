<?php

namespace App\Enums;

enum DomainRuleEnum: string
{
    case CONTAINS = 'contains';
    case STARTSWITH = 'starts_with';
    case ENDSWITH = 'ends_with';
    case EXACT = 'exact';
}
