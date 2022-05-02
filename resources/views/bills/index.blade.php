<x-app-layout>
    @section('title', '| Bills')
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
                                <li class="text-gray-500">Bills</li>
                            </ol>
                        </nav>
                    </h2>
                </div>
                <h5 class="flex-1 text-right">
                    <x-button data-modal-toggle="create-particular-modal">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp Particular
                    </x-button>
                    @can('billing')
                    <x-button data-modal-toggle="create-bill-modal"><i class="fa-solid fa-circle-plus"></i>&nbsp Bill
                    </x-button>
                    @endcan
                </h5>
                @include('utilities.create-bill')
            </div>
        </h2>
    </x-slot>
    @livewire('bill-index-component')
</x-app-layout>