<?php
$user = wp_get_current_user();
if (!in_array('administrator', (array) $user->roles)) {
    wp_redirect('/');
    exit();
}
?>

<head>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </style>
    <?php wp_head() ?>
</head>


<body>
    <div class="antialiased sans-serif bg-gray-200 min-h-screen pt-12">
        <div class="container mx-auto py-6 px-4" x-data="datatables()" x-cloak>
            <h1 class="text-3xl py-4 border-b mb-10">Product Orders</h1>
            <div x-show="selectedRows.length" class="bg-teal-200 fixed top-0 left-0 right-0 z-40 w-full shadow">
                <div class="container mx-auto px-4 py-4">
                    <div class="flex md:items-center">
                        <div class="mr-4 flex-shrink-0">
                            <svg class="h-8 w-8 text-teal-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div x-html="selectedRows.length + ' rows are selected'" class="text-teal-800 text-lg"></div>
                    </div>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <div class="flex-1 pr-4">
                    <div class="relative md:w-1/3">
                        <input type="search" class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Search...">
                        <div class="absolute top-0 left-0 inline-flex items-center p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="shadow rounded-lg flex">
                        <div class="relative">
                            <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                                </svg>
                                <span class="hidden md:block">Display</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                                <template x-for="heading in headings">
                                    <label class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                        <div class="text-teal-600 mr-3">
                                            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" checked @click="toggleColumn(heading.key)">
                                        </div>
                                        <div class="select-none text-gray-700" x-text="heading.value"></div>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php


            $args = array(
                'post_type' => 'orders',
                'post_status' => 'publish',
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) : ?>

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative" style="height: 405px;">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
                                    <label class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                        <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox($event);">
                                    </label>
                                </th>
                                <template x-for="heading in headings">
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs" x-text="heading.value" :x-ref="heading.key" :class="{ [heading.key]: true }"></th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="user in users" :key="user.orderId">

                                <?php
                                $i = 0;
                                while ($query->have_posts()) : $i++;
                                    $query->the_post(); ?>

                                <?php endwhile; ?>
                            <?php endif; ?>

                            <tr class="hover:bg-gray-100 cursor-pointer">
                                <td class="border-dashed border-t border-gray-200 px-3">
                                    <label class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                        <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :name="user.orderId" @click="getRowDetail($event, user.orderId)">
                                    </label>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box userId">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.orderId"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box orderTitle">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.title"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box firstName">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.name"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box lastName">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.email"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box emailAddress">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.phone"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box address">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.address"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box phoneNumber">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.city"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200 orders__box phoneNumber">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.postalcode"></span>
                                </td>
                            </tr>



                            </template>
                        </tbody>
                    </table>
                </div>
        </div>

    </div>



    <script>
        const {
            orders
        } = orders_data;

        document.addEventListener('DOMContentLoaded', (event) => {
            // document.querySelector('#page').classList.add('hidden')
            // document.querySelector('#wpadminbar').classList.add('hidden')
            document.querySelector('style[media="screen"]').innerHTML = ''
            // document.querySelector('.add-to-cart__html-open').classList.add('hidden')
        })

        const datatables = () => {
            return {
                headings: [{
                        'key': 'orderId',
                        'value': 'Order ID'
                    },
                    {
                        'key': 'orderTitle',
                        'value': 'Order Title'
                    },
                    {
                        'key': 'name',
                        'value': 'Fullname'
                    },
                    {
                        'key': 'emailAddress',
                        'value': 'Email'
                    },
                    {
                        'key': 'phoneNumber',
                        'value': 'Phone'
                    },
                    {
                        'key': 'address',
                        'value': 'Address'
                    },
                    {
                        'key': 'city',
                        'value': 'City'
                    },
                    {
                        'key': 'postalcode',
                        'value': 'Postal Code'
                    }
                ],
                users: orders,
                selectedRows: [],

                open: false,

                toggleColumn(key) {
                    // Note: All td must have the same class name as the headings key! 
                    let columns = document.querySelectorAll('.' + key);

                    if (this.$refs[key].classList.contains('hidden') && this.$refs[key].classList.contains(key)) {
                        columns.forEach(column => {
                            column.classList.remove('hidden');
                        });
                    } else {
                        columns.forEach(column => {
                            column.classList.add('hidden');
                        });
                    }
                },

                getRowDetail($event, id) {
                    let rows = this.selectedRows;

                    if (rows.includes(id)) {
                        let index = rows.indexOf(id);
                        rows.splice(index, 1);
                    } else {
                        rows.push(id);
                    }
                },

                selectAllCheckbox($event) {
                    let columns = document.querySelectorAll('.rowCheckbox');

                    this.selectedRows = [];

                    if ($event.target.checked == true) {
                        columns.forEach(column => {
                            column.checked = true
                            this.selectedRows.push(parseInt(column.name))
                        });
                    } else {
                        columns.forEach(column => {
                            column.checked = false
                        });
                        this.selectedRows = [];
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>

    <?php
    ?>
</body>