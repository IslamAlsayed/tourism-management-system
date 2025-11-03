<?php

return [

    // Movement settings
    'move' => env('TOASTS_MOVE', 'enable'), // enable | disable
    'enter_time' => env('TOASTS_ENTER_TIME', '0.5s'),
    'exit_time' => env('TOASTS_EXIT_TIME', '0.5s'),
    'visible_time' => env('TOASTS_VISIBLE_TIME', '3s'),
    'start_delay_time' => env('TOASTS_START_DELAY_TIME', '1s'),

    // Pin confirm icon
    'confirm_pin' => env('TOASTS_CONFIRM_PIN', false),

    // Default values
    'default_dir' => env('TOASTS_DEFAULT_DIR', 'ltr'),
    'default_position' => env('TOASTS_DEFAULT_POSITION', 'top'),
    'default_theme' => env('TOASTS_DEFAULT_THEME', 'warning'),

    'default_message' => env('TOASTS_DEFAULT_MESSAGE', 'Default message'),
    'default_title' => env('TOASTS_DEFAULT_TITLE', 'Default title'),

    // Confirm modal defaults
    'default_confirm_title' => env('TOASTS_CONFIRM_TITLE', 'Confirmation'),
    'default_confirm_message' => env('TOASTS_CONFIRM_MESSAGE', 'Are you sure?'),
    'default_onconfirm_text' => env('TOASTS_CONFIRM_TEXT', 'Yes'),
    'default_oncancel_text' => env('TOASTS_CANCEL_TEXT', 'No'),
];