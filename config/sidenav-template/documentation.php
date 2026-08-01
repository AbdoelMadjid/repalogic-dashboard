<?php

return [
    'title' => 'Documentation',
    'data_lang' => 'documentation',
    'items' => [
        [
            'title' => 'Menu',
            'data_lang' => 'menu-title',
            'icon' => 'ti ti-menu-order',
            'id' => 'sidebarMenuDoc',
            'children' => [
                [
                    'title' => 'Introduction',
                    'data_lang' => 'introduction',
                    'route' => 'template.documentation.menu.introduction',
                ],
                [
                    'title' => 'Folder Structure',
                    'data_lang' => 'folder-structure',
                    'route' => 'template.documentation.menu.folder-structure',
                ],
                [
                    'title' => 'Getting Started',
                    'data_lang' => 'getting-started',
                    'route' => 'template.documentation.menu.getting-started',
                ],
            ],
        ],
        [
            'title' => 'Layout',
            'data_lang' => 'layouts-title',
            'icon' => 'ti ti-layout-board',
            'id' => 'sidebarLayoutDoc',
            'children' => [
                [
                    'title' => 'Layouts Option',
                    'data_lang' => 'layouts-option',
                    'route' => 'template.documentation.layouts.layouts',
                ],
                [
                    'title' => 'Sidebars Option',
                    'data_lang' => 'sidebars-option',
                    'route' => 'template.documentation.layouts.sidebar',
                ],
                [
                    'title' => 'Topbar Option',
                    'data_lang' => 'topbar-option',
                    'route' => 'template.documentation.layouts.topbar',
                ],
                [
                    'title' => 'Theme Skin Setup',
                    'data_lang' => 'theme-skin-setup',
                    'route' => 'template.documentation.layouts.theme-skin-setup',
                ],
                [
                    'title' => 'Dark Mode',
                    'data_lang' => 'dark-mode',
                    'route' => 'template.documentation.layouts.dark-mode',
                ],
                [
                    'title' => 'Sources & Credits',
                    'data_lang' => 'sources-credit',
                    'route' => 'template.documentation.layouts.sources',
                ],
            ],
        ],
        [
            'title' => 'Changelog',
            'data_lang' => 'changelog',
            'icon' => 'ti ti-history',
            'route' => 'template.documentation.changelog',
            'badge' => [
                'text' => 'v1.5.0',
                'class' => 'badge bg-primary-subtle text-primary fs-xs',
            ],
        ],
    ],
];
