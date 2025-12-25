<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing custom columns preferences
 * Handles saving, resetting, and toggling user column preferences
 */
class ColumnPreferenceController extends Controller
{
    /**
     * Save user's column preferences for a specific model
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $request->validate([
            'model_class' => 'required|string',
            'columns' => 'array',
            'columns.*' => 'string',
        ]);

        if (Auth::check()) {
            $modelClass = $request->input('model_class');
            $columns = $request->input('columns', []);

            // Remove excluded columns
            $model = new $modelClass();
            $excluded = $this->getExcludedColumnsWithSettings($model);
            $cleanColumns = array_values(array_diff($columns, $excluded));

            // Save columns for user
            getActiveUser()->saveTableColumnsFor($modelClass, $cleanColumns);

            return back()->with('success', __('main.columns_saved_successfully'));
        }

        return back()->with('error', __('main.unauthorized'));
    }

    /**
     * Toggle all columns on/off
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleAll(Request $request)
    {
        $request->validate([
            'model_class' => 'required|string',
            'is_all_selected' => 'required|boolean',
        ]);

        if (Auth::check()) {
            $modelClass = $request->input('model_class');
            $isAllSelected = $request->input('is_all_selected');
            $model = new $modelClass();
            $excluded = $this->getExcludedColumnsWithSettings($model);

            if ($isAllSelected) {
                // If all selected, reset to default
                $fillable = array_values(array_diff($model->getFillable(), $excluded));
                $defaultColumnsCount = getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
                $columns = array_slice($fillable, 0, $defaultColumnsCount);
            } else {
                // Select all columns
                $relations = method_exists($model, 'getRelationshipNames') ? $model->getRelationshipNames() : [];
                $fillable = $model->getFillable();
                array_splice($fillable, getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5)), 0, $relations);
                $columns = array_values(array_diff($fillable, $excluded));
            }

            getActiveUser()->saveTableColumnsFor($modelClass, $columns);

            return back()->with('success', __('main.columns_updated_successfully'));
        }

        return back()->with('error', __('main.unauthorized'));
    }

    /**
     * Reset user's column preferences to default
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'model_class' => 'required|string',
        ]);

        if (Auth::check()) {
            $modelClass = $request->input('model_class');
            getActiveUser()->deleteTableColumnsFor($modelClass);

            return back()->with('success', __('main.columns_reset_successfully'));
        }

        return back()->with('error', __('main.unauthorized'));
    }

    /**
     * Get excluded columns including uuid if disabled in settings
     *
     * @param mixed $model
     * @return array
     */
    protected function getExcludedColumnsWithSettings($model)
    {
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

        // Exclude uuid if disabled in settings
        if (getActiveSettings()->app_show_uuid_column == 0) {
            $excluded[] = 'uuid';
        }

        return $excluded;
    }
}
