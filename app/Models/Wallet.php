<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wallet extends Model
{
    // use HasFactory;
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    // function relationship to customer model
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id',);
    }

    // function relationship to virtual account model
    public function virtualAccount(): HasOne
    {
        return $this->hasOne(VirtualAccount::class, 'wallet_id', 'id');
    }
}
