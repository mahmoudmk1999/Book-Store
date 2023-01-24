<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;
    //مهم
    //تعريف موديل بجدول وسيط او بجدول غير اسم الموديل
    protected $table = 'book_user';

    //للربط بين جدول المستخدمين وجدول وسيط
    public function user(){
        //belongsTo لانو ربط مع جدول مباشرة
        return $this->belongsTo(User::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
