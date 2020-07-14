<?php

namespace App\Http\Requests\Projects;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => ['required','max:150','string'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => ['required','max:150','string'],
                    ];
                }
            default:
                {
                    break;
                }
        }
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator));
        throw new HttpResponseException(
            response()->json(['message' => trans('messages.422_VALIDATION_ERROR'), 'errors' => $errors->errors()], 422)
        );
    }
}
