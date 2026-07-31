<?php

return [
    'title' => 'Main',
    'data_lang' => 'main',
    'items' => [
        [
            'title' => 'Dashboards',
            'data_lang' => 'dashboards',
            'icon' => 'ti ti-dashboard',
            'id' => 'dashboards',
            'children' => [
                [
                    'title' => 'Ecommerce',
                    'data_lang' => 'dashboard-ecommerce',
                    'route' => 'template.main.dashboards.ecommerce',
                ],
                [
                    'title' => 'Analytics',
                    'data_lang' => 'dashboard-analytics',
                    'route' => 'template.main.dashboards.analytics',
                ],
                [
                    'title' => 'Projects',
                    'data_lang' => 'dashboard-projects',
                    'route' => 'template.main.dashboards.projects',
                ],
            ],
        ],
        [
            'title' => 'Landing',
            'data_lang' => 'landing',
            'icon' => 'ti ti-rocket',
            'route' => 'template.main.landing',
            'target' => '_blank',
        ],
    ],
];
