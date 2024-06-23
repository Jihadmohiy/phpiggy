<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
    RequiredRule,
    EmailRule,
    MinRule,
    InRule,
    URLRule,
    MatchRule
};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();

        $this->validator->addRules('required', new RequiredRule());
        $this->validator->addRules('email', new EmailRule());
        $this->validator->addRules('min', new MinRule());
        $this->validator->addRules('in', new InRule());
        $this->validator->addRules('url', new URLRule());
        $this->validator->addRules('match', new MatchRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required', 'in:USA,Canda,Mexico'],
            'socialMediaURL' => ['required', 'url'],
            'password' => ['required'],
            'confirmPassword' => ['required', 'match:password'],
            'tos' => ['required']
        ]);
    }
}
