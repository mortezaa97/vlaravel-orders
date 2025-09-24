<?php

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Orders\Models\PayType;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Http\Resources\PayTypeResource;
class PayTypeController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', PayType::class);
        return PayTypeResource::collection(PayType::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', PayType::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new PayTypeResource($payType);
    }

    public function show(PayType $payType)
    {
        Gate::authorize('view', $payType);
        return new PayTypeResource($payType);
    }

    public function update(Request $request, PayType $payType)
    {
        Gate::authorize('update', $payType);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new PayTypeResource($payType);
    }

    public function destroy(PayType $payType)
    {
        Gate::authorize('delete', $payType);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
