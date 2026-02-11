<?php

namespace Modules\Subscriptions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscriptions\Entities\Module;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of all subscriptions.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $subscriptions = $user->subscriptions()->latest()->get();

        // Get available modules from database
        $availableModules = Module::paid()->available()->ordered()->get()
            ->mapWithKeys(function ($module) {
                return [
                    $module->key => [
                        'name' => $module->name,
                        'description' => $module->description,
                        'icon' => $module->icon,
                        'requires' => $module->requires,
                        'features' => $module->features ?? [],
                        'price_monthly' => $module->price_monthly,
                        'price_yearly' => $module->price_yearly,
                        'trial_days' => $module->trial_days,
                        'is_available' => $module->is_available,
                    ]
                ];
            })->toArray();

        return view('subscriptions::index', compact('subscriptions', 'availableModules'));
    }

    /**
     * Display current user's active modules.
     */
    public function myModules(Request $request)
    {
        $user = $request->user();
        $activeModules = $user->getActiveModules();
        $subscriptions = $user->activeSubscriptions()->get();

        return view('subscriptions::my-modules', compact('activeModules', 'subscriptions'));
    }

    /**
     * Activate a module subscription.
     */
    public function activate(Request $request, string $moduleKey)
    {
        $user = $request->user();

        if (!$user->hasModule($moduleKey)) {
            return back()->with('error', 'You do not have a subscription to this module.');
        }

        $user->activateModule($moduleKey);

        return back()->with('success', "Module '{$moduleKey}' has been activated successfully.");
    }

    /**
     * Deactivate a module subscription.
     */
    public function deactivate(Request $request, string $moduleKey)
    {
        $user = $request->user();

        if (!$user->hasModule($moduleKey)) {
            return back()->with('error', 'You do not have a subscription to this module.');
        }

        $user->deactivateModule($moduleKey);

        return back()->with('success', "Module '{$moduleKey}' has been deactivated.");
    }
}
