<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ServiceStatus extends Component
{
    public $serviceStatus;

    public function mount()
    {
        $this->fetchServiceStatus();
    }

    public function fetchServiceStatus()
    {
        $response = Http::get('https://api.mtrec.name.my/api/servicestatus');
        $this->serviceStatus = $response->json();
    }

    public function render()
    {
        return view('livewire.service-status');
    }
}
