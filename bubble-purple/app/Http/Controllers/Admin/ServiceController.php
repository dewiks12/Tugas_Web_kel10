<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $services = $query->latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.form');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $service = Service::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $service->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete service. Please try again.');
        }
    }
}
