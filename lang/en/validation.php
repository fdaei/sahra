<?php

declare(strict_types=1);

return [

    'required' => 'The :attribute field is required.',
    'email' => 'Please enter a valid email address.',
    'max' => [
        'string' => 'The :attribute may not be longer than :max characters.',
        'array' => 'You may select at most :max options.',
    ],
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'regex' => 'The :attribute format is not valid.',
    'exists' => 'The selected :attribute is not valid.',
    'array' => 'The :attribute must be a list.',
    'integer' => 'The :attribute must be a number.',
    'in' => 'The selected :attribute is not valid.',
    'prohibited' => 'The :attribute field is not allowed.',

    'custom' => [
        'contact' => [
            'reachable' => 'Please provide a phone number or an email address so we can reply.',
            'too_fast' => 'That was submitted a little too quickly. Please try again.',
        ],
    ],

    'attributes' => [],

];
