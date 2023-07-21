<?php

namespace App\Models;

use App\Events\OrderPlaced;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFreeze extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $primaryKey = 'id';
    protected $table = 'orders';
    protected $fillable = [
        'order_id',
        'order_sn',
        'order_date',
        'store_id',
        'recipe_reference',
        'order_full_number',
        'recipe_number',
        'buyer_id',
    ];

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->recipe_number  = date('ym', strtotime($model->order_date)).'-'.str_pad($model->order_full_number, 5, '0',STR_PAD_LEFT);
        });
    }

    // protected $dispatchesEvents = [
    //     'created' => OrderPlaced::class
    // ];
}
