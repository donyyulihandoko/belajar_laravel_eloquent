<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
