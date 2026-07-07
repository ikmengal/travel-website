<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display Listing
     */
    public function index(Request $request)
    {
        $group = $request->get('group', 'general');

        $settings = Setting::query()
            ->when($group, fn ($q) => $q->where('group', $group))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $groups = Setting::$groups;

        return view('admin.settings.index', get_defined_vars());
    }

    /**
     * Create Form
     */
    public function create()
    {
        $groups = Setting::$groups;
        $types  = Setting::$types;

        return view('admin.settings.create', get_defined_vars());
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['value']    = $this->prepareValue($request, $validated['type']);
        $validated['autoload'] = $request->boolean('autoload');
        $validated['status']   = $request->boolean('status');

        Setting::create($validated);

        return redirect()
            ->route('settings.index', ['group' => $validated['group']])
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Edit
     */
    public function edit(Setting $setting)
    {
        $groups = Setting::$groups;
        $types  = Setting::$types;

        return view('admin.settings.edit', get_defined_vars());
    }

    /**
     * Update
     */
    public function update(Request $request, Setting $setting)
    {
        $validated = $this->validateData($request, $setting->id);

        $validated['value']    = $this->prepareValue($request, $validated['type'], $setting);
        $validated['autoload'] = $request->boolean('autoload');
        $validated['status']   = $request->boolean('status');

        $setting->update($validated);

        return redirect()
            ->route('settings.index', ['group' => $validated['group']])
            ->with('success', 'Setting updated successfully.');
    }

    /**
     * Delete
     */
    public function destroy(Setting $setting)
    {
        // Remove image file from storage if type is image
        if ($setting->type === 'image' && $setting->value) {
            Storage::disk('public')->delete($setting->value);
        }

        $group = $setting->group;
        $setting->delete();

        return redirect()
            ->route('settings.index', ['group' => $group])
            ->with('success', 'Setting deleted successfully.');
    }

    /**
     * Toggle status (active/inactive) via AJAX button.
     */
    public function toggleStatus(Setting $setting)
    {
        $setting->update(['status' => ! $setting->status]);

        return response()->json([
            'success' => true,
            'status'  => $setting->status,
        ]);
    }

    /**
     * Shared validation rules.
     */
    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'group' => ['required', Rule::in(array_keys(Setting::$groups))],
            'key'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('settings', 'key')->ignore($ignoreId),
            ],
            'type'  => ['required', Rule::in(array_keys(Setting::$types))],
            'value' => ['nullable'],
        ]);
    }

    /**
     * Prepare value based on field type (handles image upload, json, boolean).
     */
    private function prepareValue(Request $request, string $type, ?Setting $existing = null)
    {
        if ($type === 'image' && $request->hasFile('value')) {
            // delete old image when replacing
            if ($existing && $existing->value) {
                Storage::disk('public')->delete($existing->value);
            }

            return $request->file('value')->store('settings', 'public');
        }

        if ($type === 'image') {
            // keep old value if no new file uploaded
            return $existing->value ?? null;
        }

        if ($type === 'boolean') {
            return $request->boolean('value') ? '1' : '0';
        }

        if ($type === 'json') {
            // store as-is if already valid JSON string, else json_encode array input
            $value = $request->input('value');
            json_decode($value);
            return json_last_error() === JSON_ERROR_NONE ? $value : json_encode($value);
        }

        return $request->input('value');
    }
}
