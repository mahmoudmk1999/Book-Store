<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //مشان يكون حصرا المستخدم المسجل فيه يحط بالسلة
    public function __construct(){
        $this->middleware('auth');
    }


    public function addToCart(Request $request)
    {
        $book = Book::find($request->id);

        if(auth()->user()->booksInCart->contains($book)) {
            //لاستقبال عدد النسخ التي اشتراها المستخدم
            $newQuantity = $request->quantity + auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies;
            //للتحقق انو عدد الكتب اقل من العدد الموجود للنسخ بالموقع
            if($newQuantity > $book->number_of_copies) {
                session()->flash('warning_message',  'We dont have number of books we have only ' . ($book->number_of_copies - auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies) . ' Book');
                return redirect()->back();
            } else {
                auth()->user()->booksInCart()->updateExistingPivot($book->id, ['number_of_copies'=> $newQuantity]);
            }

        } else {
            auth()->user()->booksInCart()->attach($request->id, ['number_of_copies'=> $request->quantity, 'price'=>$book->price]);
        }

        $num_of_product = auth()->user()->booksInCart()->count();

        return response()->json(['num_of_product' => $num_of_product]);
    }


    //لعرض الكتب في سلة المشتريات
    public function viewCart(){
        $items = auth()->user()->booksInCart;
        return view('cart', compact('items'));
    }

    //حذف نسخة واحدة من الكتب
    public function removeOne(Book $book)
    {
        //عدد النسخ في سلة المشتريات
        $oldQuantity = auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies;

        //للتحقق من انو في كتب
        if ($oldQuantity > 1) {
            auth()->user()->booksInCart()->updateExistingPivot($book->id, ['number_of_copies' => --$oldQuantity]);
        }
        //اذا ما كان في اكتر من نسخة
        else{
            auth()->user()->booksInCart()->detach($book->id);
        }

        return redirect()->back();
    }

    //لحذف جميع النسخ من السلة
    public function removeAll(Book $book) {
        auth()->user()->booksInCart()->detach($book->id);

        return redirect()->back();
    }

}
