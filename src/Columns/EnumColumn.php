<?php

namespace Strucura\DataGrid\Columns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class EnumColumn extends AbstractColumn
{
    protected ColumnTypeEnum $dataType = ColumnTypeEnum::Enum;

    public function options(Collection $options, string $labelColumn): static
    {
        $this->meta['options'] = $options->map(function ($option) use ($labelColumn) {
            return $option->$labelColumn;
        })->toArray();

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function fromModel(Builder|string $model, string $columnName): static
    {
        if (is_string($model) && ! class_exists($model)) {
            throw new \Exception("Model $model does not exist");
        } elseif (is_string($model)) {
            /** @var Builder $model */
            $model = (new $model)::query();
        }

        return $this->options($model->get(), $columnName);
    }
}
