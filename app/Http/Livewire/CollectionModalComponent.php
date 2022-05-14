<?php

namespace App\Http\Livewire;
use Session;
use App\Models\Collection;
use App\Models\Bill;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class CollectionModalComponent extends ModalComponent
{

    use WithFileUploads;
    
    public $selectedBills;
    public $tenant;
    public $bank;
    public $check_no;
    public $total;
    public $attachment;

    public $collection;
    public $form;

    public function mount($selectedBills, $total)
    {
        $this->selectedBills = $selectedBills;
        $this->form = 'cash';
        $this->total = $total;
        $this->collection = $total;
    }

    // public function hydrateTotal()
    // {
    //     $this->total = $this->total-$this->collection;
    // }

    //   public function updatedTotal($total)
    //   {
    //   $this->total = $total-$this->collection;
    //   }

    protected function rules()
    {
        return [
            'collection' => 'required|integer|min:1',
            'bank' => 'nullable',
            'check_no' => 'nullable',
            'attachment' => 'nullable'
      ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function submitForm()
    {
       try{
            sleep(1);

            if($this->collection<Bill::whereIn('id', $this->selectedBills)->sum('bill'))
            {
                $this->dispatchBrowserEvent('collection-modal-component');

                return back()->with('error','The collection is less than the bill.');

            }

            $validatedData = $this->validate();

            $ar_no = Property::find(Session::get('property'))->collections->max('ar_no')+1;

            for($i=0; $i<count($this->selectedBills); $i++)
            {
                $validatedData['tenant_uuid']= $this->tenant;
                $validatedData['unit_uuid']= Bill::find($this->selectedBills[$i])->unit_uuid;
                $validatedData['property_uuid'] = Session::get('property');
                $validatedData['user_id'] = auth()->user()->id;
                $validatedData['ar_no'] = $ar_no++;
                $validatedData['bill_id'] = $this->selectedBills[$i];
                $validatedData['bill_reference_no']= Tenant::find($this->tenant)->bill_reference_no;
                $validatedData['form'] = $this->form;
                $validatedData['collection'] = Bill::find($this->selectedBills[$i])->bill;

                if($this->attachment)
                {
                    $validatedData['attachment'] = $this->attachment->store('attachments');
                }

                Collection::create($validatedData);

                Bill::where('id', $this->selectedBills[$i])
                ->update([
                    'status' => 'paid'
                ]);

               
            }
            
            $this->resetForm();
        
            return back()->with('success','Collections have been recorded.');
       }catch(\Exception $e)
       {
            ddd($e);
            return back()->with('error','Cannot perform your action.');
       }
    }

    public function resetForm()
    {
        $this->collection='';
        $this->dispatchBrowserEvent('collection-modal-component');
    }
    public function render()
    {
        return view('livewire.collection-modal-component');
    }
}