<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\Searchable;


class Document extends Model {

  use Searchable;
  use HasFactory;

  protected $table = 'documents';

  protected $fillable = ['name', 'update_at', 'created_at'];

  protected $searchableAttributes = [
    'name',
  ];

  // public function create()
  // {
  //     return view('document.create');
  // }

  public function store(Request $request)
  {
      
      Document::create($request->post());

      return redirect()->route('document.index')->with('success','Company has been created successfully.');
  }
}
