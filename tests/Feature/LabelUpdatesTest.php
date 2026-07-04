<?php

use Illuminate\Support\Facades\File;

test('book test and invoice views use main lab wording', function () {
    $posView = File::get(resource_path('views/livewire/lab/pos-manager.blade.php'));
    $editView = File::get(resource_path('views/livewire/lab/pos-edit-manager.blade.php'));
    $invoiceView = File::get(resource_path('views/livewire/lab/invoice-templates/classic.blade.php'));

    expect($posView)->toContain('Main Lab');
    expect($editView)->toContain('Main Lab');
    expect($invoiceView)->toContain('Main Lab');

    expect($posView)->not->toContain('Select Collection Center');
    expect($editView)->not->toContain('Select Collection Center');
    expect($invoiceView)->not->toContain('Collection Center:');
});
