<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
public function index()
{
$documents = Auth::user()->documents()->get();
return response()->json($documents);
}

public function store(Request $request)
{
$validatedData = $request->validate([
'title' => 'required|string|max:255',
'contents' => 'required|string',
]);

$document = Auth::user()->documents()->create($validatedData);
return response()->json($document, 201);
}

public function show($id)
{
$document = Auth::user()->documents()->findOrFail($id);
return response()->json($document);
}

public function update(Request $request, $id)
{
$document = Auth::user()->documents()->findOrFail($id);

$validatedData = $request->validate([
'title' => 'required|string|max:255',
'contents' => 'required|string',
]);

$document->update($validatedData);
return response()->json($document);
}

public function destroy($id)
{
$document = Auth::user()->documents()->findOrFail($id);
$document->delete();
return response()->json(null, 204);
}
}
