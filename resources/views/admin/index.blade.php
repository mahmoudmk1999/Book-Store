@extends('theme.default')

@section('heading')
    Control Panel
@endsection

@section('content')
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of books </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$number_of_books}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of categories</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$number_of_categories}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of authors</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$number_of_authors}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pen-fancy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of publishers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$number_of_publishers}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-table fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
