<header class="topnav">
    <nav class="navbar navbar-expand-lg">
        <nav class="container-fluid">
            <div class="collapse navbar-collapse" id="topnav-menu">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle drop-arrow-none"
                            data-bs-toggle="dropdown" href="#" id="topnav-main" role="button">
                            <span class="menu-icon"><i class="ti ti-dashboard fs-xl"></i></span>
                            <span class="menu-text" data-lang="main">Main</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div aria-labelledby="topnav-main" class="dropdown-menu">
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-dashboards" role="button">
                                    <span data-lang="dashboards">Dashboards</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-dashboards" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.main.dashboards.ecommerce') }}"><span
                                            data-lang="dashboard-ecommerce">Ecommerce</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.main.dashboards.analytics') }}"><span
                                            data-lang="dashboard-analytics">Analytics</span></a>
                                    <a class="dropdown-item" href="route('template.main.dashboards.projects')"><span
                                            data-lang="dashboard-projects">Projects</span></a>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('template.main.landing') }}" target="_blank"><span
                                    data-lang="landing">Landing</span></a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle drop-arrow-none"
                            data-bs-toggle="dropdown" href="#" id="topnav-apps" role="button">
                            <span class="menu-icon"><i class="ti ti-apps fs-xl"></i></span>
                            <span class="menu-text" data-lang="apps">Apps</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div aria-labelledby="topnav-apps" class="dropdown-menu">
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-ecommerce" role="button">
                                    <span data-lang="ecommerce">Ecommerce</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-ecommerce"
                                    class="dropdown-menu dropdown-menu-columns">
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.marketplace') }}"><span
                                            data-lang="apps-ecommerce-marketplace">Marketplace</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-products"
                                            role="button">
                                            <span data-lang="products">Products</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-products" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.products.products') }}"><span
                                                    data-lang="apps-ecommerce-products">Products</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.products.grid') }}"><span
                                                    data-lang="apps-ecommerce-products-grid">Products Grid</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.products.details') }}"><span
                                                    data-lang="apps-ecommerce-product-details">Product
                                                    Details</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.products.add') }}"><span
                                                    data-lang="apps-ecommerce-product-add">Add Product</span></a>
                                        </div>
                                    </div>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.categories') }}"><span
                                            data-lang="apps-ecommerce-categories">Categories</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-orders"
                                            role="button">
                                            <span data-lang="orders">Orders</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-orders" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.orders.orders') }}"><span
                                                    data-lang="apps-ecommerce-orders">Orders</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.orders.details') }}"><span
                                                    data-lang="apps-ecommerce-order-details">Order Details</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.orders.add') }}"><span
                                                    data-lang="apps-ecommerce-order-add">Add/Edit Order</span></a>
                                        </div>
                                    </div>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.customers') }}"><span
                                            data-lang="apps-ecommerce-customers">Customers</span></a>
                                    <a class="dropdown-item" href="{{ route('template.apps.ecommerce.cart') }}"><span
                                            data-lang="apps-ecommerce-cart">Cart</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.checkout') }}"><span
                                            data-lang="apps-ecommerce-checkout">Checkout</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-sellers"
                                            role="button">
                                            <span data-lang="sellers">Sellers</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-sellers" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.sellers.sellers') }}"><span
                                                    data-lang="apps-ecommerce-sellers">Sellers</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.sellers.details') }}"><span
                                                    data-lang="apps-ecommerce-seller-details">Sellers
                                                    Details</span></a>
                                        </div>
                                    </div>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.refunds') }}"><span
                                            data-lang="apps-ecommerce-refunds">Refunds</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.reviews') }}"><span
                                            data-lang="apps-ecommerce-reviews">Reviews</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-inventory"
                                            role="button">
                                            <span data-lang="inventory">Inventory</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-inventory" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.inventory.warehouse') }}"><span
                                                    data-lang="apps-ecommerce-warehouse">Warehouse</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.inventory.stocks') }}"><span
                                                    data-lang="apps-ecommerce-product-stocks">Product Stocks</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.inventory.purchased-orders') }}"><span
                                                    data-lang="apps-ecommerce-purchased-orders">Purchased
                                                    Orders</span></a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-reports"
                                            role="button">
                                            <span data-lang="reports">Reports</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-reports" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.reports.views') }}"><span
                                                    data-lang="apps-ecommerce-product-views">Product Views</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.ecommerce.reports.sales') }}"><span
                                                    data-lang="apps-ecommerce-sales">Sales</span></a>
                                        </div>
                                    </div>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.attributes') }}"><span
                                            data-lang="apps-ecommerce-attributes">Attributes</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.ecommerce.settings') }}"><span
                                            data-lang="apps-ecommerce-settings">Settings</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-email" role="button">
                                    <span data-lang="email">Email</span><span
                                        class="badge bg-danger text-white">New</span>
                                </a>
                                <div aria-labelledby="topnav-submenu-email" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.apps.email.inbox') }}"><span
                                            data-lang="apps-email-inbox">Inbox</span></a>
                                    <a class="dropdown-item" href="{{ route('template.apps.email.details') }}"><span
                                            data-lang="apps-email-details">Details</span></a>
                                    <a class="dropdown-item" href="{{ route('template.apps.email.compose') }}"><span
                                            data-lang="apps-email-compose">Compose</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-users" role="button">
                                    <span data-lang="users">Users</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-users" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.apps.users.contacts') }}"><span
                                            data-lang="apps-users-contacts">Contacts</span></a>
                                    <a class="dropdown-item" href="{{ route('template.apps.users.roles') }}"><span
                                            data-lang="apps-users-roles">Roles</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.users.role-details') }}"><span
                                            data-lang="apps-users-role-details">Role Details</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.users.permissions') }}"><span
                                            data-lang="apps-users-permissions">Permissions</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-projects" role="button">
                                    <span data-lang="projects">Projects</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-projects" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.apps.projects.grid') }}"><span
                                            data-lang="apps-projects-grid">My Projects</span></a>
                                    <a class="dropdown-item" href="{{ route('template.apps.projects.list') }}"><span
                                            data-lang="apps-projects-list">Projects List</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.projects.details') }}"><span
                                            data-lang="apps-projects-details">View Project</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.projects.kanban') }}"><span
                                            data-lang="apps-projects-kanban">Kanban Board</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.projects.team-board') }}"><span
                                            data-lang="apps-projects-team-board">Team Board</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.projects.activity') }}"><span
                                            data-lang="apps-projects-activity">Activity Steam</span></a>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('template.apps.file-manager') }}"><span
                                    data-lang="apps-file-manager">File Manager</span></a>
                            <a class="dropdown-item" href="{{ route('template.apps.chat') }}"><span
                                    data-lang="apps-chat">Chat</span></a>
                            <a class="dropdown-item" href="{{ route('template.apps.calendar') }}"><span
                                    data-lang="apps-calendar">Calendar</span></a>
                            <a class="dropdown-item" href="{{ route('template.apps.social-feed') }}"><span
                                    data-lang="apps-social-feed">Social Feed</span></a>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-invoice" role="button">
                                    <span data-lang="invoice">Invoice</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-invoice" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.apps.invoice.list') }}"><span
                                            data-lang="apps-invoice-list">Invoices</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.invoice.details') }}"><span
                                            data-lang="apps-invoice-details">Single Invoice</span></a>
                                    <a class="dropdown-item" href="{{ route('template.apps.invoice.create') }}"><span
                                            data-lang="apps-invoice-create">New Invoice</span></a>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('template.apps.companies') }}"><span
                                    data-lang="apps-companies">Companies</span></a>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-more-apps" role="button">
                                    <span data-lang="more-apps">More Apps</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-more-apps" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.clients') }}"><span
                                            data-lang="apps-clients">Clients</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.outlook') }}"><span
                                            data-lang="apps-outlook">Outlook View</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.vote-list') }}"><span
                                            data-lang="apps-vote-list">Vote List</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.issue-tracker') }}"><span
                                            data-lang="apps-issue-tracker">Issue Tracker</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.api-keys') }}"><span
                                            data-lang="apps-api-keys">API Keys</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.manage') }}"><span
                                            data-lang="apps-manage">Manage Apps</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-blog"
                                            role="button">
                                            <span data-lang="blog">Blog</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-blog" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.moreapps.blog.list') }}"><span
                                                    data-lang="apps-blog-list">Blog List</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.moreapps.blog.grid') }}"><span
                                                    data-lang="apps-blog-grid">Blog Grid</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.moreapps.blog.article') }}"><span
                                                    data-lang="apps-blog-article">Article</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.moreapps.blog.add') }}"><span
                                                    data-lang="apps-blog-add">Add Article</span></a>
                                        </div>
                                    </div>
                                    <a class="dropdown-item"
                                        href="{{ route('template.apps.moreapps.pin-board') }}"><span
                                            data-lang="apps-pin-board">Pin Board</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-forum"
                                            role="button">
                                            <span data-lang="forum">Forum</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-forum" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.moreapps.forum.view') }}"><span
                                                    data-lang="apps-forum-view">Forum View</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.apps.moreapps.forum.post') }}"><span
                                                    data-lang="apps-forum-post">Forum Post</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true"
                            class="nav-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" href="#"
                            id="topnav-custom-pages" role="button">
                            <span class="menu-icon"><i class="ti ti-files fs-xl"></i></span>
                            <span class="menu-text" data-lang="custom-pages">Custom Pages</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div aria-labelledby="topnav-custom-pages" class="dropdown-menu">
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-pages" role="button">
                                    <span data-lang="pages">Pages</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-pages"
                                    class="dropdown-menu dropdown-menu-columns">
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.profile') }}"><span
                                            data-lang="pages-profile">Profile</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.account-settings') }}"><span
                                            data-lang="pages-account-settings">Account Settings</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.pages.faq') }}"><span
                                            data-lang="pages-faq">FAQ</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.pricing') }}"><span
                                            data-lang="pages-pricing">Pricing</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.pages.empty') }}"><span
                                            data-lang="pages-empty">Empty Page</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.timeline') }}"><span
                                            data-lang="pages-timeline">Timeline</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.gallery') }}"><span
                                            data-lang="pages-gallery">Gallery</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.sitemap') }}"><span
                                            data-lang="pages-sitemap">Sitemap</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.search-results') }}"><span
                                            data-lang="pages-search-results">Search Results</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.coming-soon') }}"><span
                                            data-lang="pages-coming-soon">Coming Soon</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.privacy-policy') }}"><span
                                            data-lang="pages-privacy-policy">Privacy Policy</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.pages.terms-conditions') }}"><span
                                            data-lang="pages-terms-conditions">Terms &amp; Conditions</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-plugins" role="button">
                                    <span data-lang="plugins">Plugins</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-plugins"
                                    class="dropdown-menu dropdown-menu-columns">
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.sortable') }}"><span
                                            data-lang="plugins-sortable">Sortable List</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.text-diff') }}"><span
                                            data-lang="plugins-text-diff">Text Diff</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.pdf-viewer') }}"><span
                                            data-lang="plugins-pdf-viewer">PDF Viewer</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.plugins.i18') }}"><span
                                            data-lang="plugins-i18">i18 Support</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.sweet-alerts') }}"><span
                                            data-lang="plugins-sweet-alerts">Sweet Alerts</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.idle-timer') }}"><span
                                            data-lang="plugins-idle-timer">Idle Timer</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.pass-meter') }}"><span
                                            data-lang="plugins-pass-meter">Password Meter</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.live-favicon') }}"><span
                                            data-lang="plugins-live-favicon">Live Favicon</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.clipboard') }}"><span
                                            data-lang="plugins-clipboard">Clipboard</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.tree-view') }}"><span
                                            data-lang="plugins-tree-view">Tree View</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.loading-buttons') }}"><span
                                            data-lang="plugins-loading-buttons">Loading Buttons</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.masonry') }}"><span
                                            data-lang="plugins-masonry">Masonry</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.plugins.tour') }}"><span
                                            data-lang="plugins-tour">Tour</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.animation') }}"><span
                                            data-lang="plugins-animation">Animation</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.custom.plugins.video-player') }}"><span
                                            data-lang="plugins-video-player">Video Player</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-authentication" role="button">
                                    <span data-lang="authentication">Authentication</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-authentication" class="dropdown-menu">
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-auth-basic"
                                            role="button">
                                            <span data-lang="auth-basic">Basic</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-auth-basic" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.sign-in') }}"
                                                target="_blank"><span data-lang="auth-sign-in">Sign In</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.sign-up') }}"
                                                target="_blank"><span data-lang="auth-sign-up">Sign Up</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.reset-pass') }}"
                                                target="_blank"><span data-lang="auth-reset-pass">Reset
                                                    Password</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.new-pass') }}"
                                                target="_blank"><span data-lang="auth-new-pass">New
                                                    Password</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.two-factor') }}"
                                                target="_blank"><span data-lang="auth-two-factor">Two
                                                    Factor</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.lock-screen') }}"
                                                target="_blank"><span data-lang="auth-lock-screen">Lock
                                                    Screen</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.success-mail') }}"
                                                target="_blank"><span data-lang="auth-success-mail">Success
                                                    Mail</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.login-pin') }}"
                                                target="_blank"><span data-lang="auth-login-pin">Login with
                                                    PIN</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.basic.delete-account') }}"
                                                target="_blank"><span data-lang="auth-delete-account">Delete
                                                    Account</span></a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-auth-card"
                                            role="button">
                                            <span data-lang="auth-card">Card</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-auth-card" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.sign-in') }}"
                                                target="_blank"><span data-lang="auth-card-sign-in">Sign In</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.sign-up') }}"
                                                target="_blank"><span data-lang="auth-card-sign-up">Sign Up</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.reset-pass') }}"
                                                target="_blank"><span data-lang="auth-card-reset-pass">Reset
                                                    Password</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.new-pass') }}"
                                                target="_blank"><span data-lang="auth-card-new-pass">New
                                                    Password</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.two-factor') }}"
                                                target="_blank"><span data-lang="auth-card-two-factor">Two
                                                    Factor</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.lock-screen') }}"
                                                target="_blank"><span data-lang="auth-card-lock-screen">Lock
                                                    Screen</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.success-mail') }}"
                                                target="_blank"><span data-lang="auth-card-success-mail">Success
                                                    Mail</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.login-pin') }}"
                                                target="_blank"><span data-lang="auth-card-login-pin">Login with
                                                    PIN</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.card.delete-account') }}"
                                                target="_blank"><span data-lang="auth-card-delete-account">Delete
                                                    Account</span></a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-auth-split"
                                            role="button">
                                            <span data-lang="auth-split">Split</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-auth-split" class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.sign-in') }}"
                                                target="_blank"><span data-lang="auth-split-sign-in">Sign
                                                    In</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.sign-up') }}"
                                                target="_blank"><span data-lang="auth-split-sign-up">Sign
                                                    Up</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.reset-pass') }}"
                                                target="_blank"><span data-lang="auth-split-reset-pass">Reset
                                                    Password</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.new-pass') }}"
                                                target="_blank"><span data-lang="auth-split-new-pass">New
                                                    Password</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.two-factor') }}"
                                                target="_blank"><span data-lang="auth-split-two-factor">Two
                                                    Factor</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.lock-screen') }}"
                                                target="_blank"><span data-lang="auth-split-lock-screen">Lock
                                                    Screen</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.success-mail') }}"
                                                target="_blank"><span data-lang="auth-split-success-mail">Success
                                                    Mail</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.login-pin') }}"
                                                target="_blank"><span data-lang="auth-split-login-pin">Login with
                                                    PIN</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.custom.auth.split.delete-account') }}"
                                                target="_blank"><span data-lang="auth-split-delete-account">Delete
                                                    Account</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-error-pages" role="button">
                                    <span data-lang="error-pages">Error Pages</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-error-pages" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.custom.error.400') }}"
                                        target="_blank"><span data-lang="error-400">400 Bad Request</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.error.401') }}"
                                        target="_blank"><span data-lang="error-401">401 Unauthorized</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.error.403') }}"
                                        target="_blank"><span data-lang="error-403">403 Forbidden</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.error.404') }}"
                                        target="_blank"><span data-lang="error-404">404 Not Found</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.error.408') }}"
                                        target="_blank"><span data-lang="error-408">408 Request Timeout</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.error.500') }}"
                                        target="_blank"><span data-lang="error-500">500 Internal Server</span></a>
                                    <a class="dropdown-item" href="{{ route('template.custom.error.maintenance') }}"
                                        target="_blank"><span data-lang="error-maintenance">Maintenance</span></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true"
                            class="nav-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" href="#"
                            id="topnav-layouts" role="button">
                            <span class="menu-icon"><i class="ti ti-table-column fs-xl"></i></span>
                            <span class="menu-text" data-lang="layouts">Layouts</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div aria-labelledby="topnav-layouts" class="dropdown-menu">
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-layout-options" role="button">
                                    <span data-lang="layout-options">Layout Options</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-layout-options" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.options.scrollable') }}"
                                        target="_blank"><span data-lang="layouts-scrollable">Scrollable</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.options.compact') }}"
                                        target="_blank"><span data-lang="layouts-compact">Compact</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.options.boxed') }}"
                                        target="_blank"><span data-lang="layouts-boxed">Boxed</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.options.horizontal') }}"
                                        target="_blank"><span data-lang="layouts-horizontal">Horizontal</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.options.preloader') }}"
                                        target="_blank"><span data-lang="layouts-preloader">Preloader</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-sidebars" role="button">
                                    <span data-lang="sidebars">Sidebars</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-sidebars" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.layouts.sidebars.light') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-light">Light Menu</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.sidebars.gradient') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-gradient">Gradient
                                            Menu</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.sidebars.gray') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-gray">Gray Menu</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.sidebars.image') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-image">Image Menu</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.sidebars.compact') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-compact">Compact
                                            Menu</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.sidebars.on-hover') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-on-hover">On Hover
                                            Menu</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.sidebars.on-hover-active') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-on-hover-active">On Hover
                                            Active</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.sidebars.offcanvas') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-offcanvas">Offcanvas
                                            Menu</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.sidebars.no-icons') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-no-icons">No Icons with
                                            Lines</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.layouts.sidebars.with-lines') }}"
                                        target="_blank"><span data-lang="layouts-sidebar-with-lines">Sidebar with
                                            Lines</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-topbar" role="button">
                                    <span data-lang="topbar">Topbar</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-topbar" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('template.layouts.topbar.dark') }}"
                                        target="_blank"><span data-lang="layouts-topbar-dark">Dark Topbar</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.topbar.gray') }}"
                                        target="_blank"><span data-lang="layouts-topbar-gray">Gray Topbar</span></a>
                                    <a class="dropdown-item" href="{{ route('template.layouts.topbar.gradient') }}"
                                        target="_blank"><span data-lang="layouts-topbar-gradient">Gradient
                                            Topbar</span></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true"
                            class="nav-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" href="#"
                            id="topnav-components" role="button">
                            <span class="menu-icon"><i class="ti ti-components fs-xl"></i></span>
                            <span class="menu-text" data-lang="components">Components</span>
                            <div class="menu-arrow"></div>
                        </a>
                        <div aria-labelledby="topnav-components" class="dropdown-menu">
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-base-ui" role="button">
                                    <span data-lang="base-ui">Base UI</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-base-ui"
                                    class="dropdown-menu dropdown-menu-columns">
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.accordions') }}"><span
                                            data-lang="ui-accordions">Accordions</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.alerts') }}"><span
                                            data-lang="ui-alerts">Alerts</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.images') }}"><span
                                            data-lang="ui-images">Images</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.badges') }}"><span
                                            data-lang="ui-badges">Badges</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.breadcrumb') }}"><span
                                            data-lang="ui-breadcrumb">Breadcrumb</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.buttons') }}"><span
                                            data-lang="ui-buttons">Buttons</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.cards') }}"><span
                                            data-lang="ui-cards">Cards</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.carousel') }}"><span
                                            data-lang="ui-carousel">Carousel</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.collapse') }}"><span
                                            data-lang="ui-collapse">Collapse</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.colors') }}"><span
                                            data-lang="ui-colors">Colors</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.dropdowns') }}"><span
                                            data-lang="ui-dropdowns">Dropdowns</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.videos') }}"><span
                                            data-lang="ui-videos">Videos</span></a>
                                    <a class="dropdown-item" href="{{ route('template.components.ui.grid') }}"><span
                                            data-lang="ui-grid">Grid Options</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.links') }}"><span
                                            data-lang="ui-links">Links</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.list-group') }}"><span
                                            data-lang="ui-list-group">List Group</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.modals') }}"><span
                                            data-lang="ui-modals">Modals</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.notifications') }}"><span
                                            data-lang="ui-notifications">Notifications</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.offcanvas') }}"><span
                                            data-lang="ui-offcanvas">Offcanvas</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.placeholders') }}"><span
                                            data-lang="ui-placeholders">Placeholders</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.pagination') }}"><span
                                            data-lang="ui-pagination">Pagination</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.popovers') }}"><span
                                            data-lang="ui-popovers">Popovers</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.progress') }}"><span
                                            data-lang="ui-progress">Progress</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.scrollspy') }}"><span
                                            data-lang="ui-scrollspy">Scrollspy</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.spinners') }}"><span
                                            data-lang="ui-spinners">Spinners</span></a>
                                    <a class="dropdown-item" href="{{ route('template.components.ui.tabs') }}"><span
                                            data-lang="ui-tabs">Tabs</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.tooltips') }}"><span
                                            data-lang="ui-tooltips">Tooltips</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.typography') }}"><span
                                            data-lang="ui-typography">Typography</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.ui.utilities') }}"><span
                                            data-lang="ui-utilities">Utilities</span></a>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('template.components.metrics') }}"><span
                                    data-lang="metrics">Metrics</span></a>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-charts" role="button">
                                    <span data-lang="charts">Charts</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-charts" class="dropdown-menu">
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-apex-charts"
                                            role="button">
                                            <span data-lang="apex-charts">Apex Charts</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-apex-charts"
                                            class="dropdown-menu dropdown-menu-columns">
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.area') }}"><span
                                                    data-lang="charts-apex-area">Area</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.bar') }}"><span
                                                    data-lang="charts-apex-bar">Bar</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.bubble') }}"><span
                                                    data-lang="charts-apex-bubble">Bubble</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.candlestick') }}"><span
                                                    data-lang="charts-apex-candlestick">Candlestick</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.column') }}"><span
                                                    data-lang="charts-apex-column">Column</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.heatmap') }}"><span
                                                    data-lang="charts-apex-heatmap">Heatmap</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.line') }}"><span
                                                    data-lang="charts-apex-line">Line</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.mixed') }}"><span
                                                    data-lang="charts-apex-mixed">Mixed</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.timeline') }}"><span
                                                    data-lang="charts-apex-timeline">Timeline</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.boxplot') }}"><span
                                                    data-lang="charts-apex-boxplot">Boxplot</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.treemap') }}"><span
                                                    data-lang="charts-apex-treemap">Treemap</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.pie') }}"><span
                                                    data-lang="charts-apex-pie">Pie</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.radar') }}"><span
                                                    data-lang="charts-apex-radar">Radar</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.radialbar') }}"><span
                                                    data-lang="charts-apex-radialbar">RadialBar</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.scatter') }}"><span
                                                    data-lang="charts-apex-scatter">Scatter</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.polar-area') }}"><span
                                                    data-lang="charts-apex-polar-area">Polar Area</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.sparklines') }}"><span
                                                    data-lang="charts-apex-sparklines">Sparklines</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.range') }}"><span
                                                    data-lang="charts-apex-range">Range</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.funnel') }}"><span
                                                    data-lang="charts-apex-funnel">Funnel</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.apex.slope') }}"><span
                                                    data-lang="charts-apex-slope">Slope</span></a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#" id="topnav-submenu-echarts"
                                            role="button">
                                            <span data-lang="echarts">Echarts</span>
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-echarts"
                                            class="dropdown-menu dropdown-menu-columns">
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.line') }}"><span
                                                    data-lang="charts-echart-line">Line</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.bar') }}"><span
                                                    data-lang="charts-echart-bar">Bar</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.pie') }}"><span
                                                    data-lang="charts-echart-pie">Pie</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.scatter') }}"><span
                                                    data-lang="charts-echart-scatter">Scatter</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.geo-map') }}"><span
                                                    data-lang="charts-echart-geo-map">GEO Map</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.gauge') }}"><span
                                                    data-lang="charts-echart-gauge">Gauge</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.candlestick') }}"><span
                                                    data-lang="charts-echart-candlestick">Candlestick</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.area') }}"><span
                                                    data-lang="charts-echart-area">Area</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.radar') }}"><span
                                                    data-lang="charts-echart-radar">Radar</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.heatmap') }}"><span
                                                    data-lang="charts-echart-heatmap">Heatmap</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.charts.echart.other') }}"><span
                                                    data-lang="charts-echart-other">Other</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-forms" role="button">
                                    <span data-lang="forms">Forms</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-forms" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.elements') }}"><span
                                            data-lang="form-elements">Basic Elements</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.pickers') }}"><span
                                            data-lang="form-pickers">Pickers</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.select') }}"><span
                                            data-lang="form-select">Select</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.validation') }}"><span
                                            data-lang="form-validation">Validation</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.wizard') }}"><span
                                            data-lang="form-wizard">Wizard</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.fileuploads') }}"><span
                                            data-lang="form-fileuploads">File Uploads</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.text-editors') }}"><span
                                            data-lang="form-text-editors">Text Editors</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.range-slider') }}"><span
                                            data-lang="form-range-slider">Range Slider</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.layout') }}"><span
                                            data-lang="form-layout">Layouts</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.forms.other-plugin') }}"><span
                                            data-lang="form-other-plugin">Other Plugins</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-tables" role="button">
                                    <span data-lang="tables">Tables</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-tables" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.tables.static') }}"><span
                                            data-lang="tables-static">Static Tables</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.tables.custom') }}"><span
                                            data-lang="tables-custom">Custom Tables</span></a>
                                    <div class="dropdown">
                                        <a aria-expanded="false" aria-haspopup="true"
                                            class="dropdown-item dropdown-toggle drop-arrow-none"
                                            data-bs-toggle="dropdown" href="#"
                                            id="topnav-submenu-datatables" role="button">
                                            <span data-lang="datatables">DataTables</span><span
                                                class="badge bg-success text-white">15</span>
                                        </a>
                                        <div aria-labelledby="topnav-submenu-datatables"
                                            class="dropdown-menu dropdown-menu-columns">
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.basic') }}"><span
                                                    data-lang="tables-datatables-basic">Basic</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.export-data') }}"><span
                                                    data-lang="tables-datatables-export-data">Export Data</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.select') }}"><span
                                                    data-lang="tables-datatables-select">Select</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.ajax') }}"><span
                                                    data-lang="tables-datatables-ajax">Ajax</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.javascript') }}"><span
                                                    data-lang="tables-datatables-javascript">Javascript
                                                    Source</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.rendering') }}"><span
                                                    data-lang="tables-datatables-rendering">Data Rendering</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.scroll') }}"><span
                                                    data-lang="tables-datatables-scroll">Scroll</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.fixed-columns') }}"><span
                                                    data-lang="tables-datatables-fixed-columns">Fixed
                                                    Columns</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.fixed-header') }}"><span
                                                    data-lang="tables-datatables-fixed-header">Fixed Header</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.columns') }}"><span
                                                    data-lang="tables-datatables-columns">Show &amp; Hide
                                                    Column</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.child-rows') }}"><span
                                                    data-lang="tables-datatables-child-rows">Child Rows</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.column-searching') }}"><span
                                                    data-lang="tables-datatables-column-searching">Column
                                                    Searching</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.range-search') }}"><span
                                                    data-lang="tables-datatables-range-search">Range Search</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.rows-add') }}"><span
                                                    data-lang="tables-datatables-rows-add">Add Rows</span></a>
                                            <a class="dropdown-item"
                                                href="{{ route('template.components.tables.datatables.checkbox-select') }}"><span
                                                    data-lang="tables-datatables-checkbox-select">Checkbox
                                                    Select</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-icons" role="button">
                                    <span data-lang="icons">Icons</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-icons" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.icons.tabler') }}"><span
                                            data-lang="icons-tabler">Tabler</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.icons.lucide') }}"><span
                                            data-lang="icons-lucide">Lucide</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.icons.flags') }}"><span
                                            data-lang="icons-flags">Flags</span></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a aria-expanded="false" aria-haspopup="true"
                                    class="dropdown-item dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    href="#" id="topnav-submenu-maps" role="button">
                                    <span data-lang="maps">Maps</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div aria-labelledby="topnav-submenu-maps" class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.maps.google') }}"><span
                                            data-lang="maps-google">Google Maps</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.maps.vector') }}"><span
                                            data-lang="maps-vector">Vector Maps</span></a>
                                    <a class="dropdown-item"
                                        href="{{ route('template.components.maps.leaflet') }}"><span
                                            data-lang="maps-leaflet">Leaflet Maps</span></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>
</header>
<!-- Horizontal Menu End -->
