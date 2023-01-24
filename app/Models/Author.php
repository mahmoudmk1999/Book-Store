<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable=['name','description'];

    //علاقة الربط مع الكتب
    public function books(){
        // هذا الكاتب يتبع لعدة كتب
        return $this->belongsToMany(Book::class,'book_author');
    }
}
