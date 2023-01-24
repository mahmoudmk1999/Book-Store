{{-- الصفحةالرئيسية لعرض كل الكتب--}}
{{--ملف القالب--}}
@extends('layouts.main')
{{--قيم عنوان الصفحة --}}
@section('title')
Books Gallery
@endsection

{{--قسم الراس --}}
@section('head')
<style>
    .card{
        transition: all 0.5s ease;
        cursor: pointer;
    }


    .card:hover{
        box-shadow: 5px 6px 6px 2px #e9ecef;
        transform: scale(1.08);
    }
</style>
@endsection

{{--قسم المحتوى--}}
@section('content')
<div class="container">
    {{-- Start Search --}}
    <div class="row">
        <form action="{{route('gallery.search')}}" method="GET">
            <div class="row d-flex justify-content-center">
                <input type="text" class="col-3 mx-sm-3 mb-2" name="term" placeholder="Search For Book">
                <button type="submit" class="col-1 btn btn-secondary mb-2">Search</button>
            </div>
        </form>
    </div>
    {{-- End Search --}}
    <hr>
    {{-- Start View Books --}}
        <h3 class="my-3">{{$title}}</h3>
        <div class=" mt-50 mb-50">
            <div class="row">
                @if($books->count())
                    @foreach($books as $book)
                        @if($book->number_of_copies > 0)
                        <div class="col-lg-3 col-md-4 col-sm-6 mt-2">
                    <div class="card mb-3">
                        <div>
                            <div class="card-img-actions">
                                <a href="{{route('book.details', $book)}}">
                                <img src="{{asset($book->cover_image)}}" class="card-img img-fluid" width="96" height="350" alt="">
                                </a>
                            </div>
                        </div>

                        <div class="card-body bg-light text-center">
                            <div class="mb-2">
                                <h6 class="font-weight-semibold card-title mb-2 ">
                                    <a href="{{route('book.details', $book)}}" class="text-xl  mb-0 text-dark" data-abc="true" style="text-decoration: none;">{{$book->title}}</a>
                                </h6>
                                <a href="{{route('gallery.categories.show', $book->category)}}" class="text-muted" data-abc="true" style="text-decoration: none">
                                    @if($book->category != NULL)
                                        {{$book->category->name}}
                                    @endif
                                </a>
                            </div>


                            <p class="font-semibold text-xl" >{{$book->price}}$</p>

                            {{--Ratings Stars--}}
                            <div>
                                <span class="score">
                                    <div class="score-wrap">
                                        <span class="stars-active" style="width:{{ $book->rate()*20 }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                        <span class="stars-inactive">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-info" role="alert">
                        There is no book to see!!
                    </div>
                @endif
            </div>
        </div>
        {{$books->links()}}
    {{-- End View Books--}}
    </div>
</div>
@endsection
