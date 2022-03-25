<?php

namespace App\Admin;

use App\Models\Role;
use App\Models\User;

class MenuProvider
{
    /**
     * Category
     * -----------------------------------------------------------------------------------------
     *  [
     *      'is_category' => true,      // required, boolean, default: true
     *      'label' => 'DASHBOARD',     // required, string
     *      'visible' => true,          // optional, boolean, default: true
     *  ]
     *
     * =========================================================================================
     *
     * Item
     * -----------------------------------------------------------------------------------------
     *  [
     *      'label' => 'Dashboard',                         // required, string
     *      'icon' => 'wb-dashboard',                       // required, string
     *      'url' => '',                                    // optional, string,            default: null
     *      'route' => '',                                  // optional, string,            default: null
     *      'action' => '',                                 // optional, string,            default: null
     *      'sub_route_names' => ['home', 'firm_feed'],     // optional, string|array|null, default: null
     *      'sub_route_actions' => ['home', 'firm_feed'],   // optional, string|array|null, default: null
     *      'sub_route_prefixes' => [],                     // optional, string|array|null, default: null
     *      'visible' => true,                              // optional, boolean,           default: true
     *      'info' => 'Info abou this menu',                // optional, string,            default: null
     *  ]
     *
     * Item with sub menu
     * -----------------------------------------------------------------------------------------
     *  [
     *      'label' => 'Dashboard',                         // required, string
     *      'icon' => 'wb-dashboard',                       // required, string
     *      'visible' => true,                              // optional, boolean,           default: true
     *      'sub_menus' => [Item: refer above Item],        // optional, string|array|null, default: null
     *  ]
     *
     */

