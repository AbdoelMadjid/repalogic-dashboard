<?php

return [
    'title' => 'Custom Pages',
    'data_lang' => 'custom-pages',
    'items' => [
        [
            'title' => 'Pages',
            'data_lang' => 'pages',
            'icon' => 'ti ti-files',
            'id' => 'pages',
            'children' => [
                [
                    'title' => 'Profile',
                    'data_lang' => 'pages-profile',
                    'route' => 'template.custom.pages.profile',
                ],
                [
                    'title' => 'Account Settings',
                    'data_lang' => 'pages-account-settings',
                    'route' => 'template.custom.pages.account-settings',
                ],
                [
                    'title' => 'FAQ',
                    'data_lang' => 'pages-faq',
                    'route' => 'template.custom.pages.faq',
                ],
                [
                    'title' => 'Pricing',
                    'data_lang' => 'pages-pricing',
                    'route' => 'template.custom.pages.pricing',
                ],
                [
                    'title' => 'Empty Page',
                    'data_lang' => 'pages-empty',
                    'route' => 'template.custom.pages.empty',
                ],
                [
                    'title' => 'Timeline',
                    'data_lang' => 'pages-timeline',
                    'route' => 'template.custom.pages.timeline',
                ],
                [
                    'title' => 'Gallery',
                    'data_lang' => 'pages-gallery',
                    'route' => 'template.custom.pages.gallery',
                ],
                [
                    'title' => 'Sitemap',
                    'data_lang' => 'pages-sitemap',
                    'route' => 'template.custom.pages.sitemap',
                ],
                [
                    'title' => 'Search Results',
                    'data_lang' => 'pages-search-results',
                    'route' => 'template.custom.pages.search-results',
                ],
                [
                    'title' => 'Coming Soon',
                    'data_lang' => 'pages-coming-soon',
                    'route' => 'template.custom.pages.coming-soon',
                ],
                [
                    'title' => 'Privacy Policy',
                    'data_lang' => 'pages-privacy-policy',
                    'route' => 'template.custom.pages.privacy-policy',
                ],
                [
                    'title' => 'Terms & Conditions',
                    'data_lang' => 'pages-terms-conditions',
                    'route' => 'template.custom.pages.terms-conditions',
                ],
            ],
        ],
        [
            'title' => 'Plugins',
            'data_lang' => 'plugins',
            'icon' => 'ti ti-cpu',
            'id' => 'plugins',
            'children' => [
                [
                    'title' => 'Sortable List',
                    'data_lang' => 'plugins-sortable',
                    'route' => 'template.custom.plugins.sortable',
                ],
                [
                    'title' => 'Text Diff',
                    'data_lang' => 'plugins-text-diff',
                    'route' => 'template.custom.plugins.text-diff',
                ],
                [
                    'title' => 'PDF Viewer',
                    'data_lang' => 'plugins-pdf-viewer',
                    'route' => 'template.custom.plugins.pdf-viewer',
                ],
                [
                    'title' => 'i18 Support',
                    'data_lang' => 'plugins-i18',
                    'route' => 'template.custom.plugins.i18',
                ],
                [
                    'title' => 'Sweet Alerts',
                    'data_lang' => 'plugins-sweet-alerts',
                    'route' => 'template.custom.plugins.sweet-alerts',
                ],
                [
                    'title' => 'Idle Timer',
                    'data_lang' => 'plugins-idle-timer',
                    'route' => 'template.custom.plugins.idle-timer',
                ],
                [
                    'title' => 'Password Meter',
                    'data_lang' => 'plugins-pass-meter',
                    'route' => 'template.custom.plugins.pass-meter',
                ],
                [
                    'title' => 'Live Favicon',
                    'data_lang' => 'plugins-live-favicon',
                    'route' => 'template.custom.plugins.live-favicon',
                ],
                [
                    'title' => 'Clipboard',
                    'data_lang' => 'plugins-clipboard',
                    'route' => 'template.custom.plugins.clipboard',
                ],
                [
                    'title' => 'Tree View',
                    'data_lang' => 'plugins-tree-view',
                    'route' => 'template.custom.plugins.tree-view',
                ],
                [
                    'title' => 'Loading Buttons',
                    'data_lang' => 'plugins-loading-buttons',
                    'route' => 'template.custom.plugins.loading-buttons',
                ],
                [
                    'title' => 'Masonry',
                    'data_lang' => 'plugins-masonry',
                    'route' => 'template.custom.plugins.masonry',
                ],
                [
                    'title' => 'Tour',
                    'data_lang' => 'plugins-tour',
                    'route' => 'template.custom.plugins.tour',
                ],
                [
                    'title' => 'Animation',
                    'data_lang' => 'plugins-animation',
                    'route' => 'template.custom.plugins.animation',
                ],
                [
                    'title' => 'Video Player',
                    'data_lang' => 'plugins-video-player',
                    'route' => 'template.custom.plugins.video-player',
                ],
            ],
        ],
        [
            'title' => 'Authentication',
            'data_lang' => 'authentication',
            'icon' => 'ti ti-password-user',
            'id' => 'authentication',
            'children' => [
                [
                    'title' => 'Basic',
                    'data_lang' => 'auth-basic',
                    'id' => 'auth-basic',
                    'children' => [
                        [
                            'title' => 'Sign In',
                            'data_lang' => 'auth-sign-in',
                            'route' => 'template.custom.auth.basic.sign-in',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Sign Up',
                            'data_lang' => 'auth-sign-up',
                            'route' => 'template.custom.auth.basic.sign-up',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Reset Password',
                            'data_lang' => 'auth-reset-pass',
                            'route' => 'template.custom.auth.basic.reset-pass',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'New Password',
                            'data_lang' => 'auth-new-pass',
                            'route' => 'template.custom.auth.basic.new-pass',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Two Factor',
                            'data_lang' => 'auth-two-factor',
                            'route' => 'template.custom.auth.basic.two-factor',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Lock Screen',
                            'data_lang' => 'auth-lock-screen',
                            'route' => 'template.custom.auth.basic.lock-screen',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Success Mail',
                            'data_lang' => 'auth-success-mail',
                            'route' => 'template.custom.auth.basic.success-mail',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Login with PIN',
                            'data_lang' => 'auth-login-pin',
                            'route' => 'template.custom.auth.basic.login-pin',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Delete Account',
                            'data_lang' => 'auth-delete-account',
                            'route' => 'template.custom.auth.basic.delete-account',
                            'target' => '_blank',
                        ],
                    ],
                ],
                [
                    'title' => 'Card',
                    'data_lang' => 'auth-card',
                    'id' => 'auth-card',
                    'children' => [
                        [
                            'title' => 'Sign In',
                            'data_lang' => 'auth-card-sign-in',
                            'route' => 'template.custom.auth.card.sign-in',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Sign Up',
                            'data_lang' => 'auth-card-sign-up',
                            'route' => 'template.custom.auth.card.sign-up',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Reset Password',
                            'data_lang' => 'auth-card-reset-pass',
                            'route' => 'template.custom.auth.card.reset-pass',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'New Password',
                            'data_lang' => 'auth-card-new-pass',
                            'route' => 'template.custom.auth.card.new-pass',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Two Factor',
                            'data_lang' => 'auth-card-two-factor',
                            'route' => 'template.custom.auth.card.two-factor',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Lock Screen',
                            'data_lang' => 'auth-card-lock-screen',
                            'route' => 'template.custom.auth.card.lock-screen',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Success Mail',
                            'data_lang' => 'auth-card-success-mail',
                            'route' => 'template.custom.auth.card.success-mail',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Login with PIN',
                            'data_lang' => 'auth-card-login-pin',
                            'route' => 'template.custom.auth.card.login-pin',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Delete Account',
                            'data_lang' => 'auth-card-delete-account',
                            'route' => 'template.custom.auth.card.delete-account',
                            'target' => '_blank',
                        ],
                    ],
                ],
                [
                    'title' => 'Split',
                    'data_lang' => 'auth-split',
                    'id' => 'auth-split',
                    'children' => [
                        [
                            'title' => 'Sign In',
                            'data_lang' => 'auth-split-sign-in',
                            'route' => 'template.custom.auth.split.sign-in',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Sign Up',
                            'data_lang' => 'auth-split-sign-up',
                            'route' => 'template.custom.auth.split.sign-up',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Reset Password',
                            'data_lang' => 'auth-split-reset-pass',
                            'route' => 'template.custom.auth.split.reset-pass',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'New Password',
                            'data_lang' => 'auth-split-new-pass',
                            'route' => 'template.custom.auth.split.new-pass',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Two Factor',
                            'data_lang' => 'auth-split-two-factor',
                            'route' => 'template.custom.auth.split.two-factor',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Lock Screen',
                            'data_lang' => 'auth-split-lock-screen',
                            'route' => 'template.custom.auth.split.lock-screen',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Success Mail',
                            'data_lang' => 'auth-split-success-mail',
                            'route' => 'template.custom.auth.split.success-mail',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Login with PIN',
                            'data_lang' => 'auth-split-login-pin',
                            'route' => 'template.custom.auth.split.login-pin',
                            'target' => '_blank',
                        ],
                        [
                            'title' => 'Delete Account',
                            'data_lang' => 'auth-split-delete-account',
                            'route' => 'template.custom.auth.split.delete-account',
                            'target' => '_blank',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Error Pages',
            'data_lang' => 'error-pages',
            'icon' => 'ti ti-alert-triangle',
            'id' => 'error-pages',
            'children' => [
                [
                    'title' => '400 Bad Request',
                    'data_lang' => 'error-400',
                    'route' => 'template.custom.error.400',
                    'target' => '_blank',
                ],
                [
                    'title' => '401 Unauthorized',
                    'data_lang' => 'error-401',
                    'route' => 'template.custom.error.401',
                    'target' => '_blank',
                ],
                [
                    'title' => '403 Forbidden',
                    'data_lang' => 'error-403',
                    'route' => 'template.custom.error.403',
                    'target' => '_blank',
                ],
                [
                    'title' => '404 Not Found',
                    'data_lang' => 'error-404',
                    'route' => 'template.custom.error.404',
                    'target' => '_blank',
                ],
                [
                    'title' => '408 Request Timeout',
                    'data_lang' => 'error-408',
                    'route' => 'template.custom.error.408',
                    'target' => '_blank',
                ],
                [
                    'title' => '500 Internal Server',
                    'data_lang' => 'error-500',
                    'route' => 'template.custom.error.500',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Maintenance',
                    'data_lang' => 'error-maintenance',
                    'route' => 'template.custom.error.maintenance',
                    'target' => '_blank',
                ],
            ],
        ],
    ],
];
