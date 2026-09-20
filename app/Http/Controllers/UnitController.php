<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $units = Unit::withCount([
            'tasks as pending_count' => function ($query) {
                $query->where('status', 'pending');
            },
            'tasks as in_progress_count' => function ($query) {
                $query->where('status', 'in_progress');
            },
            'tasks as completed_count' => function ($query) {
                $query->where('status', 'completed');
            }
        ])->get();
        return response()->json($units);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|in:bureau_central,national,regional,territorial',
            'parent_id' => 'nullable|exists:units,id',
        ]);

        $unit = Unit::create($validatedData);

        return response()->json($unit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::with(['parent', 'children', 'users', 'tasks'])->findOrFail($id);
        return response()->json($unit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'level' => 'sometimes|required|string|in:bureau_central,national,regional,territorial',
            'parent_id' => 'nullable|exists:units,id',
        ]);

        $unit->update($validatedData);

        return response()->json($unit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json(['message' => 'Unit deleted successfully']);
    }
}
