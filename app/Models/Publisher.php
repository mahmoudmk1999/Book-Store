<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable=['name','address'];

    //علاقة الربط مع الكتب
    public function books(){
        //هذا الناشر لديه عدة كتب
        return $this->hasMany(Book::class);
    }
}
