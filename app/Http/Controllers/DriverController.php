<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DriverModel as Driver;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return view('drivers.index', ['drivers' => Driver::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'nullable|exists:teams,id',
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'number' => 'required|integer',
            'points' => 'nullable|integer',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp,svg,avif|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('drivers', 'public');
        }

        Driver::create($data);

        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::findOrFail($id);
        return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Driver::findOrFail($id);
        return view('drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'team_id' => 'nullable|exists:teams,id',
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'number' => 'required|integer',
            'points' => 'nullable|integer',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp,svg,avif|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            if ($driver->image) {
                Storage::disk('public')->delete($driver->image);
            }
            $data['image'] = $request->file('image')->store('drivers', 'public');
        }

        $driver->update($data);

        return redirect()->route('drivers.show', $driver->id)->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted.');
    }
}