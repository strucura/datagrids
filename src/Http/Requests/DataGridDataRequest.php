<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\SortOperator;

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
            'sorts.*.alias' => ['required', 'string', 'min:1'],
            'sorts.*.sort_operator' => ['required', Rule::enum(SortOperator::class)],

            'filter_sets' => ['nullable', 'array'],
            'filter_sets.*.filter_set_operator' => ['required', Rule::enum(FilterSetOperator::class)],
            'filter_sets.*.filters' => ['required', 'array'],
            'filter_sets.*.filters.*.alias' => ['required', 'string', 'min:1'],
            'filter_sets.*.filters.*.value' => ['present'],
            'filter_sets.*.filters.*.filter_operator' => ['required', Rule::enum(FilterOperator::class)],
        ];
    }
}
