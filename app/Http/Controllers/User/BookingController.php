<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Venue;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('venue')
            ->latest()
            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Venue $venue)
    {
        return view('user.bookings.create', compact('venue'));
    }

    public function store(Request $request)
    {
        // Handling by Livewire component
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('venue', 'payments');
        return view('user.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== 'pending') {
            abort(403);
        }

        $booking->load('venue');
        return view('user.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== 'pending') {
            abort(403);
        }

        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        // Check availability
        if (!$booking->venue->isAvailable($validated['start_date'], $validated['end_date'], $booking->id)) {
            return back()->withErrors(['date' => 'Gedung tidak tersedia pada tanggal yang dipilih.']);
        }

        $booking->update($validated);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || !in_array($booking->status, ['pending', 'draft'])) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}