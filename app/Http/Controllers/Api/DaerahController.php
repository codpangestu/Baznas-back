<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DaerahController extends Controller
{
    /**
     * Display a listing of all daerahs with their province.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $daerahs = Daerah::with('province')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daerahs retrieved successfully',
            'data' => $daerahs
        ]);
    }

    /**
     * Display the specified daerah detail by slug.
     * Includes eager loaded province and organizations in the daerah.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $daerah = Daerah::with(['province', 'organizations'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'message' => 'Daerah retrieved successfully',
            'data' => $daerah
        ]);
    }

    /**
     * Store a newly created daerah in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'name' => 'required|string|max:255|unique:daerahs,name',
            'image' => 'nullable|string',
            'website' => 'nullable|url',
            'instagram' => 'nullable|string',
            'email' => 'nullable|email'
        ]);

        $daerah = Daerah::create($validated);
        $daerah->load('province');

        return response()->json([
            'success' => true,
            'message' => 'Daerah created successfully',
            'data' => $daerah
        ], 201);
    }

    /**
     * Update the specified daerah in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $daerah = Daerah::findOrFail($id);

        $validated = $request->validate([
            'province_id' => 'sometimes|required|exists:provinces,id',
            'name' => 'sometimes|required|string|max:255|unique:daerahs,name,' . $id,
            'image' => 'nullable|string',
            'website' => 'nullable|url',
            'instagram' => 'nullable|string',
            'email' => 'nullable|email'
        ]);

        $daerah->update($validated);
        $daerah->load('province');

        return response()->json([
            'success' => true,
            'message' => 'Daerah updated successfully',
            'data' => $daerah
        ]);
    }

    /**
     * Remove the specified daerah from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $daerah = Daerah::findOrFail($id);
        $daerah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Daerah deleted successfully'
        ]);
    }
}
