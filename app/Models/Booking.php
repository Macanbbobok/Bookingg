<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'venue_id',
        'event_name',
        'event_description',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'payment_status',
        'documents',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}