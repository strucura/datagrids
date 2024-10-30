<?php

namespace Strucura\Grids\Enums;

enum ColumnDataTypeEnum: string
{
    case String = 'string';
    case Number = 'number';
    case Date = 'date';
    case Time = 'time';
    case DateTime = 'datetime';
    case Boolean = 'boolean';
    case Point = 'point';
}
