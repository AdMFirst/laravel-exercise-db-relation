<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
    ];

    public function cash() {
        return $this->hasOne(Cash::class);
    }

    public function credit() {
        return $this->hasOne(Credit::class);
    }

    public function Check() {
        return $this->hasOne(Check::class);
    }
}
