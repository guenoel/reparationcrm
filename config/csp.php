<?php

return [

    /*
     * Define which CSP policy class should be used.
     */
    'policy' => App\Csp\CustomCspPolicy::class,

    /*
     * You can set a second policy in report only mode for testing new CSP configurations.
     */
    'report_only_policy' => '',

    /*
     * All violations against the policy will be reported to this URL.
     */
    'report_uri' => env('CSP_REPORT_URI', ''),

    /*
     * This setting determines whether CSP headers will be added.
     */
    'enabled' => env('CSP_ENABLED', true),

    /*
     * The nonce generator class.
     */
    'nonce_generator' => Spatie\Csp\Nonce\RandomString::class,
];

