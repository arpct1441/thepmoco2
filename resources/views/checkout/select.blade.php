<x-index-layout>
    @section('title', 'Select a Plan | The PMO Co')
    <x-slot name="labels">
        Select a plan
    </x-slot>

    <x-slot name="options">

    </x-slot>

    <!-- component -->
    <!-- component -->
    <div class="flex flex-wrap justify-center gap-12 container mx-auto bg-gray-50">

        <!-- Style 1 -->
        <div class="w-[360px] h-[480px] py-8 px-1">
            <div
                class="relative flex flex-col justify-center items-center w-[300px] h-[400px] mx-auto p-2 bg-slate-50 border-slate-900 text-slate-50 shadow-lg rounded-3xl hover:shadow-xl">

                <h3
                    class="absolute -top-5 -left-5 w-32 p-2 bg-slate-800 rounded-3xl text-2xl font-merriweather text-center">
                    Regular
                </h3>

                <div
                    class="p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Free Trial for 30 days</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">You will only be charged after 30 days.
                    </p>
                    <x-button onclick="window.location.href='/plan/1/checkout/2/get'">Try Now</x-button>
                </div>

            </div>
        </div>

        <!-- Style 2 -->
        <div class="w-[360px] h-[480px] py-8 px-1">
            <div
                class="relative flex flex-col justify-center items-center w-[300px] h-[400px] mx-auto p-2 bg-slate-50 border-slate-900 border-2 rounded-3xl">

                <h3
                    class="absolute -top-5 -left-5 w-32 p-2 bg-inherit border-slate-900 text-slate-900 border-2 rounded-3xl text-2xl font-merriweather text-center">
                    Promo
                </h3>

                <div
                    class="p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Access all features</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Pay only 950 per month for 6 months.
                    </p>
                   <x-button onclick="window.location.href='/plan/3/checkout/1/get'">Try Now</x-button>
                </div>

            </div>
        </div>
    </div>
</x-index-layout>