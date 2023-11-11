<?php

namespace App\Http\Requests\Base;

use App\Interfaces\BaseRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

abstract class Request extends FormRequest implements BaseRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->validatePost(),
            'PATCH' => $this->validatePatch(),
            default => [],
        };
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!count($this->all())) {
                    $validator->errors()->add(
                        'fields',
                        'At least one field must be entered'
                    );
                }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'The Status field must be A or I',
        ];
    }
    
}
