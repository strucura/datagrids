<?php

namespace Strucura\DataGrid\Enums;

enum ColumnType: string
{
    case String = 'string';
    case Integer = 'integer';
    case Float = 'float';
    case Date = 'date';
    case Time = 'time';
    case DateTime = 'datetime';
    case Boolean = 'boolean';
    case Point = 'point';
    case Enum = 'enum';
}
