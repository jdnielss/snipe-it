<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AssetModel;
use App\Models\Asset;
use App\Models\Company;
use App\Http\Transformers\AssetsTransformer;
use Illuminate\Http\Request;
use App\Models\Actionlog;
use App\Models\User;
use App\Models\Setting;
use App\Notifications\RequestAssetCancelation;
use App\Notifications\RequestAssetNotification;
use Illuminate\Support\Facades\Auth;

class RequestableController extends Controller {

  public function index(Request $request) {
    $this->authorize('viewRequestable', Asset::class);

    $assets = Asset::select('assets.*')
        ->with('location', 'assetstatus', 'assetlog', 'company', 'defaultLoc','assignedTo',
            'model.category', 'model.manufacturer', 'model.fieldset', 'supplier')
        ->requestableAssets();

    $offset = request('offset', 0);
    $limit = $request->input('limit', 50);
    $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
    if ($request->filled('search')) {
        $assets->TextSearch($request->input('search'));
    }

    switch ($request->input('sort')) {
        case 'model':
            $assets->OrderModels($order);
            break;
        case 'model_number':
            $assets->OrderModelNumber($order);
            break;
        case 'category':
            $assets->OrderCategory($order);
            break;
        case 'manufacturer':
            $assets->OrderManufacturer($order);
            break;
        default:
            $assets->orderBy('assets.created_at', $order);
            break;
    }

    $total = $assets->count();
    $assets = $assets->skip($offset)->take($limit)->get();

    return (new AssetsTransformer)->transformRequestedAssets($assets, $total);
  }

  public function getRequestItem(Request $request) {
    $user = Auth::user();
    $assetId = $request->input('itemId');

    // Check if the asset exists and is requestable
    if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
        return ['status' => ['code' => 402,'message' => trans('admin/hardware/message.does_not_exist_or_not_requestable')], 'data' => null];
    }
    if (! Company::isCurrentUserHasAccess($asset)) {
        return ['status' => ['code' => 402,'message' => trans('general.insufficient_permissions')], 'data' => null];
    }

    $data['item'] = $asset;
    $data['target'] = Auth::user();
    $data['item_quantity'] = 1;
    $settings = Setting::getSettings();

    $logaction = new Actionlog();
    $logaction->item_id = $data['asset_id'] = $asset->id;
    $logaction->item_type = $data['item_type'] = Asset::class;
    $logaction->created_at = $data['requested_date'] = date('Y-m-d H:i:s');

    if ($user->location_id) {
        $logaction->location_id = $user->location_id;
    }

    $logaction->target_id = $data['user_id'] = Auth::user()->id;
    $logaction->target_type = User::class;

    // If it's already requested, cancel the request.
    if ($asset->isRequestedBy(Auth::user())) {
        $asset->cancelRequest();
        $asset->decrement('requests_counter', 1);

        $logaction->logaction('request canceled');
        // $settings->notify(new RequestAssetCancelation($data));

        return ['status' => ['code' => 200,'message' => trans('admin/hardware/message.requests.canceled')], 'data' => null];
    }

    $logaction->logaction('requested');
    $asset->request();
    $asset->increment('requests_counter', 1);
    // $settings->notify(new RequestAssetNotification($data));

    return ['status' => ['code' => 200,'message' => trans('admin/hardware/message.requests.success')], 'data' => $asset];
  }
}