<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Date;

class Customer extends Model
{
    // use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    // atribute with untuk eager load relation
    protected $with = ['wallet', 'image'];

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

    // functions relationship hasmany to reviews model
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id', 'id');
    }

    // function relationship many to many to product model
    public function likeProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'customers_likes_products', 'customer_id', 'product_id')
            ->withPivot('created_at')
            ->using(Like::class);
    }

    // function relationship many to many to product model
    public function likeProductsLastWeek(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'customers_likes_products', 'customer_id', 'product_id')
            ->withPivot('created_at')
            ->wherePivot('created_at', '>=',  Date::now()->addDays(-7))
            ->using(Like::class);
    }

    // function relation one to one polymorphic to image model
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
