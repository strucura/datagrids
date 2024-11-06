<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;

class GridDataRequest extends FormRequest
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

            // Filters
            'filters' => ['nullable', 'array'],
            'filters.*.column' => ['required', 'string'],
            'filters.*.value' => ['present'],
            'filters.*.filter_type' => ['required', Rule::enum(FilterTypeEnum::class)],
        ];
    }
}
