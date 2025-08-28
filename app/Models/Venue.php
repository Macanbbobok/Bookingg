<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'price_per_day',
        'facilities',
        'images',
        'is_active',
        'maintenance_start',
        'maintenance_end',
    ];

    protected $casts = [
        'facilities' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'maintenance_start' => 'date',
        'maintenance_end' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable($startDate, $endDate)
    {
        // Check if venue is in maintenance
        if ($this->maintenance_start && $this->maintenance_end) {
            if ($startDate <= $this->maintenance_end && $endDate >= $this->maintenance_start) {
                return false;
            }
        }

        // Check for overlapping bookings
        $overlappingBooking = $this->bookings()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->whereIn('status', ['approved', 'pending'])
            ->exists();

        return !$overlappingBooking;
    }
}