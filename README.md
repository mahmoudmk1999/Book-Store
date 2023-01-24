# Book Store

- في هذا المشروع سوف نقوم  بانشاء متجر الكتروني لبيع الكتب
- تم العمل عبر تسلسل الخطوات التالية

# Installation

- ثم القيام بعملية التهجير**env** قمنا بانشاء مشروع لارافيل جديد وتغيير اسم الجدول في ملف

# Authintication

- **jetstream** من نوع **Authintication** بعد ذلك قمنا بتثبيت نظام ال

> composer require laravel/jetstream
> php artisan jetstream:install livewire
> npm install
> npm run build
> php .\artisan migrate
> php artisan vendor:publish --tag=jetstream-views

- قمنا بتفعيل ميزة صورة المستخدم عن طريق الدخول الى المسار التالي

> config/jetstream.php > features

- ### مشان حل مشكلة عدم ظهور الصورة
- اول شي بنكتب هاد الكود

> php .\artisan storage:link

- **env**وبنضيف البورت بملف ال

> APP_URL=http://localhost:8000

# Database

- قمنا بعمل رسمة للجدوال وطريقة الربط بينهم
- يجب الانتباه الى ترتيب الجداول كي لا تحصل مشاكل
- ## الجداول والربط بينهم

### 1.users

```
$table->unsignedInteger('admin_level')->default(0);
```

### 2. authors

> php .\artisan make:migration create_authors_table

```
$table->string('name');
$table->text('description')->nullable();
```

### 3. publishers

> php .\artisan make:migration create_publishers_table

```
$table->string('name');
$table->string('address')->nullable();
```

### 4. categories

> php .\artisan make:migration create_categories_table

```
$table->string('name');
$table->text('description')->nullable();
```

### 5. books

> php .\artisan make:migration create_books_table

```
public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->string('title');
            $table->string('isbn')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('publish_year')->nullable();
            $table->unsignedBigInteger('number_of_pages');
            $table->unsignedBigInteger('number_of_copies');
            //السعر في الوقت الحالي للكتاب
            $table->decimal('price', 8 , 2);
            $table->string('cover_image');
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('set null');
            $table->foreign('publisher_id')->references('id')->on('publishers')
                ->onDelete('set null');
        });
    }
```

### 6.book_author

> php .\artisan make:migration create_book_author_table

```
public function up()
    {
        Schema::create('book_author', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('book_id');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')
                ->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')
                ->onDelete('cascade');
        });
    }
```

### 7. book_user

> php .\artisan make:migration create_book_user_table

```
public function up()
    {
        Schema::create('book_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedInteger('number_of_copies')->default(1);
            $table->boolean('bought')->default(false);
            //السعر في الوقت الذي اشترى به المستخدم الكتاب
            $table->decimal('price' , 8, 2);
            $table->timestamps();
        });
    }
```

### 8. ratings

> php .\artisan make:migration create_ratings_table

```
public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedInteger('value');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')
                ->onDelete('cascade');
        });
    }
```

## Controllers and Models install

- هون قمنا بانشاء ما يتطلبه المشروع من متحكمات وموديلات

> php .\artisan make:model Book -cr
>
> php .\artisan make:controller UserController -r
>
> php .\artisan make:model Author -cr
>
> php .\artisan make:model Publisher -cr
>
> php .\artisan make:model Category -cr

## Database Relations in Models

### 1. Category

```
 public function books(){
        return $this->hasMany(Book::class);
    }

```

### 2. Publisher

```
public function books(){
        return $this->hasMany(Book::class);
    }
```

### 3. Author

```
public function books(){
        return $this->belongsToMany(Book::class,'book_author');
    }
```

### 4. Book

```
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class,'book_author');
    }
```

## Main.blade

- هي الصفحة تحوي القالب للصفحات الذي يحوي الكثير من الاشياء منها القائمة العلوية
- الشيء الجديد بهي الصفحة ومو مارق عليي من قبل هون وقت تسجيل الخروج استخدمنا جافا سكريبت

```
<form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-jet-responsive-nav-link>
                                    </form>
```

