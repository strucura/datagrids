<?php

namespace Strucura\DataGrid\Enums;

enum FilterOperator: string
{
    case STRING_STARTS_WITH = 'startsWith';
    case STRING_CONTAINS = 'contains';
    case STRING_DOES_NOT_CONTAIN = 'doesNotContain';
    case STRING_ENDS_WITH = 'endsWith';
    case EQUALS = 'equals';
    case NOT_EQUALS = 'doesNotEquals';
    case IN = 'in';
    case NOT_IN = 'notIn';
    case LESS_THAN = 'lt';
    case LESS_THAN_OR_EQUAL_TO = 'lte';
    case GREATER_THAN = 'gt';
    case GREATER_THAN_OR_EQUAL_TO = 'gte';
    // case BETWEEN = 'between';
    case DATE_IS = 'dateIs';
    case DATE_IS_NOT = 'dateIsNot';
    case DATE_BEFORE = 'dateBefore';
    case DATE_AFTER = 'dateAfter';
    case DATE_ON_OR_BEFORE = 'dateOnOrBefore';
    case DATE_ON_OR_AFTER = 'dateOnOrAfter';
}
