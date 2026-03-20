<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('uploader');
        
        if ($request->has('formation_id')) {
            $query->where('formation_id', $request->formation_id);
        }

        return DocumentResource::collection($query->latest()->paginate(20));
    }

    public function store(StoreDocumentRequest $request)
    {
        $path = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'formation_id' => $request->formation_id,
            'title'        => $request->title,
            'file'         => $path,
            'uploaded_by'  => auth()->id(),
        ]);

        return new DocumentResource($document->load('uploader'));
    }

    public function destroy(Document $document)
    {
        if (!auth()->user()->isAdmin() && $document->uploaded_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($document->file);
        $document->delete();

        return response()->noContent();
    }
}
