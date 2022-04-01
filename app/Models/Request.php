<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // for casting


class Request extends Model
{
    use HasFactory;

    protected $fillable = [
    
        'status',
        'driver_id',
        'user_id',
    ];


    protected function status(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value,
            get: fn ($value) => [
                true => 'Accepted',
                false => 'Rejected',
            ][$value],
            
        );
    }



    // belongs to

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // belongs to

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


}
