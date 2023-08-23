<?php 


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\DocumentTransformer;


use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller {


  public function index(Request $request){
    $this->authorize('view', Document::class);

    $documents = Document::select('documents.*');

    $offset = request('offset', 0);
    $limit = $request->input('limit', 50);
    $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

    if ($request->filled('search')) {
        $documents->TextSearch($request->input('search'));
    }

    $total = $documents->count();
    $documents = $documents->skip($offset)->take($limit)->get();

    return (new DocumentTransformer)->transformDocuments($documents, $total);
  }
}