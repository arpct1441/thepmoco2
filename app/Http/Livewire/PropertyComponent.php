<?php

namespace App\Http\Livewire;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use DB;
use App\Models\Property;
use App\Models\UserProperty;
use App\Models\PropertyParticular;
use App\Models\PropertyRole;


use Livewire\Component;

class PropertyComponent extends Component
{
     use WithFileUploads;
     
     public $types;

     public function mount($types)
     {
        $this->types = $types;
     }

     public $property;
     public $type_id;
     public $thumbnail;
     public $description;

     protected function rules()
     {
        return [
            'property' => 'required',
            'type_id' => ['required', Rule::exists('types', 'id')],
            'thumbnail' => 'required|image',
            'description' => '',
        ];
     }

     public function updated($propertyName)
     {
        $this->validateOnly($propertyName);
     }

     public function createForm()
     {
        sleep(1);

        $validatedData = $this->validate();

        try {

        $property_uuid = Str::uuid();

        $validatedData['uuid']= $property_uuid;
        $validatedData['thumbnail'] = $this->thumbnail->store('thumbnails');

        DB::beginTransaction();

        Property::create($validatedData);

        UserProperty::create([
        'property_uuid' => $property_uuid,
        'user_id' => auth()->user()->id,
        'isAccountOwner' => true
        ]);

        for($i=1; $i<=5; $i++){ 
            PropertyParticular::create([ 'property_uuid'=> $property_uuid,
            'particular_id'=> $i,
            'minimum_charge' => 0.00,
            'due_date' => 28,
            'surcharge' => 1
            ]);
        }

        for($i=1; $i<=4; $i++){ 
            PropertyRole::create([ 'property_uuid'=> $property_uuid,
            'role_id'=> $i,
            ]);
        }

        DB::commit();

         return redirect('/properties')->with('success', 'Property has been created.');
        }catch (\Throwable $e) {
            DB::rollback();
            return redirect('/properties')->with('error', 'Cannot perform your action.');
        }

       
     }

     public function resetForm()
     {
        $this->property='';
        $this->type_id='';
        $this->thumbnail='';
        $this->description='';
     }

     public function render()
     {
        return view('livewire.property-component');
     }
}
