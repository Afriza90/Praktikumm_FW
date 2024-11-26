<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable =[
        'supplier_name',
        'supplier_address',
        'phone',
        'comment',
    ];
    public function products()
    {
        return $this->hasMany(product::class);
    }
}