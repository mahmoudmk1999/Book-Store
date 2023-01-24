{{-- صفحة عرض معلومات الكتاب--}}
{{--ملف القالب--}}
@extends('layouts.main')

@section('title')
Book Details
@endsection

{{--قسم المحتوى--}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Book Details
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        {{--Add To Cart--}}
                        @auth
                            <div class="form text-center mb-2">
                                <input id="bookId" type="hidden" value="{{ $book->id }}">
                                <button type="submit" class="btn bg-cart addCart ms-2"><i class="fa fa-cart-plus"></i> Add To Cart</button>
                                <span class="text-muted mb-3"><input class="form-control d-inline mx-auto" id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $book->number_of_copies }}" style="width:10%;" required></span>
                            </div>
                        @endauth
                        <hr>
                        <tr>
                            <th>Title</th>
                            <td class="lead"><b>{{$book->title}}</b></td>
                        </tr>

                        <tr>
                            <th>Users Ratings</th>
                            <td>
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
                                <span>This Book Rated By ({{$book->ratings()->count()}}) User</span>
                            </td>
                        </tr>

                        @if($book->isbn)
                            <tr>
                                <th>ISBN</th>
                                <td>{{$book->isbn}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Cover Image</th>
                            <td><img src="{{asset($book->cover_image)}}" alt="" class="img-fluid img-thumbnail"></td>
                        </tr>
                        @if($book->category)
                            <tr>
                                <th>Category</th>
                                <td>{{$book->category->name}}</td>
                            </tr>
                        @endif
                        @if($book->authors()->count() > 0)
                            <tr>
                                <th>Authors</th>
                                @foreach($book->authors as $author)
                                    <td>
                                        {{--الشرط هون فتيل اول فتلة اذا مافي غير كاتب واحد تروك فراغ--}}
                                        {{--اذا في كاتب تاني ضيف الكلمة الفلانية--}}
                                        {{$loop->first ? '' : 'and'}}
                                        {{$author->name}}
                                    </td>
                                @endforeach
                            </tr>
                        @endif
                        @if($book->publisher)
                            <tr>
                                <th>Publisher</th>
                                <td>{{$book->publisher->name}}</td>
                            </tr>
                        @endif
                        @if($book->description)
                            <tr>
                                <th>Description</th>
                                <td>{{$book->description}}</td>
                            </tr>
                        @endif
                        @if($book->publish_year)
                            <tr>
                                <th>Publish Year</th>
                                <td>{{$book->publish_year}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Number Of Pages</th>
                            <td>{{$book->number_of_pages}}</td>
                        </tr>
                        <tr>
                            <th>Number Of Copies</th>
                            <td>{{$book->number_of_copies}}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>{{$book->price}}$</td>
                        </tr>
                    </table>
                    @auth
                        <h4 class="mb-3">Rate Book<h4>
                            @if($bookfind)
                                @if(auth()->user()->rated($book))
                                    <div class="rating">
                                        <span class="rating-star {{ auth()->user()->bookRating($book)->value == 5 ? 'checked' : '' }}" data-value="5"></span>
                                        <span class="rating-star {{ auth()->user()->bookRating($book)->value == 4 ? 'checked' : '' }}" data-value="4"></span>
                                        <span class="rating-star {{ auth()->user()->bookRating($book)->value == 3 ? 'checked' : '' }}" data-value="3"></span>
                                        <span class="rating-star {{ auth()->user()->bookRating($book)->value == 2 ? 'checked' : '' }}" data-value="2"></span>
                                        <span class="rating-star {{ auth()->user()->bookRating($book)->value == 1 ? 'checked' : '' }}" data-value="1"></span>
                                    </div>
                                @else
                                    <div class="rating">
                                        <span class="rating-star" data-value="5"></span>
                                        <span class="rating-star" data-value="4"></span>
                                        <span class="rating-star" data-value="3"></span>
                                        <span class="rating-star" data-value="2"></span>
                                        <span class="rating-star" data-value="1"></span>
                                    </div>
                               @endif
                           @else
                               <div class="alert alert-danger mt-4 text-sm " role="alert">
                                   You Must Purchase The Book To Rating
                               </div>
                           @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--هاد مشان تقييم النجمات--}}
@section('script')
    <script>
        $('.rating-star').click(function() {

            var submitStars = $(this).attr('data-value');

            $.ajax({
                type: 'post',
                url: {{ $book->id }} + '/rate',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'value' : submitStars
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    toastr.error('Something wrong')
                },
            });
        });
    </script>
    <script>
        $('.addCart').on('click', function(event) {
            var token = '{{ Session::token() }}';
            var url = "{{ route('cart.add') }}";

            event.preventDefault();

            var bookId = $(this).parents(".form").find("#bookId").val()
            var quantity = $(this).parents(".form").find("#quantity").val()


            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    quantity: quantity,
                    id: bookId,
                    _token: token
                },
                success : function(data) {
                    $('span.badge').text(data.num_of_product);
                    toastr.success('Book has Been Added')
                },
                error: function() {
                    alert('Something wrong');
                }
            })
        });
    </script>
@endsection
