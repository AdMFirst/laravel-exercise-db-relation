<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

class Credit extends Payment
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'type',
        'expDate',
    ];

    /**
     * See if the check is valid and authorized
     * 
     * @return bool return true if the expiration date is more than 7 days
     */
    public function authorized (): bool {
        return Carbon::now()->diffInDays($this->attributes['expDate']) > 7;
    }

    public function payable(): MorphOne {
        return $this->morphOne(Payment::class, 'payable');
    }
}
