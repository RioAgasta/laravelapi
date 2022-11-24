<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['category_name', 'category_image'];

    function apiModel(){
        return $this->hasMany(apiModel::class, 'category_id', 'id');
    }
}
