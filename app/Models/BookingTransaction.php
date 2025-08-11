<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx',
        'is_paid',
        'office_space_id',
        'total_amount',
        'duration',
        'started_at',
        'ended_at'
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'BRP0';
        do {
            $randomcode =   $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx', $randomcode)->exists());

        return $randomcode;
    }

    public function office_space()
    {
        return $this->belongsTo(OfficeSpace::class, 'office_space_id');
    }
}
