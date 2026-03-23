<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $request = Illuminate\Http\Request::create('/api/formateurs', 'GET');
    $user = \App\Models\User::whereHas('role', function ($query) {
        $query->where('name', 'Formateur');
    })->with(['role', 'themes.formation'])->first();

    $resource = new \App\Http\Resources\UserResource($user);
    $data = $resource->toArray($request);
    
    echo "USER_DATA:\n";
    echo json_encode($data, JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
