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
     * Display a listing of the organizations.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $organizations = Organization::paginate(10);
        return response()->json([
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
        $organization = Organization::findOrFail($id);
        return response()->json([
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
            'status' => 'in:active,inactive'
        ]);

        $organization = Organization::create($validated);

        return response()->json([
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
            'status' => 'in:active,inactive'
        ]);

        $organization->update($validated);

        return response()->json([
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
            'message' => 'Organization deleted successfully'
        ]);
    }
}
