<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apiModel extends Model
{
    use HasFactory;

    protected $table="api_models";
    protected $fillable =[
        'title', 'price', 'image',
    ];
}
