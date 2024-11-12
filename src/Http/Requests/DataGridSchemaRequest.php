<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataGridSchemaRequest extends FormRequest
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
