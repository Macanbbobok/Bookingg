<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Venue;
use App\Models\Booking;
use Carbon\Carbon;

class CalendarView extends Component
{
    public $currentDate;
    public $venues;
    public $selectedVenue = null;
    public $events = [];

    public function mount()
    {
        $this->currentDate = now();
        $this->venues = Venue::where('is_active', true)->get();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $startOfMonth = $this->currentDate->copy()->startOfMonth();
        $endOfMonth = $this->currentDate->copy()->endOfMonth();

        // Load bookings for selected venue or all venues
        $query = Booking::with('venue')
            ->whereIn('status', ['approved', 'pending'])
            ->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->where('start_date', '<=', $startOfMonth)
                            ->where('end_date', '>=', $endOfMonth);
                    });
            });

        if ($this->selectedVenue) {
            $query->where('venue_id', $this->selectedVenue);
        }

        $bookings = $query->get();

        $this->events = [];
        
        // Process bookings
        foreach ($bookings as $booking) {
            $this->events[] = [
                'id' => 'booking_' . $booking->id,
                'title' => $booking->event_name,
                'start' => $booking->start_date->format('Y-m-d'),
                'end' => $booking->end_date->format('Y-m-d'),
                'type' => 'booking',
                'status' => $booking->status,
                'color' => $this->getStatusColor($booking->status),
                'venue' => $booking->venue->name,
            ];
        }
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'approved' => 'blue',
            'pending' => 'yellow',
            default => 'gray',
        };
    }

    public function updatedSelectedVenue()
    {
        $this->loadEvents();
    }

    public function navigate($direction)
    {
        if ($direction === 'prev') {
            $this->currentDate = $this->currentDate->subMonth();
        } else {
            $this->currentDate = $this->currentDate->addMonth();
        }
        $this->loadEvents();
    }

    public function checkAvailability($date)
    {
        if (!$this->selectedVenue) {
            return null;
        }

        $venue = Venue::find($this->selectedVenue);
        return $venue->isAvailable($date, $date);
    }

    public function render()
    {
        return view('livewire.user.calendar-view');
    }
}