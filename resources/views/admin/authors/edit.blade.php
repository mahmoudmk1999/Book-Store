@extends('theme.default')

@section('heading')
    Edit Author Data
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="card mb-4 col-md-8">
            <div class="card-header my-3">
                Edit
            </div>
            <div class="card-body">

                <form action="{{route('authors.update', $author)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{--title--}}
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-left">Author Name</label>

                        <div class="col-md-6">
                            <input id="name" name="name" value="{{$author->name}}"  autocomplete="name" type="text" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    {{--description--}}
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-left">Author Description</label>

                        <div class="col-md-6">
                            <textarea id="description" name="description" autocomplete="description" type="text" class="form-control @error('description') is-invalid @enderror">{{$author->description}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-1">
                            <button type="submit" class="btn-primary btn">Submit</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
