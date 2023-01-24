@extends('layouts.main')
@section('title')
    Publishers
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Publishers
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <form action="{{route('gallery.publishers.search')}}" method="GET">
                                <div class="row d-flex justify-content-center">
                                    <input type="text" class="col-3 mx-sm-3 mb-2" name="term" placeholder="Search For Publisher">
                                    <button type="submit" class="col-1 p-1 btn btn-secondary mb-2">Search</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <br>
                        <h3 class="mb-4">{{$title}}</h3>
                        @if($publishers->count())
                            <ul class="list-group">
                                @foreach($publishers as $publisher)
                                    <a href="{{route('gallery.publishers.show', $publisher)}}" style="color: gray; text-decoration: none">
                                        <li class="list-group-item">
                                            {{$publisher->name}} ({{$publisher->books->count()}})
                                        </li>
                                    </a>
                                @endforeach
                            </ul>
                        @else
                            <div class="col-12 alert alert-info mt-4 mx-auto text-center">
                                No Result !
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
