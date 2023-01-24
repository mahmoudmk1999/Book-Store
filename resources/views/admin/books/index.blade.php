@extends('theme.default')

@section('head')
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet";
@endsection

@section('heading')
    Books View
@endsection

@section('content')
    <a class="btn btn-primary" href="{{route('books.create')}}"> <i class="fas fa-plus"> </i> Add New Book </a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table id="books-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>ISBN</th>
                        <th>Category</th>
                        <th>Authors</th>
                        <th>Publisher</th>
                        <th>Price</th>
                        <th>Processes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td><a href="{{route('books.show', $book)}}">{{$book->title}}</a></td>
                            <td>{{$book->isbn}}</td>
                            <td>{{$book->category != null ? $book->category->name : ""}}</td>
                            <td>
                            @if($book->authors()->count() > 0)
                                @foreach($book->authors as $author)
                                    {{--تعني اذا كانت اول دورة لا تحط شي--}}
                                    {{--اذا صرنا بعد اول دورة حطلنا الشي يلي بدنا ياه--}}
                                    {{$loop->first ? '' : 'and'}}
                                    {{$author->name}}
                                @endforeach
                            @endif
                            </td>
                            {{--اذا كان لنا ناشر عائد للكتاب اظهر الناشر والا اتركه فارغ--}}
                            <td>{{$book->publisher != null ? $book->publisher->name : ""}}</td>
                            <td>{{$book->price}}$</td>
                            <td>
                                {{--Edit Button--}}
                                <a href="{{route('books.edit', $book)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit </a>
                                {{--Delete Button--}}
                                <form action="{{route('books.destroy',$book)}}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete !!')"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{asset('theme/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready( function () {
            $('#books-table').DataTable();
        } );
    </script>
@endsection
