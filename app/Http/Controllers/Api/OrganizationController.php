<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return response()->json([
            'message' => 'Organizations retrieved successfully',
            'data' => $organizations
        ]);
    }

    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        return response()->json([
            'message' => 'Organization retrieved successfully',
            'data' => $organization
        ]);
    }

    public function store(Request $request)
    {
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

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);

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

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        
        return response()->json([
            'message' => 'Organization deleted successfully'
        ]);
    }
}
