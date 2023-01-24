@extends('theme.default')

@section('heading')
    Show Book Details
@endsection

@section('head')
    <style>
        table{
            table-layout: fixed;
        }
        table tr th{
            width: 30%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Book Details
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <td class="lead"><b>{{$book->title}}</b></td>
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
                        {{--Edit Button--}}
                        <a href="{{route('books.edit', $book)}}" class="btn btn-info btn-sm float-right"><i class="fa fa-edit"></i> Edit </a>
                        {{--Delete Button--}}
                        <form action="{{route('books.destroy',$book)}}" method="POST" class="d-inline-block ">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm " onclick="return confirm('Are You Sure To Delete !!')"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
