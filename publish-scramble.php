<?php

require 'bootstrap/app.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\Artisan::call('vendor:publish', [
    '--provider' => 'Dedoc\Scramble\ScrambleServiceProvider',
    '--force' => true,
]);

echo "✅ Scramble assets published!\n";
