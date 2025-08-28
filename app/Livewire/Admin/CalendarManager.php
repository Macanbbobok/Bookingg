<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\DinasEvent;
use Carbon\Carbon;

class CalendarManager extends Component
{
    public $currentDate;
    public $view = 'month'; // month, week, day
    public $events = [];

    public function mount()
    {
        $this->currentDate = now();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $startOfMonth = $this->currentDate->copy()->startOfMonth();
        $endOfMonth = $this->currentDate->copy()->endOfMonth();

        // Load bookings
        $bookings = Booking::with('venue')
            ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->get();

        // Load dinas events
        $dinasEvents = DinasEvent::whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->get();

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
            ];
        }

        // Process dinas events
        foreach ($dinasEvents as $event) {
            $this->events[] = [
                'id' => 'event_' . $event->id,
                'title' => $event->title,
                'start' => $event->start_date->format('Y-m-d H:i:s'),
                'end' => $event->end_date->format('Y-m-d H:i:s'),
                'type' => 'dinas',
                'color' => 'green',
            ];
        }
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'approved' => 'blue',
            'pending' => 'yellow',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    public function changeView($view)
    {
        $this->view = $view;
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

    public function render()
    {
        return view('livewire.admin.calendar-manager');
    }
}