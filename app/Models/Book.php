<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //من اجل السماح للوصول إلى جداول الداتا بيس
    protected $guarded=[];

    //علاقة الربط مع الصنف
    public function category(){
        //هذا الكتاب يتبع صنف
        return $this->belongsTo(Category::class);
    }

    //علاقة الربط مع الناشر
    public function publisher(){
        //هذا الكتاب يتبع ناشر
        return $this->belongsTo(Publisher::class);
    }

    //علاقة الربط مع الكاتبين
    public function authors(){
        //هذا الكتاب بتبع كاتبين
        return $this->belongsToMany(Author::class,'book_author');
    }

    //علاقة الربط مع التقييم
    public function ratings(){
        //هذا الكتاب مقيم من عدة مستخدمين
        return $this->hasMany(Rating::class);
    }

    //مشان حساب المتوسط الحسابي للتقييمات
    public function rate(){
        return $this->ratings->isNotEmpty() ? $this->ratings()->sum('value')/$this->ratings()->count()  : 0;
    }

}
