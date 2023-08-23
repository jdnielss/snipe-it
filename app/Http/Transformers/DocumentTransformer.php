<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Document;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;


class DocumentTransformer {
  public function transformDocuments(Collection $documents, $total){
    $array = [];
    foreach ($documents as $document) {
        $array[] = self::transformDocument($document);
    }

    return (new DatatablesTransformer)->transformDatatables($array, $total);
  }

  public function transformDocument(Document $document) {
    $array = [
      'id' => (int) $document->id,
      'name' => e($document->name),
      'created_at' => e($document->created_at),
      'updated_at' => e($document->updated_at),
    ];
    
    return $array;
  }

  public function transformDocumentsDatatable($document) {
    return (new DatatablesTransformer)->transformDatatables($document, $total);
  }
}