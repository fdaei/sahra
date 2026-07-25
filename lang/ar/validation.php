<?php

declare(strict_types=1);

return [

    'required' => 'حقل :attribute مطلوب.',
    'email' => 'يرجى إدخال بريد إلكتروني صالح.',
    'max' => [
        'string' => 'يجب ألا يزيد :attribute عن :max حرفاً.',
        'array' => 'يمكنك اختيار :max خيارات كحد أقصى.',
    ],
    'min' => [
        'string' => 'يجب ألا يقل :attribute عن :min أحرف.',
    ],
    'regex' => 'صيغة :attribute غير صالحة.',
    'exists' => ':attribute المحدد غير صالح.',
    'array' => 'يجب أن يكون :attribute قائمة.',
    'integer' => 'يجب أن يكون :attribute رقماً.',
    'in' => ':attribute المحدد غير صالح.',
    'prohibited' => 'حقل :attribute غير مسموح به.',

    'custom' => [
        'contact' => [
            'reachable' => 'يرجى إدخال رقم هاتف أو بريد إلكتروني حتى نتمكن من الرد.',
            'too_fast' => 'تم الإرسال بسرعة كبيرة. يرجى المحاولة مرة أخرى.',
        ],
    ],

    'attributes' => [],

];
