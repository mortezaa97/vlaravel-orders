<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mortezaa97\Orders\Http\Resources\SendTypeResource;
use Mortezaa97\Orders\Models\SendType;

class SendTypeController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', SendType::class);

        return SendTypeResource::collection(SendType::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', SendType::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new SendTypeResource($sendType);
    }

    public function show(SendType $sendType)
    {
        Gate::authorize('view', $sendType);

        return new SendTypeResource($sendType);
    }

    public function update(Request $request, SendType $sendType)
    {
        Gate::authorize('update', $sendType);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new SendTypeResource($sendType);
    }

    public function destroy(SendType $sendType)
    {
        Gate::authorize('delete', $sendType);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return response()->json('با موفقیت حذف شد');
    }
}
