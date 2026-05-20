<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the organizations with eager loaded province and daerah.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $organizations = Organization::with(['province', 'daerah'])->paginate(10);
        
        return response()->json([
            'success' => true,
            'message' => 'Organizations retrieved successfully',
            'data' => $organizations
        ]);
    }

    /**
     * Display the specified organization.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $organization = Organization::with(['province', 'daerah'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Organization retrieved successfully',
            'data' => $organization
        ]);
    }

    /**
     * Store a newly created organization in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        Gate::authorize('create', Organization::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'website' => 'nullable|url',
            'instagram' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'in:active,inactive',
            'province_id' => 'nullable|exists:provinces,id',
            'daerah_id' => 'nullable|exists:daerahs,id'
        ]);

        $organization = Organization::create($validated);

        // Load relations for response
        $organization->load(['province', 'daerah']);

        return response()->json([
            'success' => true,
            'message' => 'Organization created successfully',
            'data' => $organization
        ], 201);
    }

    /**
     * Update the specified organization in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        
        Gate::authorize('update', $organization);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'region' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'website' => 'nullable|url',
            'instagram' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'in:active,inactive',
            'province_id' => 'nullable|exists:provinces,id',
            'daerah_id' => 'nullable|exists:daerahs,id'
        ]);

        $organization->update($validated);

        // Load relations for response
        $organization->load(['province', 'daerah']);

        return response()->json([
            'success' => true,
            'message' => 'Organization updated successfully',
            'data' => $organization
        ]);
    }

    /**
     * Remove the specified organization from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        
        Gate::authorize('delete', $organization);

        $organization->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Organization deleted successfully'
        ]);
    }
}
