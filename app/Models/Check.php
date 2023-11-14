<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Payment
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bankID',
    ];

    /**
     * Temp solution for authorized method
     * 
     * 
     */
    const VALID_BANK_ID = array(
        'BRI',
        'MANDIRI',
        'BNI',
        'BTN',
        'DANAMON',
        'BCA',
        'PERMATA',
        'MAYBANK',
        'PANIN',
        'CIMBNIAGA',
        'UOB'
    ) ;

    /**
     * See if the check is valid and authorized
     */
    public function authorized (): bool {
        return in_array($this->bankID, Check::VALID_BANK_ID);
    }
}
