<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rating;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('admin.books.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();
        return view('admin.books.create',compact('authors','categories','publishers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'isbn' => ['required','alpha_num', Rule::unique('books','isbn')],
            'cover_image' => ['image','required'],
            'category' => 'nullable',
            'authors' => 'nullable',
            'publisher' => 'nullable',
            'description' => 'nullable',
            'publish_year' => ['nullable','numeric'],
            'number_of_pages' => ['required','numeric'],
            'number_of_copies' => ['required','numeric'],
            'price' => ['required','numeric'],
        ]);

        $book = Book::create([
           'title' => $request->title,
           'cover_image' => $this->uploadImage($request->cover_image),
           'isbn' => $request->isbn,
           'category_id' => $request->category,
           'publisher_id' => $request->publisher,
           'description' => $request->description,
           'publish_year' => $request->publish_year,
           'number_of_pages' => $request->number_of_pages,
           'number_of_copies' => $request->number_of_copies,
           'price' => $request->price,
        ]);

        $book->authors()->attach($request->authors);

        session()->flash('flash_message', 'Book Has Been Added Successfully');

        return redirect(route('books.show', $book));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();
        return view('admin.books.edit',compact('book','authors','categories','publishers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $this->validate($request,[
            'title' => 'required',
            'cover_image' => ['image'],
            'category' => 'nullable',
            'authors' => 'nullable',
            'publisher' => 'nullable',
            'description' => 'nullable',
            'publish_year' => ['nullable','numeric'],
            'number_of_pages' => ['required','numeric'],
            'number_of_copies' => ['required','numeric'],
            'price' => ['required','numeric'],
        ]);


        //updateكتبتهم بهي الصيغة بدل صيغة ال
        //لانو في شروط على بعض الجدول مشان هيك
        $book->title = $request->title;
        if ($request->has('cover_image')){
            Storage::disk('public')->delete($book->cover_image);
            $book->cover_image = $this->uploadImage($request->cover_image);
        }
        $book->isbn = $request->isbn;
        $book->category_id = $request->category;
        $book->publisher_id = $request->publisher;
        $book->description = $request->description;
        $book->publish_year = $request->publish_year;
        $book->number_of_pages = $request->number_of_pages;
        $book->number_of_copies = $request->number_of_copies;
        $book->price = $request->price;
        if ($book->isDirty('isbn')){
            $this->validate($request,[
                'isbn' => ['required','alpha_num', Rule::unique('books','isbn')],
            ]);
        }

        $book->save();


        $book->authors()->detach();
        $book->authors()->attach($request->authors);

        //هي مشان تطلعلنا رسالة بعد عملية التعديل
        session()->flash('flash_message', 'Book Has Been Edited Successfully');

        return redirect(route('books.show', $book));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    //دالة حذف كتاب
    public function destroy(Book $book)
    {

//        //لحذف الصورة من المجلد المخزنة به عن طريق احضار اسمها
//        Storage::disk('public')->delete($book->cover_image);
//        //لحذف كل معلومات الكتاب
//        $book->delete();

        //تم كتابتها بعد عناء طويل لانو يلي فوقها ما عم تشتغل
        if(Storage::delete($book->cover_image)) {
            unlink($book->cover_image);
            $book->delete();
        }

        //لاظهار رسالة بعد عملية الحذف بنجاح
        session()->flash('flash_message', 'Book Has Been Deleted Successfully');

        return redirect(route('books.index'));
    }


    //لعرض صفحة تفاصيل الكتاب مع تمرير المتغير
    public function details(Book $book){

        $bookfind = 0;

        if (Auth::check()){
            $bookfind = auth()->user()->ratedPurches()->where('book_id',$book->id)->first();
        }

        return view('book.details',compact('book','bookfind'));
    }

    //
    public function rate(Request $request, Book $book){

        //للتحقق اذا ماكان المستخدم قيم الكتاب مسبقا
        if (auth()->user()->rated($book)){
            $rating = Rating::where(['user_id' => auth()->user()->id, 'book_id' => $book->id])->first();

            $rating->value = $request->value;
            $rating->save();
        }
        else{
            $rating = new Rating;
            $rating->user_id =auth()->user()->id;
            $rating->book_id = $book->id;
            $rating->value = $request->value;
            $rating->save();
        }

        return back();

    }

}
