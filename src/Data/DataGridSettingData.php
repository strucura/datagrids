<?php

namespace Strucura\DataGrid\Data;

class DataGridSettingData
{
    public function __construct(
        public int $ownerId,
        public string $dataGridKey,
        public string $name,
        public array $value,
    ) {}
}
