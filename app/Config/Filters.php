<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes
     */
    public array $aliases = [
        'noauth'        => \App\Filters\NoAuthFilter::class, // Add this line
        'authGuard'     => \App\Filters\AuthGuard::class,
        'adminGuard'    => \App\Filters\AdminGuard::class,
        'apiAuth'       => \App\Filters\ApiAuth::class,
        'csrf'          => CSRF::class, 
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
    ];

    /**
     * List of special required filters
     */
    public array $required = [
        'before' => [
            'forcehttps',
        ],
        'after' => [
            'performance',
            'toolbar',
        ],
    ];

    /**
     * Global filters
     */
    public array $globals = [
        'before' => [
            'invalidchars' => [
                'except' => [
                    'api/*',
                    'logout',
                    'auth/*'
                ]
            ],
            'csrf' => [
                'except' => [
                    'api/*',
                    'logout',
                    'auth/*'
                ]
            ],
        ],
        'after' => [
            'secureheaders' => [
                'except' => [
                    'api/*'
                ]
            ],
            'toolbar',
            'performance'
        ]
    ];

    /**
     * Filter aliases for URI patterns
     */
    public array $filters = [
        'noauth' => [
            'before' => [
                'auth*',
                'login*',
                'signup*',
                'forgot-password*',
            ],
            'after' => []
        ],
        'apiAuth' => [
            'before' => [
                'api/*'
            ]
        ],
        'authGuard' => [
            'before' => [
                'dashboard*',
                'files*',
                'students*',
                'courses*',
                'enrollments*',
                'profile*'
            ]
        ],
        'adminGuard' => [
            'before' => [
                'admin*',
                'users*',
                'settings*'
            ],
            'after' => []
        ]
    ];
}