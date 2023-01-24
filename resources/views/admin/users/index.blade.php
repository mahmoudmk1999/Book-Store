@extends('theme.default')

@section('head')
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet";
          @endsection

          @section('heading')
              Users View
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--table--}}
            <table id="books-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Processes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->isSuperAdmin() ? 'Super Admin' : ($user->isAdmin() ? 'Admin' : 'User')}}</td>


                        {{--Edit Button--}}
                        <td>
                            <form action="{{route('users.update', $user)}}" class="me-4 form-inline" method="POST" style="display: inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="admin_level" class="form-control  form-control-sm">
                                    <option selected disabled>Choose Type</option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Super Admin</option>
                                </select>
                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>Edit</button>
                            </form>

                            {{--Delete Button--}}
                            <form action="{{route('users.destroy', $user)}}" method="POST" style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                {{--اذا كان المستخدم لا يساوي يلي فاتح الصفحة حطلوا زر الحذف --}}
                                @if(auth()->user() != $user)
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?')"><i class="fa fa-trash"></i>Delete</button>
                                {{--  والا اذا كان بساوي زر وقف زر الحذف مشان ما يحذف حالو --}}
                                @else
                                    <div class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i>Delete</div>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
