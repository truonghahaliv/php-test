<?php

namespace App\Livewire;

use App\Jobs\ExportProductJob;
use App\Jobs\ExportUserJob;
use App\Models\Product;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class ExportUser extends Component
{
    public $batchId;
    public $exporting = false;
    public $exportFinished = false;

    public function export()
    {
        $this->exporting = true;
        $this->exportFinished = false;

        $batch = Bus::batch([
            new ExportProductJob(),
        ])->dispatch();

        $this->batchId = $batch->id;
    }

    public function getExportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }

    public function downloadExport()
    {
        return Storage::download('public/products.csv');
    }

    public function updateExportProgress()
    {
        $this->exportFinished = $this->exportBatch->finished();

        if ($this->exportFinished) {
            $this->exporting = false;
        }
    }


    public function render():View
    {
        return view('livewire.export-user');
    }
}
