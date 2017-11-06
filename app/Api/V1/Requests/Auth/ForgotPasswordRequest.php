<?php

namespace App\Api\V1\Requests\Auth;

use Config;
use Dingo\Api\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('kawaii-jwt.forgot_password.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
