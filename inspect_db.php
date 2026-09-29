<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['users', 'teachers', 'students', 'parents', 'student_parent', 'attendance', 'announcements', 'sms_logs', 'reports'];
foreach ($tables as $t) {
    echo "=== Table: {$t} ===" . PHP_EOL;
    $cols = Illuminate\Support\Facades\DB::select("DESCRIBE {$t}");
    foreach ($cols as $col) {
        $null = $col->Null === 'YES' ? 'nullable' : 'not null';
        echo "  - {$col->Field} ({$col->Type}, {$null}, default: {$col->Default})" . PHP_EOL;
    }
}