## Factory and seeder

- هون قمنا بانشاء ملفات مشان نعبي بيانات وهمية وللوصول للملفات فوت عليهم

## Gallery

- قمنا بانشاء كونترولر
- قمنا بانشاء دالة عرض وعرفناها بالراوت
- قمنا بانشاء صفحة عرض مشان نعرض فيها الكتب galley.blade
- فعلنا خاصية البحث وكانت الطريقة سهلة  كالتالي

```
//Blade
<div class="row">
        <form action="{{route('gallery.search')}}" method="GET">
            <div class="row d-flex justify-content-center">
                <input type="text" class="col-3 mx-sm-3 mb-2" name="term" placeholder="Search For Book">
                <button type="submit" class="col-1 btn btn-secondary mb-2">Search</button>
            </div>
        </form>
    </div>


//Controller
public function search(Request $request){
        $books = Book::where('title','like',"%{$request->term}%")->paginate(12);
        $title = 'Search result for' . $request->term;
        return view('gallery',compact('books','title'));
}


//Route
Route::get('/search',[GalleryController::class,'search'])->name('gallery.search');
```

## Book Deatil

- عند ضغط كل كتاب galery اول شي ضفنا الراوت تبعو بملف ال
- بعدين زبطنا الامور بالراوت والكنترولر
- بعدها ساوينا صفحة عرض جديدة مشان تعرضلنا معلومات الكتاب اسمها book/deatils

---

## Category Publisher Author sites

- هي الصفحة بتحوي التصنيفات وعدد الكتب تبع نفس التصنيف
- التلاتة نفس الترتيبة
- انشانا فيها هدول الدوال مهمة اذا لزموك ومنهم دالة ال search
- الدوال كلها مكررة بنفس الصفحات بس الاسماء غير

```
//Controller
   public function result(Category $category){
        $books = $category->books()->paginate(12);
        $title = 'Books Have Same Category : ' . $category->name;
        return view('gallery',compact('books', 'title'));
    }

    public function list(){
        $categories = Category::all()->sortBy('name');
        $title = 'Categories';
        return view('categories.index',compact('categories' , 'title'));
    }

    public function search(Request $request){
        $categories = Category::where('name', 'like', "%{$request->term}%")->get()->sortBy('name');
        $title = 'Search Results : ' . $request->term;
        return view('categories.index',compact('categories' , 'title'));
    }

//Route

//categories //قلبنا الترتيب لانو عم يصير مشكلة
Route::get('/categories',[CategoryController::class,'list'])->name('gallery.categories.index');
Route::get('/categories/search', [CategoryController::class,'search'])->name('gallery.categories.search');
Route::get('/categories/{category}',[CategoryController::class,'result'])->name('gallery.categories.show');
```

## Control panel

- اول شي حملنا ثيم من النت وعدلنا عليه وقسمناه الى ملفات
- sidebar / header / footer / default
- بعدين انشانا الصفحة الرئيسية بلوحة التحكم
- admin/index
- بعدين انشانا صفحة مشان عرض كامل الكتب ومعلوماتها

### admin/books/index

- وهي كودها loop بهي الصفحة انشانا هي الميزة الحلوة

```
<td>
                            @if($book->authors()->count() > 0)
                                @foreach($book->authors as $author)
{{--                                    //تعني اذا كانت اول دورة لا تحط شي--}}
{{--                                    // اذا صرنا بعد اول دورة حطلنا الشي يلي بدنا ياه--}}
                                    {{$loop->first ? '' : 'and'}}
                                    {{$author->name}}
                                @endforeach
                            @endif
                            </td>
```

- وفي هي كمان عبارة شرطية ممكن بنفس السطر ممكن تلزم احيانا

```
{{--                            //اذا كان لنا ناشر عائد للكتاب اظهر الناشر والا اتركه فارغ--}}
                            <td>{{$book->publisher != null ? $book->publisher->name : ""}}</td>
```

- وهي طريقة اضافتها javascript في ميزة عرض الصفحة مع عداد وبحث
- هاد الموقع تبعها : https://datatables.net/

