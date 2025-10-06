<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mortezaa97\Orders\Http\Resources\ModelHasProductResource;
use Mortezaa97\Orders\Models\ModelHasProduct;

class ModelHasProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', ModelHasProduct::class);

        return ModelHasProductResource::collection(ModelHasProduct::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', ModelHasProduct::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new ModelHasProductResource($modelHasProduct);
    }

    public function show(ModelHasProduct $modelHasProduct)
    {
        Gate::authorize('view', $modelHasProduct);

        return new ModelHasProductResource($modelHasProduct);
    }

    public function update(Request $request, ModelHasProduct $modelHasProduct)
    {
        Gate::authorize('update', $modelHasProduct);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new ModelHasProductResource($modelHasProduct);
    }

    public function destroy(ModelHasProduct $modelHasProduct)
    {
        Gate::authorize('delete', $modelHasProduct);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return response()->json('با موفقیت حذف شد');
    }
}
