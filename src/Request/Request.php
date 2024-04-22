<?php

namespace Ouhaohan8023\EasyRbac\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $messages = $validator->errors()->all();
        $message = array_shift($messages);

        throw (new HttpResponseException(response()->json([
            'code' => 400,
            'msg' => $message,
            'data' => [],
        ], 400)));
    }
}
