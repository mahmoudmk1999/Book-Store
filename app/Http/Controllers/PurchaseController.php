<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Shopping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{
    //للتحقق من الكرت
    public function creditCheckout(Request $request){
        $intent = auth()->user()->createSetupIntent();

        $user_id = auth()->user()->id;
        $books = User::find($user_id)->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }
        return view('credit.checkout',compact('total','intent'));
    }

    //لارسال الايميل
    public function sendOrderConfirmation($order, $user){
        Mail::to($user->email)->send(new  OrderMail($order,$user));
    }



    //للحصول على بيانات الكرت لاتمام عملية الدفع
    public function purchase(Request $request){
        $user = $request->user();
        $paymentMethod = $request->input('payment_method');

        $user_id = auth()->user()->id;
        $books = User::find($user_id)->booksInCart;
        $total = 0;
        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            //ضربنا بمية لانو التعامل هون بالسنت
            $user->charge($total * 100,$paymentMethod );
        }catch (\Exception $exception){
            return back()->with('Something Wrong Make Sure From Name And Number', $exception->getMessage());
        }
        //مشان الايميل هالسطر
        $this->sendOrderConfirmation($books, auth()->user());

        foreach ($books as $book) {
            $bookPrice = $book->price;
            $purchaseTime = Carbon::now();
            $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE, 'price' => $bookPrice, 'created_at' => $purchaseTime]);
            $book->save();
        }

        return redirect('/cart')->with('message','Book Has Been Purchased');
    }

    //مشان صفحة مشترياتي
    public function myProduct(){
        $userId = auth()->user()->id;
        $myBooks = User::find($userId)->purchedProduct;

        return view('book.myProduct',compact('myBooks'));
    }

    // مشان صفحة المشتريات لوحة تحكم
    public function allProduct(){
    $allBooks = Shopping::with(['user','book'])->where('bought',true)->get();
    return view('admin.books.allProduct',compact('allBooks'));
    }
}
