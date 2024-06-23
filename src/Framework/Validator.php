<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];

    public function addRules(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields)
    {
        $errors = [];

        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParameters = [];

                if (str_contains($rule, ':')) {
                    [$rule, $ruleParameters] = explode(':', $rule);
                    $ruleParameters = explode(',', $ruleParameters);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $fieldName, $ruleParameters)) {
                    continue;
                }

                $errors[$fieldName][] = $ruleValidator->getMessage($formData, $fieldName, $ruleParameters);
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }
}
