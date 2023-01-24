@extends('theme.default')

@section('head')
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet";
          @endsection

          @section('heading')
              Authors View
@endsection

@section('content')
    <a class="btn btn-primary" href="{{route('authors.create')}}"> <i class="fas fa-plus"> </i> Add New Author </a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            {{--table--}}
            <table id="books-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Processes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{$author->name}}</td>
                        <td>{{$author->description}}</td>
                        <td>
                            {{--Edit Button--}}
                            <a href="{{route('authors.edit', $author)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit </a>
                            {{--Delete Button--}}
                            <form action="{{route('authors.destroy',$author)}}" method="POST" class="d-inline-block">
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
