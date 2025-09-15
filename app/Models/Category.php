<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'description',
        'is_active'
    ];
    protected $attributes = [
        'is_active' => false
    ];
    protected $casts = [
        "created_at" => 'datetime:U'
    ];

    // function relationship ke product model
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    // static function untuk global scope
    protected static function booted()
    {
        parent::booted();
        self::addGlobalScopes([new IsActiveScope()]);
    }

    // function to get cheapest product
    public function cheapestProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->oldestOfMany('price');
    }

    // function to get most expensive product product
    public function mostExpensiveProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->latestOfMany('price');
    }

    // function relationship hasmanytrough to review model
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class, //related virtualaccount model
            Product::class,  //trough wallet model
            'category_id', //fk on products table
            'product_id', //fk on reviews table
            'id', //pk on customers table
            'id' //pk on wallets table
        );
    }
}
