<?php

declare(strict_types=1);

return [

    'session_expired' => 'Your session expired. Please try again.',
    'back_home'       => 'Back to Home',

    '403' => [
        'title'   => 'Access Restricted',
        'message' => "You don't have permission to view this page.",
    ],

    '404' => [
        'title'   => 'Lost in the Horizon?',
        'message' => "The page you're looking for doesn't exist, but there are still new directions to explore.",
    ],

    '429' => [
        'title'   => 'Slow Down a Moment',
        'message' => "You've made too many requests. Please wait a little and try again.",
    ],

    '500' => [
        'title'   => 'Something Went Wrong',
        'message' => "An unexpected error occurred on our side. We're looking into it.",
    ],

    '503' => [
        'title'   => 'Back Shortly',
        'message' => "We're carrying out brief maintenance. Please check back in a few minutes.",
    ],

];
