<?php

namespace Strucura\DataGrid\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $owner_id
 * @property string $grid_key
 * @property string $name
 * @property array $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class DataGridSetting extends Model
{
    protected $fillable = [
        'owner_id',
        'grid_key',
        'name',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(config('data_grids.models.user'), 'owner_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            config('data_grids.models.user'),
            'data_grid_setting_user',
            'data_grid_setting_id',
            'user_id'
        )->withTimestamps();
    }
}
