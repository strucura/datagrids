<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GridSchemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
