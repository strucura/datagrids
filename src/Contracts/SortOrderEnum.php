<?php

namespace Strucura\Grids\Contracts;

enum SortOrderEnum: int
{
    case ASC = 1;
    case DESC = -1;
    case NONE = 0;
}
