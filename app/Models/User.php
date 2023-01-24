<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    //دالة للتحقق من حالة المستخدم الادمن
    public function isAdmin(){
        //هذا المستخدم اذا كانت صلاحياتو فوق الصفر رجع صح اذا كانت اقل رجع خطا
        return $this->admin_level > 0 ?  true : false;
    }

    //دالة للتحقق من حالة المستخدم السوبر ادمن
    public function isSuperAdmin(){
        //هذا المستخدم اذا كانت صلاحياتو فوق الواحد رجع صح اذا كانت اقل رجع خطا
        return $this->admin_level > 1 ?  true : false;
    }

    //علاقة الربط مع التقييم
    public function ratings(){
        //هذا المستخدم يستطيع ان يدع عدة تقييمات
        return $this->hasMany(Rating::class);
    }

    //للتحقق من اذا كان المستخدم قد قيم الكتاب
    public function rated(Book $book)
    {
        //هل المستخدم فيم الكتاب
        return $this->ratings->where('book_id', $book->id)->isNotEmpty();
    }

    // للتحقق من اذا كان المستخدم قيم الكتاب من قبل نحضر معلومات التقييم
    public function bookRating(Book $book){
        //هل المستخدم قيم الكتاب من قبل اذا كان قيم مشان نجبلو المعلومات اذا لا رجع فاضي
        return $this->rated($book) ? $this->ratings->where('book_id', $book->id)->first() : NULL;
    }

    public function booksInCart(){
        // هذا المستخدم لديه كتب
        // whithpivot هي الدالة شغلتها انو نجيب العواميد يلي بالجدول الوسيط وندخلها هون مشان يشوفها
        // wherepivot هون حددنا الشرط انو لم يتم الشراء بعد طيعا لانو لساتو بالسلة
        return $this->belongsToMany(Book::class)->withPivot(['number_of_copies', 'bought', 'price'])->wherePivot('bought', False);
    }

    //من اجل معرفة الكتب التي اشتراها المستخدم
    //مشان ما يقيم الكتاب غير يلي شاريه
    public function ratedPurches(){
        return $this->belongsToMany(Book::class)->withPivot(['bought'])->wherePivot('bought',true);
    }

    //مشان يعرضلنا الكتب المشتارة بصفحة مشترياتي
    public function purchedProduct(){

        return $this->belongsToMany(Book::class)->withPivot(['number_of_copies', 'bought', 'price', 'created_at'])->orderBy('pivot_created_at','desc')->wherePivot('bought',true);
    }
}
