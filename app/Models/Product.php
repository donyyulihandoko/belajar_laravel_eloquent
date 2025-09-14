<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    // function relationship to category model
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // function relationship hasmany to review model
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    // function relationship many to many to customer model
    public function likedByCustomers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customers_likes_products', 'product_id', 'customer_id')
            ->withPivot('created_at')
            ->using(Like::class);
    }

    // function relation one to one polymorphic to image model
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // function relation one to many polymorphic to comment model
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // function relation condition one of many polymorphic to comment model
    public function latestComment(): MorphOne
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->latest('created_at');
    }


    // function relation condition one of many polymorphic to comment model
    public function oldestComment(): MorphOne
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->oldest('created_at');
    }

    // function relationship many to many polymorphic to tag model
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
