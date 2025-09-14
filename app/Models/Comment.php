<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = true;
    // untuk menambahkan nilai default untuk column
    protected $attributes = [
        'title' => 'Default Title',
        'comment' => 'Default Comment'
    ];

    // function relation one to many polymorphic to product model and voucher model
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
