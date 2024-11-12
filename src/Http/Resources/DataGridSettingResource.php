<?php

namespace Strucura\DataGrid\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\Transpose\Attributes\DerivePropertiesFromModel;

#[DerivePropertiesFromModel(DataGridSetting::class)]
class DataGridSettingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'owner_id' => $this->resource->owner_id,
            'grid_key' => $this->resource->grid_key,
            'name' => $this->resource->name,
            'value' => $this->resource->value,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
