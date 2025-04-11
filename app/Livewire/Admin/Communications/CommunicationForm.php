<?php

namespace App\Livewire\Admin\Communications;

use App\Enums\CommunicationStatus;
use App\Models\Communication;
use App\Models\Course;
use App\Models\Student;
use App\Services\CommunicationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CommunicationForm extends Component
{
    public $title = '';
    public $message = '';
    public $course_id = null;
    public $age_from = null;
    public $age_to = null;
    public $send_date = '';
    public $status = '';
    
    public $isOpen = false;
    public $editMode = false;
    public $viewMode = false;
    public $communication = null;
    public $communication_id = null;
    
    protected $listeners = [
        'open' => 'openModal',
        'close' => 'closeModal',
        'create' => 'create',
        'edit' => 'edit',
        'view' => 'view'
    ];
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'course_id' => 'nullable|exists:courses,id',
        'age_from' => 'nullable|integer|min:1|max:99',
        'age_to' => 'nullable|integer|min:1|max:99',
        'send_date' => 'nullable|date',
        'status' => 'required|string',
    ];
    
    public function mount()
    {
        $this->send_date = now()->format('Y-m-d');
        $this->status = CommunicationStatus::DRAFT->value;
    }
    
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
        $this->editMode = true;
        $this->viewMode = false;
    }
    
    public function edit($id)
    {
        $this->communication = Communication::findOrFail($id);
        $this->communication_id = $id;
        $this->title = $this->communication->title;
        $this->message = $this->communication->message;
        $this->course_id = $this->communication->course_id;
        $this->age_from = $this->communication->age_from;
        $this->age_to = $this->communication->age_to;
        $this->send_date = $this->communication->send_date ? $this->communication->send_date->format('Y-m-d') : null;
        $this->status = $this->communication->status->value;
        $this->openModal();
        $this->editMode = true;
        $this->viewMode = false;
    }
    
    public function view($id)
    {
        $this->communication = Communication::with('guardians')->findOrFail($id);
        $this->communication_id = $id;
        $this->title = $this->communication->title;
        $this->message = $this->communication->message;
        $this->course_id = $this->communication->course_id;
        $this->age_from = $this->communication->age_from;
        $this->age_to = $this->communication->age_to;
        $this->send_date = $this->communication->send_date ? $this->communication->send_date->format('Y-m-d') : null;
        $this->status = $this->communication->status->value;
        $this->openModal();
        $this->editMode = false;
        $this->viewMode = true;
    }
    
    public function openModal()
    {
        $this->isOpen = true;
    }
    
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
        $this->dispatch('refreshParent');
        $this->dispatch('refreshList');
    }
    
    public function resetInputFields()
    {
        $this->reset(['title', 'message', 'course_id', 'age_from', 'age_to', 'communication_id']);
        $this->send_date = now()->format('Y-m-d');
        $this->status = CommunicationStatus::DRAFT->value;
        $this->resetValidation();
    }
    
    public function store()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            $data = [
                'title' => $this->title,
                'message' => $this->message,
                'course_id' => $this->course_id ?: null,
                'age_from' => $this->age_from !== '' ? $this->age_from : null,
                'age_to' => $this->age_to !== '' ? $this->age_to : null,
                'send_date' => $this->send_date,
                'status' => $this->status,
            ];
            
            if ($this->communication_id) {
                $communication = Communication::find($this->communication_id);
                $communication->update($data);
                $message = 'Comunicado actualizado correctamente.';
            } else {
                $communication = Communication::create($data);
                $message = 'Comunicado creado correctamente.';
            }
            
            if ($this->status === CommunicationStatus::SENT->value) {
                $communicationService = new CommunicationService();
                $result = $communicationService->sendCommunication($communication);
                
                if ($result['total'] > 0) {
                    $message .= " Se ha enviado a {$result['sent']} destinatarios.";
                    if ($result['errors'] > 0) {
                        $message .= " Hubo {$result['errors']} errores al enviar.";
                    }
                } else {
                    $message .= " No se encontraron destinatarios que cumplan con los criterios.";
                }
            }
            
            DB::commit();
            session()->flash('message', $message);
            $this->dispatch('showMessage', [
                'type' => 'success',
                'message' => $message
            ]);
            $this->closeModal();
            
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Error: ' . $e->getMessage());
            $this->dispatch('showMessage', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.admin.communications.communication-form', [
            'courses' => Course::where('active', true)->get(),
            'statusOptions' => CommunicationStatus::options(),
        ]);
    }
}
