<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::latest()->paginate(10);
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        return view('admin.venues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'facilities' => 'required|array',
            'facilities.*' => 'string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'maintenance_start' => 'nullable|date',
            'maintenance_end' => 'nullable|date|after_or_equal:maintenance_start',
        ]);

        // Handle image upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('venues', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        Venue::create($validated);

        return redirect()->route('admin.venues.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function show(Venue $venue)
    {
        return view('admin.venues.show', compact('venue'));
    }

    public function edit(Venue $venue)
    {
        return view('admin.venues.edit', compact('venue'));
    }

    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'facilities' => 'required|array',
            'facilities.*' => 'string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'maintenance_start' => 'nullable|date',
            'maintenance_end' => 'nullable|date|after_or_equal:maintenance_start',
        ]);

        // Handle image upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($venue->images) {
                foreach ($venue->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('venues', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        } else {
            $validated['images'] = $venue->images;
        }

        $venue->update($validated);

        return redirect()->route('admin.venues.index')
            ->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Venue $venue)
    {
        // Delete images
        if ($venue->images) {
            foreach ($venue->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $venue->delete();

        return redirect()->route('admin.venues.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }
}