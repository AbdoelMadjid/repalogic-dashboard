<?php

return [
    'title' => 'Apps',
    'data_lang' => 'apps',
    'items' => [
        [
            'title' => 'Ecommerce',
            'data_lang' => 'ecommerce',
            'icon' => 'ti ti-basket',
            'id' => 'ecommerce',
            'children' => [
                [
                    'title' => 'Marketplace',
                    'data_lang' => 'apps-ecommerce-marketplace',
                    'route' => 'template.apps.ecommerce.marketplace',
                ],
                [
                    'title' => 'Products',
                    'data_lang' => 'products',
                    'id' => 'products',
                    'children' => [
                        [
                            'title' => 'Products',
                            'data_lang' => 'apps-ecommerce-products',
                            'route' => 'template.apps.ecommerce.products.products',
                        ],
                        [
                            'title' => 'Products Grid',
                            'data_lang' => 'apps-ecommerce-products-grid',
                            'route' => 'template.apps.ecommerce.products.grid',
                        ],
                        [
                            'title' => 'Product Details',
                            'data_lang' => 'apps-ecommerce-product-details',
                            'route' => 'template.apps.ecommerce.products.details',
                        ],
                        [
                            'title' => 'Add Product',
                            'data_lang' => 'apps-ecommerce-product-add',
                            'route' => 'template.apps.ecommerce.products.add',
                        ],
                    ],
                ],
                [
                    'title' => 'Categories',
                    'data_lang' => 'apps-ecommerce-categories',
                    'route' => 'template.apps.ecommerce.categories',
                ],
                [
                    'title' => 'Orders',
                    'data_lang' => 'orders',
                    'id' => 'orders',
                    'children' => [
                        [
                            'title' => 'Orders',
                            'data_lang' => 'apps-ecommerce-orders',
                            'route' => 'template.apps.ecommerce.orders.orders',
                        ],
                        [
                            'title' => 'Order Details',
                            'data_lang' => 'apps-ecommerce-order-details',
                            'route' => 'template.apps.ecommerce.orders.details',
                        ],
                        [
                            'title' => 'Add/Edit Order',
                            'data_lang' => 'apps-ecommerce-order-add',
                            'route' => 'template.apps.ecommerce.orders.add',
                        ],
                    ],
                ],
                [
                    'title' => 'Customers',
                    'data_lang' => 'apps-ecommerce-customers',
                    'route' => 'template.apps.ecommerce.customers',
                ],
                [
                    'title' => 'Cart',
                    'data_lang' => 'apps-ecommerce-cart',
                    'route' => 'template.apps.ecommerce.cart',
                ],
                [
                    'title' => 'Checkout',
                    'data_lang' => 'apps-ecommerce-checkout',
                    'route' => 'template.apps.ecommerce.checkout',
                ],
                [
                    'title' => 'Sellers',
                    'data_lang' => 'sellers',
                    'id' => 'sellers',
                    'children' => [
                        [
                            'title' => 'Sellers',
                            'data_lang' => 'apps-ecommerce-sellers',
                            'route' => 'template.apps.ecommerce.sellers.sellers',
                        ],
                        [
                            'title' => 'Sellers Details',
                            'data_lang' => 'apps-ecommerce-seller-details',
                            'route' => 'template.apps.ecommerce.sellers.details',
                        ],
                    ],
                ],
                [
                    'title' => 'Refunds',
                    'data_lang' => 'apps-ecommerce-refunds',
                    'route' => 'template.apps.ecommerce.refunds',
                ],
                [
                    'title' => 'Reviews',
                    'data_lang' => 'apps-ecommerce-reviews',
                    'route' => 'template.apps.ecommerce.reviews',
                ],
                [
                    'title' => 'Inventory',
                    'data_lang' => 'inventory',
                    'id' => 'inventory',
                    'children' => [
                        [
                            'title' => 'Warehouse',
                            'data_lang' => 'apps-ecommerce-warehouse',
                            'route' => 'template.apps.ecommerce.inventory.warehouse',
                        ],
                        [
                            'title' => 'Product Stocks',
                            'data_lang' => 'apps-ecommerce-product-stocks',
                            'route' => 'template.apps.ecommerce.inventory.stocks',
                        ],
                        [
                            'title' => 'Purchased Orders',
                            'data_lang' => 'apps-ecommerce-purchased-orders',
                            'route' => 'template.apps.ecommerce.inventory.purchased-orders',
                        ],
                    ],
                ],
                [
                    'title' => 'Reports',
                    'data_lang' => 'reports',
                    'id' => 'reports',
                    'children' => [
                        [
                            'title' => 'Product Views',
                            'data_lang' => 'apps-ecommerce-product-views',
                            'route' => 'template.apps.ecommerce.reports.views',
                        ],
                        [
                            'title' => 'Sales',
                            'data_lang' => 'apps-ecommerce-sales',
                            'route' => 'template.apps.ecommerce.reports.sales',
                        ],
                    ],
                ],
                [
                    'title' => 'Attributes',
                    'data_lang' => 'apps-ecommerce-attributes',
                    'route' => 'template.apps.ecommerce.attributes',
                ],
                [
                    'title' => 'Settings',
                    'data_lang' => 'apps-ecommerce-settings',
                    'route' => 'template.apps.ecommerce.settings',
                ],
            ],
        ],
        [
            'title' => 'Email',
            'data_lang' => 'email',
            'icon' => 'ti ti-mailbox',
            'id' => 'email',
            'children' => [
                [
                    'title' => 'Inbox',
                    'data_lang' => 'apps-email-inbox',
                    'route' => 'template.apps.email.inbox',
                ],
                [
                    'title' => 'Details',
                    'data_lang' => 'apps-email-details',
                    'route' => 'template.apps.email.details',
                ],
                [
                    'title' => 'Compose',
                    'data_lang' => 'apps-email-compose',
                    'route' => 'template.apps.email.compose',
                ],
            ],
        ],
        [
            'title' => 'Users',
            'data_lang' => 'users',
            'icon' => 'ti ti-users',
            'id' => 'users',
            'children' => [
                [
                    'title' => 'Contacts',
                    'data_lang' => 'apps-users-contacts',
                    'route' => 'template.apps.users.contacts',
                ],
                [
                    'title' => 'Roles',
                    'data_lang' => 'apps-users-roles',
                    'route' => 'template.apps.users.roles',
                ],
                [
                    'title' => 'Role Details',
                    'data_lang' => 'apps-users-role-details',
                    'route' => 'template.apps.users.role-details',
                ],
                [
                    'title' => 'Permissions',
                    'data_lang' => 'apps-users-permissions',
                    'route' => 'template.apps.users.permissions',
                ],
            ],
        ],
        [
            'title' => 'Projects',
            'data_lang' => 'projects',
            'icon' => 'ti ti-briefcase',
            'id' => 'projects',
            'children' => [
                [
                    'title' => 'My Projects',
                    'data_lang' => 'apps-projects-grid',
                    'route' => 'template.apps.projects.grid',
                ],
                [
                    'title' => 'Projects List',
                    'data_lang' => 'apps-projects-list',
                    'route' => 'template.apps.projects.list',
                ],
                [
                    'title' => 'View Project',
                    'data_lang' => 'apps-projects-details',
                    'route' => 'template.apps.projects.details',
                ],
                [
                    'title' => 'Kanban Board',
                    'data_lang' => 'apps-projects-kanban',
                    'route' => 'template.apps.projects.kanban',
                ],
                [
                    'title' => 'Team Board',
                    'data_lang' => 'apps-projects-team-board',
                    'route' => 'template.apps.projects.team-board',
                ],
                [
                    'title' => 'Activity Steam',
                    'data_lang' => 'apps-projects-activity',
                    'route' => 'template.apps.projects.activity',
                ],
            ],
        ],
        [
            'title' => 'File Manager',
            'data_lang' => 'apps-file-manager',
            'icon' => 'ti ti-folder-open',
            'route' => 'template.apps.file-manager',
        ],
        [
            'title' => 'Chat',
            'data_lang' => 'apps-chat',
            'icon' => 'ti ti-message',
            'route' => 'template.apps.chat',
        ],
        [
            'title' => 'Calendar',
            'data_lang' => 'apps-calendar',
            'icon' => 'ti ti-calendar',
            'route' => 'template.apps.calendar',
        ],
        [
            'title' => 'Social Feed',
            'data_lang' => 'apps-social-feed',
            'icon' => 'ti ti-rss',
            'route' => 'template.apps.social-feed',
        ],
        [
            'title' => 'Invoice',
            'data_lang' => 'invoice',
            'icon' => 'ti ti-invoice',
            'id' => 'invoice',
            'children' => [
                [
                    'title' => 'Invoices',
                    'data_lang' => 'apps-invoice-list',
                    'route' => 'template.apps.invoice.list',
                ],
                [
                    'title' => 'Single Invoice',
                    'data_lang' => 'apps-invoice-details',
                    'route' => 'template.apps.invoice.details',
                ],
                [
                    'title' => 'New Invoice',
                    'data_lang' => 'apps-invoice-create',
                    'route' => 'template.apps.invoice.create',
                ],
            ],
        ],
        [
            'title' => 'Companies',
            'data_lang' => 'apps-companies',
            'icon' => 'ti ti-building',
            'route' => 'template.apps.companies',
        ],
        [
            'title' => 'More Apps',
            'data_lang' => 'more-apps',
            'icon' => 'ti ti-apps',
            'id' => 'more-apps',
            'children' => [
                [
                    'title' => 'Clients',
                    'data_lang' => 'apps-clients',
                    'route' => 'template.apps.moreapps.clients',
                ],
                [
                    'title' => 'Outlook View',
                    'data_lang' => 'apps-outlook',
                    'route' => 'template.apps.moreapps.outlook',
                ],
                [
                    'title' => 'Vote List',
                    'data_lang' => 'apps-vote-list',
                    'route' => 'template.apps.moreapps.vote-list',
                ],
                [
                    'title' => 'Issue Tracker',
                    'data_lang' => 'apps-issue-tracker',
                    'route' => 'template.apps.moreapps.issue-tracker',
                ],
                [
                    'title' => 'API Keys',
                    'data_lang' => 'apps-api-keys',
                    'route' => 'template.apps.moreapps.api-keys',
                ],
                [
                    'title' => 'Manage Apps',
                    'data_lang' => 'apps-manage',
                    'route' => 'template.apps.moreapps.manage',
                ],
                [
                    'title' => 'Blog',
                    'data_lang' => 'blog',
                    'id' => 'blog',
                    'children' => [
                        [
                            'title' => 'Blog List',
                            'data_lang' => 'apps-blog-list',
                            'route' => 'template.apps.moreapps.blog.list',
                        ],
                        [
                            'title' => 'Blog Grid',
                            'data_lang' => 'apps-blog-grid',
                            'route' => 'template.apps.moreapps.blog.grid',
                        ],
                        [
                            'title' => 'Article',
                            'data_lang' => 'apps-blog-article',
                            'route' => 'template.apps.moreapps.blog.article',
                        ],
                        [
                            'title' => 'Add Article',
                            'data_lang' => 'apps-blog-add',
                            'route' => 'template.apps.moreapps.blog.add',
                        ],
                    ],
                ],
                [
                    'title' => 'Pin Board',
                    'data_lang' => 'apps-pin-board',
                    'route' => 'template.apps.moreapps.pin-board',
                ],
                [
                    'title' => 'Forum',
                    'data_lang' => 'forum',
                    'id' => 'forum',
                    'children' => [
                        [
                            'title' => 'Forum View',
                            'data_lang' => 'apps-forum-view',
                            'route' => 'template.apps.moreapps.forum.view',
                        ],
                        [
                            'title' => 'Forum Post',
                            'data_lang' => 'apps-forum-post',
                            'route' => 'template.apps.moreapps.forum.post',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
