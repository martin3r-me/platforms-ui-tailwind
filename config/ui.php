<?php

return [

    // ===== Farben (nur als RGB!) & Textfarbe ("on") =====
    'colors' => [
        'primary'   => ['rgb' => env('UI_PRIMARY_RGB',   '79,70,229'),    'on' => env('UI_ON_PRIMARY',   '#fff')],
        'secondary' => ['rgb' => env('UI_SECONDARY_RGB', '107,114,128'),  'on' => env('UI_ON_SECONDARY', '#fff')],
        'success'   => ['rgb' => env('UI_SUCCESS_RGB',   '16,185,129'),   'on' => env('UI_ON_SUCCESS',   '#fff')],
        'danger'    => ['rgb' => env('UI_DANGER_RGB',    '239,68,68'),    'on' => env('UI_ON_DANGER',    '#fff')],
        'warning'   => ['rgb' => env('UI_WARNING_RGB',   '245,158,11'),   'on' => env('UI_ON_WARNING',   '#000')],
        'info'      => ['rgb' => env('UI_INFO_RGB',      '59,130,246'),   'on' => env('UI_ON_INFO',      '#fff')],
        'black'     => ['rgb' => env('UI_BLACK_RGB',     '31,41,55'),     'on' => env('UI_ON_BLACK',     '#fff')],
        'white'     => ['rgb' => env('UI_WHITE_RGB',     '255,255,255'),  'on' => env('UI_ON_WHITE',     '#111')],
        'muted'     => ['rgb' => env('UI_MUTED_RGB',     '203,213,225'),  'on' => env('UI_ON_MUTED',     '#1F2937')],
    ],

    // ===== Body/Surface Farben (optional overridebar) =====
    'body' => [
        'bg'    => env('UI_BODY_BG',        '#F9FAFB'),
        'color' => env('UI_BODY_COLOR',     '#1F2937'),
    ],
    'surface' => [
        'bg'    => env('UI_SURFACE_BG',     '#fff'),
        'color' => env('UI_SURFACE_COLOR',  '#1F2937'),
    ],
    'border' => [
        'color' => env('UI_BORDER',         'rgba(0,0,0,.08)'),
    ],

    // ===== Typography =====
    'typography' => [
        'font_sans' => env('UI_FONT_SANS', "system-ui, -apple-system, 'Segoe UI', sans-serif"),
        'font_mono' => env('UI_FONT_MONO', "ui-monospace, 'SFMono-Regular', monospace"),
        'size' => [
            'xs'   => '0.75rem',    // 12px
            'sm'   => '0.875rem',   // 14px
            'md'   => '1rem',       // 16px
            'lg'   => '1.125rem',   // 18px
            'xl'   => '1.25rem',    // 20px
            '2xl'  => '1.5rem',     // 24px
        ],
        'weight' => [
            'normal'    => '400',
            'medium'    => '500',
            'semibold'  => '600',
            'bold'      => '700',
        ],
        'leading' => [
            'tight'     => '1.2',
            'normal'    => '1.5',
        ],
    ],

    // ===== Border-Radius =====
    'radius' => [
        'xs'   => '0.125rem',
        'sm'   => '0.25rem',
        'md'   => '0.5rem',
        'lg'   => '0.75rem',
        'xl'   => '1.5rem',
        'full' => '9999px',
    ],

    // ===== Spacing-Scale (Padding/Margin etc.) =====
    'spacing' => [
        '0'  => '0',
        '1'  => '0.25rem',
        '2'  => '0.5rem',
        '3'  => '0.75rem',
        '4'  => '1rem',
        '5'  => '1.25rem',
        '6'  => '1.5rem',
        '8'  => '2rem',
        '10' => '2.5rem',
        '12' => '3rem',
        '16' => '4rem',
        '20' => '5rem',
        '24' => '6rem',
        '32' => '8rem',
    ],

    // ===== Breakpoints (Media Queries) =====
    'breakpoints' => [
        'xs'   => '480px',
        'sm'   => '640px',
        'md'   => '768px',
        'lg'   => '1024px',
        'xl'   => '1280px',
        '2xl'  => '1536px',
    ],

    // ===== Z-Index =====
    'zindex' => [
        'base'     => 0,
        'dropdown' => 10,
        'navbar'   => 50,
        'modal'    => 100,
        'tooltip'  => 150,
    ],

    // ===== Shadows =====
    'shadows' => [
        'xs' => '0 1px 2px 0 rgba(0,0,0,.04)',
        'sm' => '0 1px 3px 0 rgba(0,0,0,.10)',
        'md' => '0 4px 6px -1px rgba(0,0,0,.08)',
        'lg' => '0 10px 15px -3px rgba(0,0,0,.10)',
    ],
];