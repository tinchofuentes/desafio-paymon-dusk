<?php

namespace App\Livewire\Admin\Communications;

use App\Enums\CommunicationStatus;
use App\Models\Communication;
use App\Models\Course;
use App\Models\Guardian;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ManageCommunicationsComponent extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    
    public $successMessage;
    public $errorMessage;
    
    protected $listeners = [
        'refreshParent' => '$refresh',
        'showMessage' => 'handleMessage'
    ];
    
    public function handleMessage($data)
    {
        if ($data['type'] === 'success') {
            $this->successMessage = $data['message'];
            $this->errorMessage = null;
        } else {
            $this->errorMessage = $data['message'];
            $this->successMessage = null;
        }
    }
    
    public function create()
    {
        $this->dispatch('create');
    }
    
    public function edit($id)
    {
        $this->dispatch('edit', $id);
    }
    
    public function view($id)
    {
        $this->dispatch('view', $id);
    }
    
    public function delete($id)
    {
        try {
            $communication = Communication::findOrFail($id);
            $communication->delete();
            session()->flash('message', 'Comunicado eliminado correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el comunicado: ' . $e->getMessage());
        }
    }
    
    public function send($id)
    {
        try {
            $communication = Communication::findOrFail($id);
            $communication->status = CommunicationStatus::SENT;
            $communication->save();
            
            $this->dispatch('refreshParent');
            session()->flash('message', 'Comunicado enviado correctamente.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar el comunicado: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.admin.communications.manage-communications-component');
    }
}
