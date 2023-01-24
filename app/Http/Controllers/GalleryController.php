<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //دالة عرض الكتب
    public function index(){
        //paginate بحددلنا عدد البيانات يلي بدنا نعرضها بالصفحة الواحدة
        $books = Book::Paginate(12);
        $title = 'Books Gallery';
        return view('gallery',compact('books','title'));
    }

    //دالة البحث
    public function search(Request $request){
        $books = Book::where('title','like',"%{$request->term}%")->paginate(12);
        $title = 'Search result for' . $request->term;
        return view('gallery',compact('books','title'));
    }
}
