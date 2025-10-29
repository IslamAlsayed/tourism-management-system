<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getReferencesForTest(Request $request)
    {
        $request['model'] = 'city';
        // $request['model'] = 'state';
        // $request['model'] = 'country';

        // $request['foreignKey'] = 'state_id';
        $request['foreignKey'] = 'country_id';
        // $request['foreignKey'] = 'subregion_id';

        $request['foreignKeyValue'] = [111];

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

        $query = $modelClass::query()
            ->select('id', 'name')
            ->orderBy('name');

        // ✅ دعم array أو single value
        if (is_array($validated['foreignKeyValue'])) {
            $query->whereIn($validated['foreignKey'], $validated['foreignKeyValue']);
        } else {
            $query->where($validated['foreignKey'], $validated['foreignKeyValue']);
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

        // ✅ دعم array أو single value
        if (is_array($validated['foreignKeyValue'])) {
            $query->whereIn($validated['foreignKey'], $validated['foreignKeyValue']);
        } else {
            $query->where($validated['foreignKey'], $validated['foreignKeyValue']);
        }

        $references = $query->get();

        return response()->json(['data' => $references, 'keys' => [$validated['model'], $validated['foreignKey'], $validated['foreignKeyValue']]]);
    }

    public function getReferences_old(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required',
            'foreignKey' => 'required',
            'foreignKeyValue' => 'required'
        ]);

        $modelName = ucwords($validated['model']);
        $modelClass = "App\\Models\\$modelName";

        if (!class_exists($modelClass)) {
            return redirect()->back()->with('error', 'Invalid model specified.');
        }

        if (!$validated['foreignKey'] || !$validated['foreignKeyValue']) {
            return response()->json([]);
        }

        $references = $modelClass::where($validated['foreignKey'], $validated['foreignKeyValue'])->select('id', 'name')->orderBy('name')->get();

        if ($references->isEmpty())
            return response()->json([]);

        return response()->json(['data' => $references, 'keys' => [$validated['model'], $validated['foreignKey'], $validated['foreignKeyValue']]]);
    }
}