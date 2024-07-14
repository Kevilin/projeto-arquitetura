<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'idPipedrive',
        'name',
        'category',
        'code',
        'unit',
        'created_at',
        'updated_at'
    ];
}