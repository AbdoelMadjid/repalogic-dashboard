<?php

return [
    'title' => 'Menu Items',
    'data_lang' => 'menu-items',
    'items' => [
        [
            'title' => 'Menu Levels',
            'data_lang' => 'menu-levels',
            'icon' => 'ti ti-sitemap',
            'id' => 'menu-levels',
            'children' => [
                [
                    'title' => 'Second Level',
                    'data_lang' => 'second-level',
                    'id' => 'second-level',
                    'children' => [
                        [
                            'title' => 'Item 2.1',
                            'data_lang' => 'menu-item-1',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Item 2.2',
                            'data_lang' => 'menu-item-2',
                            'url' => '#',
                        ],
                    ],
                ],
                [
                    'title' => 'Second Level',
                    'data_lang' => 'second-level-2',
                    'id' => 'second-level-2',
                    'children' => [
                        [
                            'title' => 'Item 2.1',
                            'data_lang' => 'menu-item-3',
                            'url' => '#',
                            'badge' => [
                                'text' => 'v 2.2',
                                'class' => 'badge bg-success',
                            ],
                        ],
                        [
                            'title' => 'Item 2.2',
                            'data_lang' => 'menu-item-4',
                            'id' => 'menu-item-4',
                            'children' => [
                                [
                                    'title' => 'Item 3.1',
                                    'data_lang' => 'menu-item-5',
                                    'url' => '#',
                                ],
                                [
                                    'title' => 'Item 3.2',
                                    'data_lang' => 'menu-item-6',
                                    'url' => '#',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
