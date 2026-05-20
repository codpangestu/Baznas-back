<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProvinceController extends Controller
{
    /**
     * Display a listing of all provinces with total organization counts.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $provinces = Province::withCount('organizations')->get();

        return response()->json([
            'success' => true,
            'message' => 'Provinces retrieved successfully',
            'data' => $provinces
        ]);
    }

    /**
     * Display the specified province detail by slug.
     * Includes eager loaded daerahs (districts) and organizations in the province.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $province = Province::with(['daerahs', 'organizations'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'message' => 'Province retrieved successfully',
            'data' => $province
        ]);
    }

    /**
     * Store a newly created province in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name',
            'image' => 'nullable|string'
        ]);

        $province = Province::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Province created successfully',
            'data' => $province
        ], 201);
    }

    /**
     * Update the specified province in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $province = Province::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:provinces,name,' . $id,
            'image' => 'nullable|string'
        ]);

        $province->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Province updated successfully',
            'data' => $province
        ]);
    }

    /**
     * Remove the specified province from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $province = Province::findOrFail($id);
        $province->delete();

        return response()->json([
            'success' => true,
            'message' => 'Province deleted successfully'
        ]);
    }
}
