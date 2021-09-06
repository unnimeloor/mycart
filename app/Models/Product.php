<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $guarded = ['id_product'];

    public static function getScreenSize()
    {
        return [
            1 => [12, 12.9],
            2 => [13, 13.9],
            3 => [14, 14.9],
            4 => [15, 16.9],
        ];
    }

    public static function getPriceList()
    {
        return [
            'minimum' => [
                0 => 'Min',
                10000 => 10000,
                20000 => 20000,
                30000 => 30000,
                40000 => 40000,
            ],
            'maximum' => [
                10000 => 10000,
                20000 => 20000,
                30000 => 30000,
                40000 => 40000,
                50000 => 50000,
                60000 => 60000,
                70000 => 70000,
            ]
        ];
    }
}
