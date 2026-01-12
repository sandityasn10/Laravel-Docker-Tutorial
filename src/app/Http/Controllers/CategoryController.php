<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * index dengan redis caching
     */
    public function index(Request $request)
    {
        $start = microtime(true);

        $perPage = (int) $request->get('limit', 10);
        $page = (int) $request->get('page', 1);

        $cacheKey = "categories:page:{$page}:limit:{$perPage}";

        $result = Cache::tags(['categories'])->remember(
            $cacheKey,
            now()->addMinutes(30),
            function () use ($perPage, $page) {
                $query = Category::where('is_active', true)
                    ->orderBy('created_at', 'desc');

                return [
                    'total' => $query->count(), // hanya sekali
                    'data' => $query
                        ->forPage($page, $perPage)
                        ->get(),
                ];
            }
        );

        return response()->json([
            'execution_time_seconds' => microtime(true) - $start,
            'data' => $result['data'],
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $result['total'],
                'last_page' => ceil($result['total'] / $perPage),
            ],
        ]);
    }

    /**
     * index tanpa caching
     */
    // public function index()
    // {
    //     $start = microtime(true);

    //     $categories = Category::where('is_active', true)
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $executionTime = microtime(true) - $start;

    //     return response()->json([
    //         'execution_time_seconds' => $executionTime,
    //         'total_data' => $categories->count(),
    //         'data' => $categories,
    //     ]);
    // }

    public function store(Request $request)
    {
        Category::create($request->all());

        Cache::tags(['categories'])->flush();

        return response()->json(['message' => 'Created']);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        Cache::tags(['categories'])->flush();

        return response()->json(['message' => 'Updated']);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        Cache::tags(['categories'])->flush();

        return response()->json(['message' => 'Deleted']);
    }



}
