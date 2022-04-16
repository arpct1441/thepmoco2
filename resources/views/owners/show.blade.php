<x-app-layout>
    @section('title', '| '.$owner->owner)
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
                                <li><a href="/property/{{ Session::get('property') }}/owners"
                                        class="text-blue-600 hover:text-blue-700">Owners</a>
                                </li>
                                <li><span class="text-gray-500 mx-2">/</span></li>
                                <li class="text-gray-500">{{ $owner->owner }}</li>
                            </ol>
                        </nav>
                    </h2>
                </div>
                <h5 class="flex-1 text-right">
                    <x-button onclick="window.location.href='/owner/{{ $owner->uuid }}/edit'">
                        Edit</x-button>
                    {{--<x-button
                        onclick="window.location.href='/unit/{{ $unit->uuid }}/contract/{{ Str::random(10) }}/create'">
                        Add Contract</x-button> --}}
                    <x-button id="dropdownButton" data-dropdown-toggle="dropdown" type="button">Create <svg
                            class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg></x-button>

                    <!-- Dropdown menu -->
                    <div id="dropdown"
                        class="hidden z-10 w-30 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                        <ul class="py-1" aria-labelledby="dropdownButton">
                            <li>
                                <a href="/unit/{{ $owner->uuid }}/owner/{{ Str::random(10) }}/create"
                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tenant
                                    Contract</a>
                            </li>
                        </ul>
                    </div>
                </h5>
            </div>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <div class="flex justify-center">
                        <div class="flex flex-col md:flex-row md:max-w-xl rounded-lg bg-white">
                            <img src="/storage/{{ $owner->photo_id }}"
                                class="p-2 bg-white border rounded max-w-xs mt-5 mx-5 ml-5 mr-5" alt="..." />
                        </div>
                        <div class="flex flex-col md:flex-row md:max-w-xl">

                            <div class="p-6 flex flex-col justify-start">
                                <h5 class="text-gray-900 text-xl font-medium mb-2">{{ $owner->owner }}</h5>
                                <hr>
                                <p class="mt-5 text-gray-700 text-base mb-4">
                                    Email: {{ $owner->email }}
                                </p>
                                <p class="text-gray-700 text-base mb-4">
                                    Mobile: {{ $owner->mobile_number }}
                                </p>
                                <p class="text-gray-700 text-base mb-4">
                                    Birthdate: {{ Carbon\Carbon::parse($owner->birthdate)->format('M d, Y') }} ({{
                                    Carbon\Carbon::now()->diffForHumans($owner->birthdate)}})
                                </p>
                                <p class="text-gray-700 text-base mb-4">
                                    Civil status: {{ $owner->civil_status }}
                                </p>
                                <p class="text-gray-700 text-base mb-4">
                                    Gender: {{ $owner->gender }}
                                </p>

                                <p class="text-gray-700 text-base mb-4">
                                    Address: {{ $owner->barangay.', '.$owner->province->province.',
                                    '.$owner->country->country }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="mb-3">
                                    <span class="text-center text-red">{{ Str::plural('Deed of sales',
                                        $deed_of_sales->count())}}
                                        ({{ $deed_of_sales->count() }})</span>
                                </div>
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <?php $ctr =1; ?>
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    #</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Unit</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Duration</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Rent/mo</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Moveout reason</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                </th>
                                            </tr>
                                        </thead>
                                        @forelse ($deed_of_sales as $deed_of_sale)
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $ctr++ }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $deed_of_sale->unit->unit }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{
                                                        $deed_of_sale->unit->building->building
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{
                                                        Carbon\Carbon::parse($deed_of_sale->start)->format('M d, Y').' -
                                                        '.Carbon\Carbon::parse($deed_of_sale->end)->format('M d, Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{
                                                        Carbon\Carbon::parse($deed_of_sale->end)->diffForHumans($deed_of_sale->start)
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{number_format($deed_of_sale->rent, 2)}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($deed_of_sale->status === 'active')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ $deed_of_sale->status }}
                                                    </span>
                                                    @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ $deed_of_sale->status }}
                                                    </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $deed_of_sale->moveout_reason?$deed_of_sale->moveout_reason:'NA'
                                                    }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <i class="fa-solid fa-down"></i>
                                                </td>

                                            </tr>
                                        </tbody>
                                        @empty
                                        <span class="text-center text-red">No Deed of sales found!</span>
                                        @endforelse
                                    </table>
                                </div>

                                <div class="mb-3 mt-5">
                                    <span class="text-center text-red">{{ Str::plural('Leasing Enrollment Histories',
                                        $enrollments->count())}}
                                        ({{ $enrollments->count() }})</span>
                                </div>
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <?php $ctr =1; ?>
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    #</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Unit</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Duration</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Rent/mo</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Moveout reason</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                </th>
                                            </tr>
                                        </thead>
                                        @forelse ($enrollments as $enrollment)
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $ctr++ }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $enrollment->unit->unit }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{
                                                        $enrollment->unit->building->building
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{
                                                        Carbon\Carbon::parse($enrollment->start)->format('M d, Y').' -
                                                        '.Carbon\Carbon::parse($enrollment->end)->format('M d, Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{
                                                        Carbon\Carbon::parse($enrollment->end)->diffForHumans($enrollment->start)
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{number_format($enrollment->rent, 2)}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($enrollment->status === 'active')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ $enrollment->status }}
                                                    </span>
                                                    @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ $enrollment->status }}
                                                    </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $enrollment->moveout_reason?$enrollment->moveout_reason:'NA'
                                                    }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <i class="fa-solid fa-down"></i>
                                                </td>

                                            </tr>
                                        </tbody>
                                        @empty
                                        <span class="text-center text-red">No Leasing Enrollment Histories found!</span>
                                        @endforelse
                                    </table>
                                </div>

                                <div class="mb-3 mt-5">
                                    <span class="text-center text-red">{{ Str::plural('Representative',
                                        $representatives->count())}}
                                        ({{ $representatives->count() }})</span>
                                </div>
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <?php $ctr =1; ?>
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    #</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Relatiosnhip</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Email</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Mobile</th>
                                            </tr>
                                        </thead>
                                        @forelse ($representatives as $representative)
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $ctr++ }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $representative->representative }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $representative->relationship->relationship }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $representative->email }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $representative->mobile_number }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        @empty
                                        <span class="text-center text-red">No representatives found!</span>
                                        @endforelse
                                    </table>
                                </div>

                                <div class="mb-3 mt-5">
                                    <span class="text-center text-red">{{ Str::plural('Bank',
                                        $banks->count())}}
                                        ({{ $banks->count() }})</span>
                                </div>
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <?php $ctr =1; ?>
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    #</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Relatiosnhip</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Email</th>
                                              
                                            </tr>
                                        </thead>
                                        @forelse ($banks as $bank)
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $ctr++ }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $bank->account_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $bank->bank_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $bank->account_number }}
                                                </td>
                                               
                                            </tr>
                                        </tbody>
                                        @empty
                                        <span class="text-center text-red">No representatives found!</span>
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