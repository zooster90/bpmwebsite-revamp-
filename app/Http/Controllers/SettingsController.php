<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the admin Settings page.
     * Groups all settings by their 'group' column for the sectioned UI.
     */
    public function index()
    {
        $settings = Setting::allGrouped();

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update a single setting value.
     * Called via AJAX (fetch API) from the Settings page toggle/input.
     *
     * Expects JSON body: { "key": "maintenance_mode", "value": "1" }
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'key'   => ['required', 'string', 'exists:settings,key'],
            'value' => ['present'],
        ]);

        Setting::set($validated['key'], $validated['value']);

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully.',
            'key'     => $validated['key'],
            'value'   => $validated['value'],
        ]);
    }

    /**
     * Bulk update all settings from a standard HTML form POST.
     * Used as a fallback if JavaScript is disabled.
     */
    public function bulkUpdate(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Checkboxes that are unchecked won't appear in POST — handle booleans
            Setting::set($key, $value ?? '0');
        }

        // Also ensure unchecked boolean fields are set to '0'
        $booleanKeys = Setting::where('type', 'boolean')->pluck('key');
        foreach ($booleanKeys as $bKey) {
            if (!array_key_exists($bKey, $data)) {
                Setting::set($bKey, '0');
            }
        }

        return redirect()->route('admin.settings')
            ->with('success', 'All settings have been saved.');
    }
}
