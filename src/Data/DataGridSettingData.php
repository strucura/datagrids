<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Http\Requests\PersistDataGridSettingRequest;

class DataGridSettingData
{
    public function __construct(
        public int $ownerId,
        public string $gridKey,
        public string $name,
        public array $value,
    ) {
    }
}
