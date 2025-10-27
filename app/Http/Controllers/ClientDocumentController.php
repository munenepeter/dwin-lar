<?php

namespace App\Http\Controllers;

use App\Models\ClientDocument;
use App\Http\Requests\StoreClientDocumentRequest;
use App\Http\Requests\UpdateClientDocumentRequest;
use Illuminate\Support\Facades\Auth;

class ClientDocumentController extends Controller {
    public function index() {
        $clientDocuments = ClientDocument::with(['client', 'uploadedBy'])->paginate(15);
        return view('client-documents.index', compact('clientDocuments'));
    }

    public function create() {
        $clients = \App\Models\Client::all();
        return view('client-documents.create', compact('clients'));
    }

    public function store(StoreClientDocumentRequest $request) {
        $data = $request->validated();
        $data['uploaded_by'] = Auth::id();
        ClientDocument::create($data);
        return redirect()->route('client-documents.index')->with('success', 'Document uploaded.');
    }

    public function show(ClientDocument $clientDocument) {
        $clientDocument->load(['client', 'uploadedBy', 'verifiedBy']);
        return view('client-documents.show', compact('clientDocument'));
    }

    public function edit(ClientDocument $clientDocument) {
        $clients = \App\Models\Client::all();
        return view('client-documents.edit', compact('clientDocument', 'clients'));
    }

    public function update(UpdateClientDocumentRequest $request, ClientDocument $clientDocument) {
        $data = $request->validated();
        if ($request->is_verified) {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }
        $clientDocument->update($data);
        return redirect()->route('client-documents.index')->with('success', 'Document updated.');
    }

    public function destroy(ClientDocument $clientDocument) {
        $clientDocument->delete();
        return redirect()->route('client-documents.index')->with('success', 'Document deleted.');
    }
}
