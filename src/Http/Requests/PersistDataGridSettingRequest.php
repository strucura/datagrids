<?php

namespace Strucura\DataGrid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersistDataGridSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'value' => 'required|json'
        ];
    }
}