    public static function getMenu() {
        return [
           /* [
                'label' => 'Dashboard',
                'icon'  => 'wb-dashboard',
                'route' => 'admin.home',
                'visible' => function () {
                    return true;
                },
            ],*/
            [
                'label' => 'Dashboard',
                'icon'  => 'wb-dashboard',
                'sub_menus' => [
                    [
                        'label' => 'Overview',

                        'route' => 'admin.dashboard',
                        'visible' => function () {
                            return true;
                        },
                    ],
                    [
                        'label' => 'Graphical Analatics',
                        'route' => 'admin.dashboard.graphical_view',
                        'visible' => function () {
                            return true;
                        },
                    ],

                ]
            ],
                [
                    'label' => 'Segments',
                    'icon'  => 'wb-dashboard',
                    'route' => 'admin.user-segments.index',
                    'visible' => function () {
                        return true;
                    },
                ],
            [
                'label' => 'Admins',
                'icon'  => 'wb-users',
                'route' => 'admin.admins.index',
                'visible' => function () {
                    return request()->user()->can(['admin.viewAny']);
                }
            ],
            [
                'label' => 'Banners',
                'icon'  => 'wb-gallery',
                'route' => 'admin.banners.index',
                'visible' => function () {
                    return request()->user()->can(['banners.viewAny']);
                }
            ],

            [
                'label' => 'Blogs',
                'icon'  => 'wb-folder',
                'sub_menus' => [
                    [
                        'label' => 'Categories',
                        'icon'  => 'wb-video',
                        'route' => 'admin.categories.index',
                        'visible' => function () {
                            return request()->user()->can(['categories.viewAny']);
                        }
                    ],
                    [
                        'label' => 'All Blogs',
                        'icon'  => 'wb-book',
                        'route' => 'admin.blogs.index',
                        'visible' => function () {
                            return request()->user()->can(['blogs.viewAny']);
                        }
                    ],

                ]
            ],

            [
                'label' => 'Exam notifications',
                'icon'  => 'wb-bell',
                'sub_menus' => [
                    [
                        'label' => 'Categories',
                        'route' => 'admin.exam-categories.index',
                        'visible' => function () {
                            return request()->user()->can(['examCategories.viewAny']);
                        }
                    ],
                    [
                        'label' => 'All Notifications',
                        'route' => 'admin.exam-notifications.index',
                        'visible' => function () {
                            return request()->user()->can(['examNotifications.viewAny']);
                        }
                    ],
                ]
            ],
            [
                'label' => 'Popular Search',
                'icon'  => 'wb-search',
                'route' => 'admin.popular-searches.index',
                'visible' => function () {
                    return request()->user()->can(['popular_search.viewAny']);
                }
            ],
            [
                'label' => 'Testimonials',
                'icon'  => 'wb-quote-right',
                'route' => 'admin.testimonials.index',
                'visible' => function () {
                    return request()->user()->can(['testimonials.viewAny']);
                }
            ],
            [
                'label' => 'Tests',
                'icon'  => 'wb-help-circle',
                'visible' => function () {
                    return request()->user()->can(['questions.viewAny']);
                },
                'sub_menus' => [
                    [
                        'label' => 'Category',
                        'route' => 'admin.test-categories.index',
                        'visible' => function () {
                            return request()->user()->can(['test-categories.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Questions',
                        'route' => 'admin.questions.index',
                        'visible' => function () {
                            return request()->user()->can(['questions.viewAny']);
                        }
                    ],
                    [
                        'label' => 'All Tests',
                        'route' => 'admin.tests.index',
                        'visible' => function () {
                            return request()->user()->can(['tests.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Test Attempts',
                        'route' => 'admin.test-attempts.index',
                        'visible' => function () {
                            return request()->user()->can(['tests.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Test Results',
                        'route' => 'admin.test-results.index',
                        'visible' => function () {
                            return request()->user()->can(['tests.viewAny']);
                        }
                    ],

                ]
            ],
            [
                'label' => 'Students',
                'icon'  => 'wb-user',
                'route' => 'admin.students.index',
                'visible' => function () {
                    return request()->user()->can(['students.viewAny']);
                }
            ],
            [
                'label' => 'Doubts',
                'icon'  => 'wb-help-circle',
                'route' => 'admin.doubts.index',
                'visible' => function () {
                    return request()->user()->can(['doubts.viewAny']);
                }
            ],
            [
                'label' => 'Packages',
                'icon'  => 'wb-library',
                'route' => 'admin.packages.index',
                'visible' => function () {
                    return request()->user()->can(['packages.viewAny']);
                }
            ],
            [
                'label' => 'Contacts',
                'icon'  => 'wb-envelope',
                'route' => 'admin.contacts.index',
                'visible' => function () {
                    return request()->user()->can(['contacts.viewAny']);
                }
            ],
            [
                'label' => 'Transactions',
                'icon'  => 'wb-payment',
                'route' => 'admin.transactions.index',
                'visible' => function () {
                    return request()->user()->can(['contacts.viewAny']);
                }
            ],
            [
                'label' => 'Contents',
                'icon'  => 'wb-folder',
                'visible' => function () {
                    if(request()->user()->can(['videos.viewAny']) || request()->user()->can(['documents.viewAny']) ){
                        return true;
                    }
                    else{
                        return false;
                    }
                },
                'sub_menus' => [
                    [
                        'label' => 'Videos',
                        'icon'  => 'wb-video',
                        'route' => 'admin.videos.index',
                        'visible' => function () {
                            return request()->user()->can(['videos.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Documents',
                        'icon'  => 'wb-book',
                        'route' => 'admin.documents.index',
                        'visible' => function () {
                            return request()->user()->can(['documents.viewAny']);
                        }
                    ],
                ]
            ],

            [
                'label' => 'Settings',
                'icon'  => 'wb-settings',
                'visible' => function () {
                    if(request()->user()->can(['courses.viewAny']) || request()->user()->can(['subjects.viewAny']) ||
                        request()->user()->can(['chapters.viewAny']) ||  (request()->user()->role_id ==  User::ROLE_ADMIN) ){
                        return true;
                    }
                    else{
                        return false;
                    }
                },
                'sub_menus' => [
                    [
                        'label' => 'Courses',
                        'icon'  => 'wb-menu',
                        'route' => 'admin.courses.index',
                        'visible' => function () {
                            return request()->user()->can(['courses.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Subjects',
                        'icon'  => 'wb-book',
                        'route' => 'admin.subjects.index',
                        'visible' => function () {
                            return request()->user()->can(['subjects.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Chapters',
                        'icon'  => 'wb-book',
                        'route' => 'admin.chapters.index',
                        'visible' => function () {
                            return request()->user()->can(['chapters.viewAny']);
                        }
                    ],
                    [
                        'label' => 'Roles',
                        'icon'  => 'wb-book',
                        'route' => 'admin.roles.index',
                        'visible' => function () {
                            if (request()->user()->role_id ==  User::ROLE_ADMIN) {
                                return true;
                            }
                        }

                    ],
                ]
            ],


        ];
    }
}
