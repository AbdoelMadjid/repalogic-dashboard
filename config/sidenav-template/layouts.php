<?php

return [
    'title' => 'Layouts',
    'data_lang' => 'layouts',
    'items' => [
        [
            'title' => 'Layout Options',
            'data_lang' => 'layout-options',
            'icon' => 'ti ti-layout',
            'id' => 'layout-options',
            'children' => [
                [
                    'title' => 'Scrollable',
                    'data_lang' => 'layouts-scrollable',
                    'route' => 'template.layouts.options.scrollable',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Compact',
                    'data_lang' => 'layouts-compact',
                    'route' => 'template.layouts.options.compact',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Boxed',
                    'data_lang' => 'layouts-boxed',
                    'route' => 'template.layouts.options.boxed',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Horizontal',
                    'data_lang' => 'layouts-horizontal',
                    'route' => 'template.layouts.options.horizontal',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Preloader',
                    'data_lang' => 'layouts-preloader',
                    'route' => 'template.layouts.options.preloader',
                    'target' => '_blank',
                ],
            ],
        ],
        [
            'title' => 'Sidebars',
            'data_lang' => 'sidebars',
            'icon' => 'ti ti-layout-sidebar-inactive',
            'id' => 'sidebars',
            'children' => [
                [
                    'title' => 'Light Menu',
                    'data_lang' => 'layouts-sidebar-light',
                    'route' => 'template.layouts.sidebars.light',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Gradient Menu',
                    'data_lang' => 'layouts-sidebar-gradient',
                    'route' => 'template.layouts.sidebars.gradient',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Gray Menu',
                    'data_lang' => 'layouts-sidebar-gray',
                    'route' => 'template.layouts.sidebars.gray',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Image Menu',
                    'data_lang' => 'layouts-sidebar-image',
                    'route' => 'template.layouts.sidebars.image',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Compact Menu',
                    'data_lang' => 'layouts-sidebar-compact',
                    'route' => 'template.layouts.sidebars.compact',
                    'target' => '_blank',
                ],
                [
                    'title' => 'On Hover Menu',
                    'data_lang' => 'layouts-sidebar-on-hover',
                    'route' => 'template.layouts.sidebars.on-hover',
                    'target' => '_blank',
                ],
                [
                    'title' => 'On Hover Active',
                    'data_lang' => 'layouts-sidebar-on-hover-active',
                    'route' => 'template.layouts.sidebars.on-hover-active',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Offcanvas Menu',
                    'data_lang' => 'layouts-sidebar-offcanvas',
                    'route' => 'template.layouts.sidebars.offcanvas',
                    'target' => '_blank',
                ],
                [
                    'title' => 'No Icons with Lines',
                    'data_lang' => 'layouts-sidebar-no-icons',
                    'route' => 'template.layouts.sidebars.no-icons',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Sidebar with Lines',
                    'data_lang' => 'layouts-sidebar-with-lines',
                    'route' => 'template.layouts.sidebars.with-lines',
                    'target' => '_blank',
                ],
            ],
        ],
        [
            'title' => 'Topbar',
            'data_lang' => 'topbar',
            'icon' => 'ti ti-layout-bottombar',
            'id' => 'topbar',
            'children' => [
                [
                    'title' => 'Dark Topbar',
                    'data_lang' => 'layouts-topbar-dark',
                    'route' => 'template.layouts.topbar.dark',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Gray Topbar',
                    'data_lang' => 'layouts-topbar-gray',
                    'route' => 'template.layouts.topbar.gray',
                    'target' => '_blank',
                ],
                [
                    'title' => 'Gradient Topbar',
                    'data_lang' => 'layouts-topbar-gradient',
                    'route' => 'template.layouts.topbar.gradient',
                    'target' => '_blank',
                ],
            ],
        ],
    ],
];
