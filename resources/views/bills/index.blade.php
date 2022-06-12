<x-index-layout>
    @section('title', '| Bills')
    <x-slot name="labels">
        Bills
    </x-slot>
    <x-slot name="options">
        <x-button data-modal-toggle="create-particular-modal">
            Create a Particular
        </x-button>
        @can('billing')
        <x-button id="dropdownButton" data-dropdown-toggle="unitCreateDropdown" type="button">Create <svg
                class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                </path>
            </svg></x-button>
        @endcan
        <!-- Dropdown menu -->
        <div id="unitCreateDropdown"
            class="text-left hidden z-10 w-30 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
            <ul class="py-1" aria-labelledby="dropdownButton">

                <li>
                    <a href="#/" data-modal-toggle="create-express-bill-modal"
                        class=" block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        <i class="fa-solid fa-truck-fast"></i>&nbsp Express Bill
                    </a>
                </li>
                <li>
                    <a href="#/" data-modal-toggle="create-customized-bill-modal"
                        class=" block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        <i class="fa-solid fa-file-pen"></i>&nbsp Customized Bill
                    </a>
                </li>



            </ul>
        </div>
    </x-slot>
    @livewire('bill-index-component', ['active_contracts' => $active_contracts, 'active_tenants' => $active_tenants])
    @include('utilities.create-particular-modal')
    @include('utilities.create-express-bill')
    @include('utilities.create-customized-bill')
</x-index-layout>