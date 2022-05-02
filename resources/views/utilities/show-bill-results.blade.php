<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 mt-5">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" >
                <table class="table-auto">

                    <thead class="bg-gray-50">
                        <tr>
                            <x-th></x-th>
                            <x-th>Bill #</x-th>
                            <x-th>Ref #</x-th>
                            <x-th>Posted on</x-th>
                            <x-th>Period Covered</x-th>
                            {{-- <x-th>Payee</x-th> --}}

                            <x-th>Particular</x-th>
                            <x-th>Amount</x-th>
                            {{-- <x-th>Status</x-th> --}}
                            
                           
                        </tr>
                    </thead>
                    @forelse ($bills as $item)
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <x-td>
                                <div class="flex items-center">
                                    <x-input type="checkbox" wire:model="selectedBills" value="{{ $item->uuid }}" />
                                </div>
                            </x-td>
                            <x-td>{{ $item->bill_no}}</x-td>
                            <x-td>{{ $item->reference_no}}</x-td>
                            <x-td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</x-td>
                            {{-- <x-td>{{ $item->unit }}</x-td> --}}
                            <x-td>{{ Carbon\Carbon::parse($item->start)->format('M d, Y').'-'.Carbon\Carbon::parse($item->end)->format('M d, Y') }}</x-td>
                            <x-td>{{ $item->particular->particular}}</x-td>
                            <x-td>{{ number_format($item->bill, 2) }}</x-td>
                            {{-- <x-td>@if($item->status === 'paid')
                                <span
                                    class="px-2 text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fa-solid fa-circle-check"></i> {{
                                    $item->status }}
                                    @else
                                    <span
                                        class="px-2 text-sm leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                        <i class="fa-solid fa-clock"></i> {{
                                        $item->status }}
                                    </span>
                                    @endif
                            </x-td> --}}
                            @empty
                            <x-td>No data found!</x-td>
                            @endforelse
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>