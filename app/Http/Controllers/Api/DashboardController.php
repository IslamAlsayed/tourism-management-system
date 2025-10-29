<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getReferencesForTest(Request $request)
    {
        $request['model'] = 'city';
        $request['foreignKey'] = 'state_id';
        $request['foreignKeyValue'] = [1];

        $validated = $request->validate([
            'model' => 'required|string',
            'foreignKey' => 'required|string',
            'foreignKeyValue' => 'required'
        ]);

        $modelName = ucwords($validated['model']);
        $modelClass = "App\\Models\\$modelName";

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model specified.'], 400);
        }

        $query = $modelClass::query()->select('id', 'name')->orderBy('name');

        // Handle both array and string/single value
        $foreignKeyValue = $validated['foreignKeyValue'];

        if (is_array($foreignKeyValue)) {
            // Already an array, use it directly
            $query->whereIn($validated['foreignKey'], $foreignKeyValue);
        } elseif (is_string($foreignKeyValue) && strpos($foreignKeyValue, ',') !== false) {
            // String with commas, split it
            $values = explode(',', $foreignKeyValue);
            $query->whereIn($validated['foreignKey'], $values);
        } else {
            // Single value
            $query->where($validated['foreignKey'], $foreignKeyValue);
        }

        $references = $query->get();

        return response()->json(['count' => $references->count(), 'keys' => $validated, 'data' => $references]);
    }

    public function getReferences(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string',
            'foreignKey' => 'required|string',
            'foreignKeyValue' => 'required'
        ]);

        $modelName = ucwords($validated['model']);
        $modelClass = "App\\Models\\$modelName";

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model specified.'], 400);
        }

        $query = $modelClass::query()->select('id', 'name')->orderBy('name');

        // Handle both array and string/single value
        $foreignKeyValue = $validated['foreignKeyValue'];

        if (is_array($foreignKeyValue)) {
            // Already an array, use it directly
            $query->whereIn($validated['foreignKey'], $foreignKeyValue);
        } elseif (is_string($foreignKeyValue) && strpos($foreignKeyValue, ',') !== false) {
            // String with commas, split it
            $values = explode(',', $foreignKeyValue);
            $query->whereIn($validated['foreignKey'], $values);
        } else {
            // Single value
            $query->where($validated['foreignKey'], $foreignKeyValue);
        }

        $references = $query->get();

        return response()->json(['data' => $references, 'keys' => [$validated['model'], $validated['foreignKey'], $validated['foreignKeyValue']]]);
    }
}