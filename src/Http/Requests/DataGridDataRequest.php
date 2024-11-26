<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;

class DataGridDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first' => ['required', 'int', 'min:0'],
            'last' => ['required', 'int', 'min:0'],

            'sorts' => ['nullable', 'array'],
            'sorts.*.column' => ['required', 'string', 'min:1'],
            'sorts.*.sort_type' => ['required', Rule::enum(SortTypeEnum::class)],

            'filter_sets' => ['nullable', 'array'],
            'filter_sets.*.operator' => ['required', Rule::enum(FilterSetOperator::class)],
            'filter_sets.*.filters' => ['required', 'array'],
            'filter_sets.*.filters.*.column' => ['required', 'string', 'min:1'],
            'filter_sets.*.filters.*.value' => ['present'],
            'filter_sets.*.filters.*.filter_type' => ['required', Rule::enum(FilterTypeEnum::class)],
        ];
    }
}
