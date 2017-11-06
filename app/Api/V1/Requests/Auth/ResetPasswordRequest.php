<?php

namespace App\Api\V1\Requests\Auth;

use Config;
use Dingo\Api\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('kawaii-jwt.reset_password.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
