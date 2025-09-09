<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    // use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'email'
    ];

    // function relationship to wallet model
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }

    // function relationship hasoneTrough to virtual acount model
    public function virtualAccount(): HasOneThrough
    {
        return $this->hasOneThrough(
            VirtualAccount::class, //related virtualaccount model
            Wallet::class,  //trough wallet model
            'customer_id', //fk on wallets table
            'wallet_id', //fk on virtual_accounts table
            'id', //pk on customers table
            'id' //pk on wallets table
        );
    }
}
