<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Venue;
use App\Models\Booking;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class BookingForm extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $venueId;
    public $venue;
    public $eventName;
    public $eventDescription;
    public $startDate;
    public $endDate;
    public $totalDays = 0;
    public $totalPrice = 0;
    public $documents = [];
    public $notes;

    protected $rules = [
        'eventName' => 'required|string|max:255',
        'eventDescription' => 'required|string',
        'startDate' => 'required|date|after:today',
        'endDate' => 'required|date|after_or_equal:startDate',
        'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        'notes' => 'nullable|string',
    ];

    public function mount($venueId)
    {
        $this->venueId = $venueId;
        $this->venue = Venue::findOrFail($venueId);
    }

    public function render()
    {
        return view('livewire.user.booking-form');
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'eventName' => 'required|string|max:255',
                'eventDescription' => 'required|string',
                'startDate' => 'required|date|after:today',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);

            // Check availability
            if (!$this->venue->isAvailable($this->startDate, $this->endDate)) {
                $this->addError('date', 'Gedung tidak tersedia pada tanggal yang dipilih.');
                return;
            }

            $this->calculatePrice();
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function calculatePrice()
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $this->totalDays = $start->diffInDays($end) + 1;
        $this->totalPrice = $this->totalDays * $this->venue->price_per_day;
    }

    public function submitBooking()
    {
        $this->validate();

        // Store documents
        $documentPaths = [];
        foreach ($this->documents as $document) {
            $path = $document->store('booking-documents', 'public');
            $documentPaths[] = $path;
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'venue_id' => $this->venueId,
            'event_name' => $this->eventName,
            'event_description' => $this->eventDescription,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'total_price' => $this->totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'documents' => $documentPaths,
            'notes' => $this->notes,
        ]);

        session()->flash('success', 'Booking berhasil diajukan. Menunggu persetujuan admin.');
        return redirect()->route('user.bookings.show', $booking);
    }

    public function updatedStartDate()
    {
        if ($this->startDate && $this->endDate) {
            $this->calculatePrice();
        }
    }

    public function updatedEndDate()
    {
        if ($this->startDate && $this->endDate) {
            $this->calculatePrice();
        }
    }
}