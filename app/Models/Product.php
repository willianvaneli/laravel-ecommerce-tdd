<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @property int $id
     * @property string $name
     * @property string $description
     * @property int $price
     * @property Carbon $created_at
     * @property Carbon $updated_at
     */


    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];


}
