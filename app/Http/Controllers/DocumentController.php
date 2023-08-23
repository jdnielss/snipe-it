<?php

namespace App\Http\Controllers;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller {
  
  public function index() {

    $this->authorize('view', Document::class);
    
    return view('document/index');
  }


  public function create() {

    $this->authorize('view', Document::class);
    
    return view('document/create');
  }

  public function store(Request $request) {
    // $this->authorize('create', Document::class);
    // dd($request->name);
    $this->validate($request, [
      'name' => 'required',
    ]);

    $document = Document::create([
      'name' => $request->name,
    ]);


    if ($document) {
      return redirect()->route('document')->with('success', 'Document created successfully');
    } else {
      return redirect()->route('document')->with('error', 'Document could not be created');
    }
  }
}