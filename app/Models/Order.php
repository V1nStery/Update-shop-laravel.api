<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
protected $fillable = [
    'first_name',
    'last_name',
    'city',
    'phone',
    'email',
    'product_name',
    'product_price',
    'product_id',
    'product_color',
    'product_memory',
    'product_description',
    'processed',
];
}
