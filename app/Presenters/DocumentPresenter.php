<?php

namespace App\Presenters;

use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class DocumentPresenter
 */
class DocumentPresenter extends Presenter {

  public static function dataTableLayout()
  {
      $layout = [
          [
            'field' => 'id',
            'title' => 'ID',
            'visible' => true,
          ],
          [
              'field' => 'name',
              'searchable' => true,
              'sortable' => true,
              'title' => 'Name',
              'visible' => true,
          ],
      ];

      return json_encode($layout);
  }
}