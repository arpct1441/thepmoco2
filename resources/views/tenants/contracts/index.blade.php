<x-app-layout>
    @section('title', $tenant->tenant)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="h-3">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <nav class="rounded-md">
                            <ol class="list-reset flex">
                                <li><a href="/property/{{ Session::get('property') }}"
                                        class="text-blue-600 hover:text-blue-700">{{
                                        Session::get('property_name') }}</a>
                                </li>
                                <li><span class="text-gray-500 mx-2">/</span></li>
                                <li><span class="text-gray-500 mx-2">Unit</span></li>
                                <li><span class="text-gray-500 mx-2">/</span></li>
                                <li class="text-gray-500">{{ $tenant->tenant }}</li>
                            </ol>
                        </nav>
                    </h2>
                </div>
                <h5 class="flex-1 text-right">
                    <x-button onclick="window.location.href='/property/{{ Session::get('property') }}/tenants'"><i
                            class="fa-solid fa-circle-arrow-left"></i>&nbsp Back
                    </x-button>


                </h5>

            </div>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <?php $ctr =1; ?>
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <x-th>#</x-th>
                                                <x-th>Tenant</x-th>
                                                <x-th>Duration</x-th>
                                                <x-th>Rent/Mo</x-th>
                                                <x-th>Status</x-th>
                                                <x-th>Interaction</x-th>
                                                <x-th></x-th>
                                            </tr>
                                        </thead>
                                        @forelse ($contracts as $item)
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <x-td>{{ $ctr++ }}</x-td>
                                                <x-td>
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full"
                                                                src="/storage/{{ $item->tenant->photo_id }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900"><b>{{
                                                                    $item->tenant->tenant }}</b>
                                                            </div>
                                                            <div class="text-sm text-gray-500">{{
                                                                $item->tenant->type
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </x-td>
                                                <x-td>
                                                    <div class="text-sm text-gray-900">{{
                                                        Carbon\Carbon::parse($item->start)->format('M d, Y').' -
                                                        '.Carbon\Carbon::parse($item->end)->format('M d, Y') }}
                                                    </div>

                                                    <div class="text-sm text-gray-500">{{
                                                        Carbon\Carbon::parse($item->end)->diffInMonths($item->start)
                                                        }} months
                                                    </div>
                                                    @if($item->end <= Carbon\Carbon::now()->addMonth())
                                                        <span
                                                            class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 dark:bg-red-700 dark:text-red-300">
                                                            <svg class="mr-1 w-3 h-3" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            expiring
                                                        </span>
                                                        @endif
                                                </x-td>
                                                <x-td>{{number_format($item->rent, 2)}}</x-td>
                                                <x-td>
                                                    @if($item->status === 'active')
                                                    <span
                                                        class="px-2 text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        <i class="fa-solid fa-circle-check"></i> {{ $item->status }}
                                                        @else
                                                        <span
                                                            class="px-2 text-sm leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                            <i class="fa-solid fa-circle-xmark"></i> {{
                                                            $item->status }}
                                                        </span>
                                                        @endif
                                                </x-td>
                                                <x-td>{{ $item->interaction }}</x-td>
                                                <x-td>
                                                    <button id="dropdownDividerButton"
                                                        data-dropdown-toggle="dropdownDivider.{{ $item->uuid }}"
                                                        class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800"
                                                        type="button"><i
                                                            class="fa-solid fa-list-check"></i>&nbspOptions<svg
                                                            class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7">
                                                            </path>
                                                        </svg></button>

                                                    <div id="dropdownDivider.{{ $item->uuid }}"
                                                        class="hidden z-10 w-44 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-1" aria-labelledby="dropdownDividerButton">
                                                            <li>
                                                                <a href="/tenant/{{ $item->tenant->uuid }}/"
                                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"><i
                                                                        class="fa-solid fa-user"></i>&nbspShow
                                                                    Tenant</a>
                                                            </li>
                                                            <li>
                                                                <a href="/contract/{{ $item->uuid }}/edit"
                                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"><i
                                                                        class="fa-solid fa-file-contract"></i>&nbspShow
                                                                    Contract</a>
                                                            </li>

                                                            <li>
                                                                <a href="/contract/{{ $item->uuid }}/transfer"
                                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"><i
                                                                        class="fa-solid fa-arrow-right-arrow-left"></i>&nbspTransfer
                                                                    Contract</a>
                                                            </li>
                                                            <li>
                                                                <a href="/contract/{{ $item->uuid }}/renew"
                                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"><i
                                                                        class="fa-solid fa-arrow-rotate-right"></i>&nbspRenew
                                                                    Contract</a>
                                                            </li>

                                                        </ul>
                                                        @if($item->status == 'active')
                                                        <div class="py-1">
                                                            <a href="/contract/{{ $item->uuid }}/moveout/bills"
                                                                class="block py-2 px-4 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                                <i
                                                                    class="fa-solid fa-arrow-right-to-bracket"></i>&nbspMoveout</a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </x-td>
                                                @empty
                                                <x-td>No data found!</x-td>
                                            </tr>
                                        </tbody>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>