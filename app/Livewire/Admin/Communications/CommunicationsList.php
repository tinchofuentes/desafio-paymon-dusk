<?php

namespace App\Livewire\Admin\Communications;

use App\Enums\CommunicationStatus;
use App\Models\Communication;
use App\Services\CommunicationService;
use Livewire\Component;
use Livewire\WithPagination;

class CommunicationsList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    
    protected $listeners = [
        'refreshList' => '$refresh'
    ];
    
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
            $this->dispatch('showMessage', [
                'type' => 'success',
                'message' => 'Comunicado eliminado correctamente.'
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el comunicado: ' . $e->getMessage());
            $this->dispatch('showMessage', [
                'type' => 'error',
                'message' => 'Error al eliminar el comunicado: ' . $e->getMessage()
            ]);
        }
    }
    
    public function send($id)
    {
        try {
            $communication = Communication::findOrFail($id);
            $communication->status = CommunicationStatus::SENT;
            $communication->save();
            
            // Enviar comunicado a través del servicio
            $communicationService = new CommunicationService();
            $result = $communicationService->sendCommunication($communication);
            
            $message = 'Comunicado enviado correctamente.';
            if ($result['total'] > 0) {
                $message .= " Se ha enviado a {$result['sent']} destinatarios.";
                if ($result['errors'] > 0) {
                    $message .= " Hubo {$result['errors']} errores al enviar.";
                }
            } else {
                $message .= " No se encontraron destinatarios que cumplan con los criterios.";
            }
            
            session()->flash('message', $message);
            $this->dispatch('showMessage', [
                'type' => 'success',
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar el comunicado: ' . $e->getMessage());
            $this->dispatch('showMessage', [
                'type' => 'error',
                'message' => 'Error al enviar el comunicado: ' . $e->getMessage()
            ]);
        }
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
    
    public function updatedDateFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $communications = Communication::query()
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFilter, function ($query) {
                return $query->whereDate('send_date', $this->dateFilter);
            })
            ->latest()
            ->paginate(10);
        
        return view('livewire.admin.communications.communications-list', [
            'communications' => $communications,
            'statusOptions' => CommunicationStatus::options(),
        ]);
    }
}
