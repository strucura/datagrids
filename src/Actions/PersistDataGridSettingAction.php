<?php

namespace Strucura\DataGrid\Actions;

use Strucura\DataGrid\Data\DataGridSettingData;
use Strucura\DataGrid\Models\DataGridSetting;

class PersistDataGridSettingAction
{
    public static function make(): self
    {
        return new self;
    }

    public function handle(DataGridSettingData $data): DataGridSetting
    {
        $dataGridSetting = DataGridSetting::query()->where([
            'owner_id' => $data->ownerId,
            'data_grid_key' => $data->dataGridKey,
            'name' => $data->name,
        ])->firstOr(function () use ($data) {
            return new DataGridSetting([
                'owner_id' => $data->ownerId,
                'data_grid_key' => $data->dataGridKey,
                'name' => $data->name,
            ]);
        });

        $dataGridSetting->value = $data->value;
        $dataGridSetting->save();

        return $dataGridSetting;
    }
}
