   <form action="/property/{{ $property->uuid }}/update" method="POST" id="edit-form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="mx-5">
                                <x-label for="property" :value="__('Property')" />

                                <x-form-input form="edit-form" type="text" name="property"
                                    value="{{old('property', $property->property)}}" required autofocus />

                                @error('property')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div class="mt-5 mx-5">
                                <x-label for="type" :value="__('Description')" />

                                <x-form-textarea name="description" id="description" cols="30" rows="10">{{
                                    old('description', $property->description) }}</x-form-textarea>

                                @error('description')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="mt-5 mx-5">
                                <x-label for="type_id" :value="__('Type')" />

                                <x-form-select form="edit-form" name="type_id" id="type_id">
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ $type->id == $property->type_id ? 'selected' : ''
                                        }}>{{ $type->type }}</option>
                                    @endforeach
                                </x-form-select>

                                @error('type_id')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5">
                                <x-label for="type_id" :value="__('Type')" />

                                <x-form-select wire:model="type_id" name="type_id" id="type_id">
                                    <option value="">Select one</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id')==$type->id?
                                        'selected': 'Select one'
                                        }}>{{ $type->type }}</option>
                                    @endforeach
                                </x-form-select>

                                @error('type_id')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5">
                                <div class="mt-6 flex flex-wrap mb-2">
                                    <div class="w-full md:w-1/4 mb-6 md:mb-0">
                                        <x-label for="country_id">
                                            Country
                                        </x-label>
                                        <div class="relative">
                                            <x-form-select wire:model="country_id" id="country_id" name="country_id">
                                                <option value="">Select one</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id')==$country->id?
                                                    'selected': 'Select one'
                                                    }}>{{ $country->country }}</option>
                                                @endforeach
                                            </x-form-select>

                                            @error('country_id')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                        <x-label for="province_id">
                                            Region
                                        </x-label>
                                        <div class="relative">
                                            <x-form-select wire:model="province_id" id="province_id" id="province_id"
                                                name="province_id">
                                                <option value="">Select one</option>
                                                @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" {{ old('province_id')==$province->
                                                    id?
                                                    'selected': 'Select one'
                                                    }}>{{ $province->province }}</option>
                                                @endforeach
                                            </x-form-select>
                                            @error('province_id')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                        <x-label for="city_id">
                                            City
                                        </x-label>
                                        <x-form-select wire:model="city_id" id="city_id" id="city_id" name="city_id">
                                            <option value="">Select one</option>
                                            @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id')==$city->id?
                                                'selected': 'Select one'
                                                }}>{{ $city->city }}</option>
                                            @endforeach
                                        </x-form-select>

                                        @error('city_id')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                        <x-label for="barangay">
                                            Address
                                            </x-lab>
                                            <x-form-input wire:model="barangay" id="barangay" type="text"
                                                name="barangay" value="{{ old('barangay') }}" />

                                            @error('barangay')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="mt-5 mx-5">
                                <x-label for="status" :value="__('Status')" />

                                <x-form-select form="edit-form" name="status" id="status">
                                    <option value="active" {{ $property->status == 'active' ?
                                        'selected' : ''
                                        }}>active</option>
                                    <option value="inactive" {{ $property->status == 'inactive' ?
                                        'selected' : ''
                                        }}>inactive</option>
                                    <option value="pending" {{ $property->status == 'pending' ?
                                        'selected' : ''
                                        }}>pending</option>

                                </x-form-select>

                                @error('type_id')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5 flex mx-5">
                                <div class="flex-3">
                                    <x-label for="thumbnail" :value="__('Thumbnail')" />

                                    <x-form-input form="edit-form" id="thumbnail" type="file" name="thumbnail"
                                        value="{{old('thumbnail', $property->thumbnail)}}" autofocus />

                                    @error('thumbnail')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-6">
                                    <img class="h-10 w-10 rounded-xl ml-6" src="/storage/{{ $property->thumbnail }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="mt-5 flex mx-5">
                                <div class="flex-3">
                                    <x-label for="tenant_contract"
                                        :value="__('Tenant Contract (Please only upload a PDF file.)')" />

                                    <x-form-input form="edit-form" id="tenant_contract" type="file"
                                        name="tenant_contract"
                                        value="{{old('tenant_contract', $property->tenant_contract)}}" autofocus />

                                    @error('tenant_contract')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-5 mx-5">
                                    @if($property->tenant_contract)
                                    <a target="_blank" class="text-blue"
                                        href="/property/{{ Session::get('property') }}/tenant_contract">Click here to
                                        view the contract</a>
                                    @else
                                    <span>No contract is uploaded.</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-5 flex mx-5">
                                <div class="flex-3">
                                    <x-label for="owner_contract"
                                        :value="__('Owner Contract (Please only upload a PDF file.)')" />

                                    <x-form-input form="edit-form" id="owner_contract" type="file" name="owner_contract"
                                        value="{{old('owner_contract', $property->owner_contract)}}" autofocus />

                                    @error('owner_contract')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-6">
                                    @if($property->owner_contract)
                                    <a target="_blank" class="text-blue"
                                        href="/property/{{ Session::get('property') }}/owner_contract">Click here to
                                        view the contract</a>
                                    @else
                                    <span>No contract is uploaded.</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-5">
                                <p class="text-right">
                                    <x-button><i class="fa-solid fa-circle-check"></i>&nbspSave</x-button>
                                </p>
                            </div>
