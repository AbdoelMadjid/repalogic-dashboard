<?php

return [
    'title' => 'Components',
    'data_lang' => 'components',
    'items' => [
        [
            'title' => 'Base UI',
            'data_lang' => 'base-ui',
            'icon' => 'ti ti-components',
            'id' => 'base-ui',
            'badge' => [
                'text' => 'New',
                'class' => 'badge bg-danger text-white',
            ],
            'children' => [
                [
                    'title' => 'Accordions',
                    'data_lang' => 'ui-accordions',
                    'route' => 'template.components.ui.accordions',
                ],
                [
                    'title' => 'Alerts',
                    'data_lang' => 'ui-alerts',
                    'route' => 'template.components.ui.alerts',
                ],
                [
                    'title' => 'Images',
                    'data_lang' => 'ui-images',
                    'route' => 'template.components.ui.images',
                ],
                [
                    'title' => 'Badges',
                    'data_lang' => 'ui-badges',
                    'route' => 'template.components.ui.badges',
                ],
                [
                    'title' => 'Breadcrumb',
                    'data_lang' => 'ui-breadcrumb',
                    'route' => 'template.components.ui.breadcrumb',
                ],
                [
                    'title' => 'Buttons',
                    'data_lang' => 'ui-buttons',
                    'route' => 'template.components.ui.buttons',
                ],
                [
                    'title' => 'Cards',
                    'data_lang' => 'ui-cards',
                    'route' => 'template.components.ui.cards',
                ],
                [
                    'title' => 'Carousel',
                    'data_lang' => 'ui-carousel',
                    'route' => 'template.components.ui.carousel',
                ],
                [
                    'title' => 'Collapse',
                    'data_lang' => 'ui-collapse',
                    'route' => 'template.components.ui.collapse',
                ],
                [
                    'title' => 'Colors',
                    'data_lang' => 'ui-colors',
                    'route' => 'template.components.ui.colors',
                ],
                [
                    'title' => 'Dropdowns',
                    'data_lang' => 'ui-dropdowns',
                    'route' => 'template.components.ui.dropdowns',
                ],
                [
                    'title' => 'Videos',
                    'data_lang' => 'ui-videos',
                    'route' => 'template.components.ui.videos',
                ],
                [
                    'title' => 'Grid Options',
                    'data_lang' => 'ui-grid',
                    'route' => 'template.components.ui.grid',
                ],
                [
                    'title' => 'Links',
                    'data_lang' => 'ui-links',
                    'route' => 'template.components.ui.links',
                ],
                [
                    'title' => 'List Group',
                    'data_lang' => 'ui-list-group',
                    'route' => 'template.components.ui.list-group',
                ],
                [
                    'title' => 'Modals',
                    'data_lang' => 'ui-modals',
                    'route' => 'template.components.ui.modals',
                ],
                [
                    'title' => 'Notifications',
                    'data_lang' => 'ui-notifications',
                    'route' => 'template.components.ui.notifications',
                ],
                [
                    'title' => 'Offcanvas',
                    'data_lang' => 'ui-offcanvas',
                    'route' => 'template.components.ui.offcanvas',
                ],
                [
                    'title' => 'Placeholders',
                    'data_lang' => 'ui-placeholders',
                    'route' => 'template.components.ui.placeholders',
                ],
                [
                    'title' => 'Pagination',
                    'data_lang' => 'ui-pagination',
                    'route' => 'template.components.ui.pagination',
                ],
                [
                    'title' => 'Popovers',
                    'data_lang' => 'ui-popovers',
                    'route' => 'template.components.ui.popovers',
                ],
                [
                    'title' => 'Progress',
                    'data_lang' => 'ui-progress',
                    'route' => 'template.components.ui.progress',
                ],
                [
                    'title' => 'Scrollspy',
                    'data_lang' => 'ui-scrollspy',
                    'route' => 'template.components.ui.scrollspy',
                ],
                [
                    'title' => 'Spinners',
                    'data_lang' => 'ui-spinners',
                    'route' => 'template.components.ui.spinners',
                ],
                [
                    'title' => 'Tabs',
                    'data_lang' => 'ui-tabs',
                    'route' => 'template.components.ui.tabs',
                ],
                [
                    'title' => 'Tooltips',
                    'data_lang' => 'ui-tooltips',
                    'route' => 'template.components.ui.tooltips',
                ],
                [
                    'title' => 'Typography',
                    'data_lang' => 'ui-typography',
                    'route' => 'template.components.ui.typography',
                ],
                [
                    'title' => 'Utilities',
                    'data_lang' => 'ui-utilities',
                    'route' => 'template.components.ui.utilities',
                ],
            ],
        ],
        [
            'title' => 'Widgets',
            'data_lang' => 'widgets',
            'icon' => 'ti ti-stack-2',
            'route' => 'template.components.widgets',
            'badge' => [
                'text' => 'v 2.2',
                'class' => 'badge bg-success',
            ],
        ],
        [
            'title' => 'Metrics',
            'data_lang' => 'metrics',
            'icon' => 'ti ti-chart-histogram',
            'route' => 'template.components.metrics',
        ],
        [
            'title' => 'Charts',
            'data_lang' => 'charts',
            'icon' => 'ti ti-chart-donut',
            'id' => 'charts',
            'children' => [
                [
                    'title' => 'Apex Charts',
                    'data_lang' => 'apex-charts',
                    'id' => 'apex-charts',
                    'children' => [
                        [
                            'title' => 'Area',
                            'data_lang' => 'charts-apex-area',
                            'route' => 'template.components.charts.apex.area',
                        ],
                        [
                            'title' => 'Bar',
                            'data_lang' => 'charts-apex-bar',
                            'route' => 'template.components.charts.apex.bar',
                        ],
                        [
                            'title' => 'Bubble',
                            'data_lang' => 'charts-apex-bubble',
                            'route' => 'template.components.charts.apex.bubble',
                        ],
                        [
                            'title' => 'Candlestick',
                            'data_lang' => 'charts-apex-candlestick',
                            'route' => 'template.components.charts.apex.candlestick',
                        ],
                        [
                            'title' => 'Column',
                            'data_lang' => 'charts-apex-column',
                            'route' => 'template.components.charts.apex.column',
                        ],
                        [
                            'title' => 'Heatmap',
                            'data_lang' => 'charts-apex-heatmap',
                            'route' => 'template.components.charts.apex.heatmap',
                        ],
                        [
                            'title' => 'Line',
                            'data_lang' => 'charts-apex-line',
                            'route' => 'template.components.charts.apex.line',
                        ],
                        [
                            'title' => 'Mixed',
                            'data_lang' => 'charts-apex-mixed',
                            'route' => 'template.components.charts.apex.mixed',
                        ],
                        [
                            'title' => 'Timeline',
                            'data_lang' => 'charts-apex-timeline',
                            'route' => 'template.components.charts.apex.timeline',
                        ],
                        [
                            'title' => 'Boxplot',
                            'data_lang' => 'charts-apex-boxplot',
                            'route' => 'template.components.charts.apex.boxplot',
                        ],
                        [
                            'title' => 'Treemap',
                            'data_lang' => 'charts-apex-treemap',
                            'route' => 'template.components.charts.apex.treemap',
                        ],
                        [
                            'title' => 'Pie',
                            'data_lang' => 'charts-apex-pie',
                            'route' => 'template.components.charts.apex.pie',
                        ],
                        [
                            'title' => 'Radar',
                            'data_lang' => 'charts-apex-radar',
                            'route' => 'template.components.charts.apex.radar',
                        ],
                        [
                            'title' => 'RadialBar',
                            'data_lang' => 'charts-apex-radialbar',
                            'route' => 'template.components.charts.apex.radialbar',
                        ],
                        [
                            'title' => 'Scatter',
                            'data_lang' => 'charts-apex-scatter',
                            'route' => 'template.components.charts.apex.scatter',
                        ],
                        [
                            'title' => 'Polar Area',
                            'data_lang' => 'charts-apex-polar-area',
                            'route' => 'template.components.charts.apex.polar-area',
                        ],
                        [
                            'title' => 'Sparklines',
                            'data_lang' => 'charts-apex-sparklines',
                            'route' => 'template.components.charts.apex.sparklines',
                        ],
                        [
                            'title' => 'Range',
                            'data_lang' => 'charts-apex-range',
                            'route' => 'template.components.charts.apex.range',
                        ],
                        [
                            'title' => 'Funnel',
                            'data_lang' => 'charts-apex-funnel',
                            'route' => 'template.components.charts.apex.funnel',
                        ],
                        [
                            'title' => 'Slope',
                            'data_lang' => 'charts-apex-slope',
                            'route' => 'template.components.charts.apex.slope',
                        ],
                    ],
                ],
                [
                    'title' => 'Echarts',
                    'data_lang' => 'echarts',
                    'id' => 'echarts',
                    'children' => [
                        [
                            'title' => 'Line',
                            'data_lang' => 'charts-echart-line',
                            'route' => 'template.components.charts.echart.line',
                        ],
                        [
                            'title' => 'Bar',
                            'data_lang' => 'charts-echart-bar',
                            'route' => 'template.components.charts.echart.bar',
                        ],
                        [
                            'title' => 'Pie',
                            'data_lang' => 'charts-echart-pie',
                            'route' => 'template.components.charts.echart.pie',
                        ],
                        [
                            'title' => 'Scatter',
                            'data_lang' => 'charts-echart-scatter',
                            'route' => 'template.components.charts.echart.scatter',
                        ],
                        [
                            'title' => 'GEO Map',
                            'data_lang' => 'charts-echart-geo-map',
                            'route' => 'template.components.charts.echart.geo-map',
                        ],
                        [
                            'title' => 'Gauge',
                            'data_lang' => 'charts-echart-gauge',
                            'route' => 'template.components.charts.echart.gauge',
                        ],
                        [
                            'title' => 'Candlestick',
                            'data_lang' => 'charts-echart-candlestick',
                            'route' => 'template.components.charts.echart.candlestick',
                        ],
                        [
                            'title' => 'Area',
                            'data_lang' => 'charts-echart-area',
                            'route' => 'template.components.charts.echart.area',
                        ],
                        [
                            'title' => 'Radar',
                            'data_lang' => 'charts-echart-radar',
                            'route' => 'template.components.charts.echart.radar',
                        ],
                        [
                            'title' => 'Heatmap',
                            'data_lang' => 'charts-echart-heatmap',
                            'route' => 'template.components.charts.echart.heatmap',
                        ],
                        [
                            'title' => 'Other',
                            'data_lang' => 'charts-echart-other',
                            'route' => 'template.components.charts.echart.other',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Forms',
            'data_lang' => 'forms',
            'icon' => 'ti ti-clipboard-list',
            'id' => 'forms',
            'children' => [
                [
                    'title' => 'Basic Elements',
                    'data_lang' => 'form-elements',
                    'route' => 'template.components.forms.elements',
                ],
                [
                    'title' => 'Pickers',
                    'data_lang' => 'form-pickers',
                    'route' => 'template.components.forms.pickers',
                ],
                [
                    'title' => 'Select',
                    'data_lang' => 'form-select',
                    'route' => 'template.components.forms.select',
                ],
                [
                    'title' => 'Validation',
                    'data_lang' => 'form-validation',
                    'route' => 'template.components.forms.validation',
                ],
                [
                    'title' => 'Wizard',
                    'data_lang' => 'form-wizard',
                    'route' => 'template.components.forms.wizard',
                ],
                [
                    'title' => 'File Uploads',
                    'data_lang' => 'form-fileuploads',
                    'route' => 'template.components.forms.fileuploads',
                ],
                [
                    'title' => 'Text Editors',
                    'data_lang' => 'form-text-editors',
                    'route' => 'template.components.forms.text-editors',
                ],
                [
                    'title' => 'Range Slider',
                    'data_lang' => 'form-range-slider',
                    'route' => 'template.components.forms.range-slider',
                ],
                [
                    'title' => 'Layouts',
                    'data_lang' => 'form-layout',
                    'route' => 'template.components.forms.layout',
                ],
                [
                    'title' => 'Other Plugins',
                    'data_lang' => 'form-other-plugin',
                    'route' => 'template.components.forms.other-plugin',
                ],
            ],
        ],
        [
            'title' => 'Tables',
            'data_lang' => 'tables',
            'icon' => 'ti ti-table-column',
            'id' => 'tables',
            'children' => [
                [
                    'title' => 'Static Tables',
                    'data_lang' => 'tables-static',
                    'route' => 'template.components.tables.static',
                ],
                [
                    'title' => 'Custom Tables',
                    'data_lang' => 'tables-custom',
                    'route' => 'template.components.tables.custom',
                ],
                [
                    'title' => 'DataTables',
                    'data_lang' => 'datatables',
                    'id' => 'datatables',
                    'badge' => [
                        'text' => '15',
                        'class' => 'badge bg-success text-white',
                    ],
                    'children' => [
                        [
                            'title' => 'Basic',
                            'data_lang' => 'tables-datatables-basic',
                            'route' => 'template.components.tables.datatables.basic',
                        ],
                        [
                            'title' => 'Export Data',
                            'data_lang' => 'tables-datatables-export-data',
                            'route' => 'template.components.tables.datatables.export-data',
                        ],
                        [
                            'title' => 'Select',
                            'data_lang' => 'tables-datatables-select',
                            'route' => 'template.components.tables.datatables.select',
                        ],
                        [
                            'title' => 'Ajax',
                            'data_lang' => 'tables-datatables-ajax',
                            'route' => 'template.components.tables.datatables.ajax',
                        ],
                        [
                            'title' => 'Javascript Source',
                            'data_lang' => 'tables-datatables-javascript',
                            'route' => 'template.components.tables.datatables.javascript',
                        ],
                        [
                            'title' => 'Data Rendering',
                            'data_lang' => 'tables-datatables-rendering',
                            'route' => 'template.components.tables.datatables.rendering',
                        ],
                        [
                            'title' => 'Scroll',
                            'data_lang' => 'tables-datatables-scroll',
                            'route' => 'template.components.tables.datatables.scroll',
                        ],
                        [
                            'title' => 'Fixed Columns',
                            'data_lang' => 'tables-datatables-fixed-columns',
                            'route' => 'template.components.tables.datatables.fixed-columns',
                        ],
                        [
                            'title' => 'Fixed Header',
                            'data_lang' => 'tables-datatables-fixed-header',
                            'route' => 'template.components.tables.datatables.fixed-header',
                        ],
                        [
                            'title' => 'Show & Hide Column',
                            'data_lang' => 'tables-datatables-columns',
                            'route' => 'template.components.tables.datatables.columns',
                        ],
                        [
                            'title' => 'Child Rows',
                            'data_lang' => 'tables-datatables-child-rows',
                            'route' => 'template.components.tables.datatables.child-rows',
                        ],
                        [
                            'title' => 'Column Searching',
                            'data_lang' => 'tables-datatables-column-searching',
                            'route' => 'template.components.tables.datatables.column-searching',
                        ],
                        [
                            'title' => 'Range Search',
                            'data_lang' => 'tables-datatables-range-search',
                            'route' => 'template.components.tables.datatables.range-search',
                        ],
                        [
                            'title' => 'Add Rows',
                            'data_lang' => 'tables-datatables-rows-add',
                            'route' => 'template.components.tables.datatables.rows-add',
                        ],
                        [
                            'title' => 'Checkbox Select',
                            'data_lang' => 'tables-datatables-checkbox-select',
                            'route' => 'template.components.tables.datatables.checkbox-select',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Icons',
            'data_lang' => 'icons',
            'icon' => 'ti ti-icons',
            'id' => 'icons',
            'children' => [
                [
                    'title' => 'Tabler',
                    'data_lang' => 'icons-tabler',
                    'route' => 'template.components.icons.tabler',
                ],
                [
                    'title' => 'Lucide',
                    'data_lang' => 'icons-lucide',
                    'route' => 'template.components.icons.lucide',
                ],
                [
                    'title' => 'Flags',
                    'data_lang' => 'icons-flags',
                    'route' => 'template.components.icons.flags',
                ],
            ],
        ],
        [
            'title' => 'Maps',
            'data_lang' => 'maps',
            'icon' => 'ti ti-map',
            'id' => 'maps',
            'children' => [
                [
                    'title' => 'Google Maps',
                    'data_lang' => 'maps-google',
                    'route' => 'template.components.maps.google',
                ],
                [
                    'title' => 'Vector Maps',
                    'data_lang' => 'maps-vector',
                    'route' => 'template.components.maps.vector',
                ],
                [
                    'title' => 'Leaflet Maps',
                    'data_lang' => 'maps-leaflet',
                    'route' => 'template.components.maps.leaflet',
                ],
            ],
        ],
    ],
];
