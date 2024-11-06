<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetrieveDataGridSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'grid_key' => 'required|string',
        ];
    }
}
