<?php

return [
    // Tema activo por defecto (puedes sobrescribir con SESSION o .env)
    'active' => env('APP_THEME', 'light'),

    'palettes' => [
        'light' => [
            'card_bg' => ['#FFFFFF','#F9FAFB','#F3F4F6','#E5E7EB','#D1D5DB'],
            'bg'      => '#FFFFFF',
            'text'    => '#111827',
            'muted'   => '#6B7280',
            'border'  => '#E5E7EB',
        ],
        'dark' => [
            'card_bg' => ['#1F2937','#111827','#0F172A','#334155','#374151'],
            'bg'      => '#111827',
            'text'    => '#F9FAFB',
            'muted'   => '#9CA3AF',
            'border'  => '#374151',
        ],
    ],
];
