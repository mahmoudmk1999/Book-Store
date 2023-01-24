@extends('theme.default')

@section('heading')
Add New Book
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="card mb-4 col-md-8">
            <div class="card-header my-3">
                Add New Book
            </div>
            <div class="card-body">

                <form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{--title--}}
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-left">Book Title</label>

                        <div class="col-md-6">
                            <input id="title" name="title" value="{{old('title')}}"  autocomplete="title" type="text" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                        </div>

                    </div>

                    {{--isbn--}}
                    <div class="form-group row">
                        <label for="isbn" class="col-md-4 col-form-label text-md-left">Serial Number</label>

                        <div class="col-md-6">
                            <input id="isbn" name="isbn" value="{{old('isbn')}}"  autocomplete="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror">
                            @error('isbn')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{--Cover image--}}
                    <div class="form-group row">
                        <label for="cover_image" class="col-md-4 col-form-label text-md-left">Cover Image</label>

                        <div class="col-md-6">
                            <input id="cover_image" name="cover_image" accept="image/*" value="{{old('cover_image')}}"  onchange="readCoverImage(this)" autocomplete="cover_image" type="file" class="form-control @error('cover_image') is-invalid @enderror">
                            @error('cover_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror

                            <img id="cover-image-thumb" class="img-fluid img-thumbnail" src="" >
                        </div>
                    </div>

                    {{--Category--}}
                    <div class="form-group row">
                        <label for="category" class="col-md-4 col-form-label text-md-left">Category</label>

                        <div class="col-md-6">
                            <select id="category" name="category" class="form-control">
                                <option disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{--Author--}}
                    <div class="form-group row">
                        <label for="authors" class="col-md-4 col-form-label text-md-left">Authors</label>

                        <div class="col-md-6">
                            <select id="authors" multiple name="authors[]" class="form-control">
                                <option disabled selected>Select Authors</option>
                                @foreach($authors as $author)
                                    <option value="{{$author->id}}">{{$author->name}}</option>
                                @endforeach
                            </select>
                            @error('authors')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{--Publisher--}}
                    <div class="form-group row">
                        <label for="publisher" class="col-md-4 col-form-label text-md-left">Publisher</label>

                        <div class="col-md-6">
                            <select id="publisher" name="publisher" class="form-control">
                                <option disabled selected>Select Publisher</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                @endforeach
                            </select>
                            @error('publisher')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{--description--}}
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-left">Book Description</label>

                        <div class="col-md-6">
                            <textarea id="description" name="description" autocomplete="description" type="text" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{--Publish Year--}}
                    <div class="form-group row">
                        <label for="publish_year" class="col-md-4 col-form-label text-md-left">Publish Year</label>

                        <div class="col-md-6">
                            <input id="publish_year" name="publish_year" value="{{old('publish_year')}}"  autocomplete="publish_year" type="number" class="form-control @error('publish_year') is-invalid @enderror">
                            @error('publish_year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    {{--Number Of Pages--}}
                    <div class="form-group row">
                        <label for="number_of_pages" class="col-md-4 col-form-label text-md-left">Number Of Pages</label>

                        <div class="col-md-6">
                            <input id="number_of_pages" name="number_of_pages" value="{{old('number_of_pages')}}"  autocomplete="number_of_pages" type="number" class="form-control @error('number_of_pages') is-invalid @enderror">
                            @error('number_of_pages')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    {{--Number Of Copies--}}
                    <div class="form-group row">
                        <label for="number_of_copies" class="col-md-4 col-form-label text-md-left">Number Of Copies</label>

                        <div class="col-md-6">
                            <input id="number_of_copies" name="number_of_copies" value="{{old('number_of_copies')}}"  autocomplete="number_of_copies" type="number" class="form-control @error('number_of_copies') is-invalid @enderror">
                            @error('number_of_copies')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    {{--Price--}}
                    <div class="form-group row">
                        <label for="price" class="col-md-4 col-form-label text-md-left">Book Price</label>

                        <div class="col-md-6">
                            <input id="price" name="price" value="{{old('price')}}"  autocomplete="price" type="number" class="form-control @error('price') is-invalid @enderror">
                            @error('price')
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


@section('script')
    <script>
        function readCoverImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cover-image-thumb')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
