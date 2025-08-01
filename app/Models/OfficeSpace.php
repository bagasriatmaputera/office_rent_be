<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class OfficeSpace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'address',
        'about',
        'city_id',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function photos()
    {
        return $this->hasMany(OfficePhoto::class, 'office_space_id');
    }

    public function benefits()
    {
        return $this->hasMany(OfficeBenefit::class, 'office_space_id');
    }

    public function bookingtrx()
    {
        return $this->hasMany(BookingTransaction::class, 'office_space_id');
    }
}
