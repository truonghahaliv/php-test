<div>
    <button wire:click="export" class="btn btn-outline-primary">Export</button>

    @if($exporting && !$exportFinished)
        <div class="d-inline" wire:poll="updateExportProgress">Exporting...please wait.</div>
    @endif

    @if($exportFinished)
        Done. Download file <button class="stretched-link" wire:click="downloadExport">here</button>
    @endif
</div>
