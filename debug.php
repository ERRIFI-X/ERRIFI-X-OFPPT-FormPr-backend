<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $request = Illuminate\Http\Request::create('/api/formateurs', 'GET');
    $formateurs = \App\Models\User::whereHas('role', function ($query) {
        $query->where('name', 'Formateur');
    })->with(['role', 'themes.formation', 'themes.participants.user'])->get();

    $resource = \App\Http\Resources\UserResource::collection($formateurs);
    $data = $resource->toArray($request);
    
    echo "SUCCESS\n";
    // echo json_encode($data);
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
    echo $e->getTraceAsString();
}
