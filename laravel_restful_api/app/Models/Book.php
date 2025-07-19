<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
use HasFactory;

    protected $fillable = [
        'book_title',
        'book_price',
        'book_publish_year',
        'book_isbn',
        'auther_id',
        'created_at',
        'updated_at'
    ];
}
