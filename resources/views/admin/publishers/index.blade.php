@extends('theme.default')

@section('head')
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet";
          @endsection

          @section('heading')
              Publishers View
@endsection

@section('content')
    <a class="btn btn-primary" href="{{route('publishers.create')}}"> <i class="fas fa-plus"> </i> Add New Publisher </a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            {{--table--}}
            <table id="books-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Processes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($publishers as $publisher)
                    <tr>
                        <td>{{$publisher->name}}</td>
                        <td>{{$publisher->address}}</td>
                        <td>
                            {{--Edit Button--}}
                            <a href="{{route('publishers.edit', $publisher)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit </a>
                            {{--Delete Button--}}
                            <form action="{{route('publishers.destroy',$publisher)}}" method="POST" class="d-inline-block">
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
