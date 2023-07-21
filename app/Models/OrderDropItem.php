<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDropItem extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    public $timestamps = false;
    protected $fillable = [
        'order_drop_id',
        'product_id',
        'order_quantity',
        'drop_quantity',
        'drop_status',
        'drop_time'
    ];
}
