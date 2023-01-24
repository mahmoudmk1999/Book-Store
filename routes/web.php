<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Authentication Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.main');
    })->name('dashboard');
});

//مسارات الصفحة الرئيسية
Route::get('/',[GalleryController::class,'index'])->name('gallery.index');
Route::get('/search',[GalleryController::class,'search'])->name('gallery.search');
Route::get('/book/{book}',[BookController::class,'details'])->name('book.details');


//categories //قلبنا الترتيب لانو عم يصير مشكلة
Route::get('/categories',[CategoryController::class,'list'])->name('gallery.categories.index');
Route::get('/categories/search', [CategoryController::class,'search'])->name('gallery.categories.search');
Route::get('/categories/{category}',[CategoryController::class,'result'])->name('gallery.categories.show');


//publishers //قلبنا الترتيب لانو عم يصير مشكلة
Route::get('/publishers',[PublisherController::class,'list'])->name('gallery.publishers.index');
Route::get('/publishers/search', [PublisherController::class,'search'])->name('gallery.publishers.search');
Route::get('/publishers/{publisher}',[PublisherController::class,'result'])->name('gallery.publishers.show');

//authors //قلبنا الترتيب لانو عم يصير مشكلة
Route::get('/authors',[AuthorController::class,'list'])->name('gallery.authors.index');
Route::get('/authors/search', [AuthorController::class,'search'])->name('gallery.authors.search');
Route::get('/authors/{author}',[AuthorController::class,'result'])->name('gallery.authors.show');



//هون بعد ما حولناهم لمجموعة وحطينا المدل وير يلي انشاناه
// model/user , providers/Authserviceprovider
// مسحنا الكلمة بكل المسارات يلي بالمجموعة /admin  كمان لما حطينا المسار
Route::prefix('/admin')->middleware('can:update-books')->group(function (){
//Control Panel
    Route::get('/',[AdminController::class,'index'])->name('admin.index');
//Control Panel Books
    Route::resource('/books',BookController::class);
//Control Panel Category
    Route::resource('/categories',CategoryController::class);
//Control Panel Publisher
    Route::resource('/publishers',PublisherController::class);
//Control Panel Authors
    Route::resource('/authors',AuthorController::class);
//Control Panel Users
    //هاد تبع التعديل في حالة المستخدمين
    Route::resource('/users',UserController::class)->middleware('can:update-users');
});

//Rating
Route::post('/book/{book}/rate',[BookController::class,'rate'])->name('book.rate');

//Cart
Route::post('/cart',[CartController::class,'addToCart'])->name('cart.add');
Route::get('/cart',[CartController::class,'viewCart'])->name('cart.view');
Route::post('/removeOne/{book}',[CartController::class,'removeOne'])->name('cart.remove_one');
Route::post('/removeAll/{book}',[CartController::class,'removeAll'])->name('cart.remove_all');

//Credit Card
Route::get('/checkout',[PurchaseController::class,'creditCheckout'])->name('credit.checkout');
Route::post('/checkout',[PurchaseController::class,'purchase'])->name('products.purchase');

// My Purchases
Route::get('/myproduct',[PurchaseController::class,'myProduct'])->name('my.product');

//Control Panel Purchase
Route::get('/admin/allproduct',[PurchaseController::class,'allProduct'])->name('all.product');
