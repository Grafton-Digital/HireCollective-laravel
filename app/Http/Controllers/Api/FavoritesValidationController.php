<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritesValidationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['valid_ids' => []]);
        }

        $validIds = Product::where('is_active', true)
            ->whereIn('id', $ids)
            ->pluck('id');

        return response()->json(['valid_ids' => $validIds]);
    }
}