```
 //Script
<!-- Page level plugins -->
    <script src="{{asset('theme/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready( function () {
            $('#books-table').DataTable();
        } );
    </script>

//css
<!-- Custom styles for this page -->
    <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet";

//table 
<table id="books-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
```

### admin/books/create

- اولا قمنا بانشاء صفحة عرض فيها فورم يحوي جميع الاشياء يلي بدنا ندخلها

> admin/books/create

### admin/books/store

- هون كان اصعب مكان
- وكتبنا فيه الدالة مع الفالديشين BookController بعدين فتنا على الكونترولر
- اثناء كتابة الدالة مشان نحدد حجم معين للصورة ساوينا تريت واستدعينا فيه الحزمة هي

> composer require intervention/image

- بعدين كتبنا بقلبو دالة مشان نحدد حجم معين للصورة image size

### admin/books/show

- بهي الصفحة قمنا باخذ نسخة من  صفحة عرض تفاصيل الكتاب وانشانا دالة العرض بالكونترولر

### admin/books/edit

- بهي انشانا صفحة مشان نعرض البيانات في صفحة قبل  ارسال طلب التعديل

### admin/books/update

- قمنا هون بانشاء علمية التحديث الموجودة بالكنترولر

### admin/books/delete

- قمنا هون بانشاء عملية الحذف الموجودة بالكنترولر

## Category , publisher , Author

- هون ساوينا نفس خطوات الكتاب فتنا عالكونترولر وعدلنا فيه
- ساوينا صفحات العرض الرئيسية

## Admin صلاحيات

- وكتبنا فيه دالتين التحقق من رقم حالة المستخدم user فتنا على موديل
- AuthServiceProvide بعدين فتنا على ملف
- وكتبنا فيه شي متل المديل وير
- بعدين فتنا عالراوت وانشانا مجموعة فيها المديل وير يلي انشاناه وتم الموضوع

## User

- هون ساوينا صفحة مشان تعديل حالة المستخدم او حذفو

## Rating

- ساوينا ستتم التقييم والنجمات

## Add book To by Cart

- هون ساوينا كونترلر cartcontroller
- وكتبنا فيه الدوال اللازمة
- الغرض من هون او ننشا زر اضافة الى السلة مع مراعاة انو اشتغل

## View Cart

- صفحة لعرض السلة وفيها زر حذف

## Paypal Payment

- اول شي فتنا على صفحة paypal developer
- بعدين فتنا عالرابط التالي [Integrate Checkout (paypal.com)](https://developer.paypal.com/docs/checkout/standard/integrate/)
- بعدين نسخنا الكود وحطيناه بملف ال cart.blade
- طبعا ما حسنت اعمل حساب لانو بتركيا مو شغال

## MasterCard Payment

- اول شي فتنا عالرابط [Laravel Cashier (Stripe) - Laravel - The PHP Framework For Web Artisans](https://laravel.com/docs/9.x/billing)
- بعدين ثبتنا الحزمة

```
//composer
php artisan migrate
php artisan vendor:publish --tag="cashier-migrations"

//User Model 
use Laravel\Cashier\Billable;
 
class User extends Authenticatable
{
    use Billable;
}

//env
STRIPE_KEY=your-stripe-key
STRIPE_SECRET=your-stripe-secret



```

- بعدين فتنا على هي الصفحة نسخنا منها الفورم والتنسيقات والسكريبت[How to Add Stripe One-Time Payment Form to Laravel Project – Quick Admin Panel](https://blog.quickadminpanel.com/how-to-add-stripe-one-time-payment-form-to-laravel-project/)

## Mail

- اعتمدنا هون على الموقع هاد https://mailtrap.io/
- رح نستخدمو مشان نبعت ايميل بعد ما تتم عملية الشراء

## My payment site

- هي الصفحة يلي بينعرض فيها مشترياتي

## Payment

- هي صفحة يلي المدير بشوف حركات الشراء منها
- ساوينا موديل وربطاه بجدول ربط shopping ******** مهم
