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

                $fields = array_keys($this->rules());
                foreach ($this->all() as $key => $value) {
                    if (!in_array($key, $fields)) {
                        $validator->errors()->add(
                            'fields',
                            "Field {$key} is not expected"
                        );
                    }
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
