@extends('layouts.main')
@section('title')
    Cart
@endsection
@section('content')
    <div class="container">
        @if(session('message'))
            <div class="col-md-12 text-center p-3 mb-4 bg-success text-light rounded">Purchases Has Been Successfully</div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Shopping Cart
                    </div>
                    <div class="card-body">
                        @if($items->count())

                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                @php($totalPrice = 0)
                                @foreach($items as $item)
                                    {{--لحساب سعر الكتب حسب عددها--}}
                                    @php($totalPrice += $item->price * $item->pivot->number_of_copies)

                                    <tbody>
                                    <tr>
                                        <th scope="row">{{ $item->title }}</th>
                                        <td>{{ $item->price }} $</td>
                                        <td>{{ $item->pivot->number_of_copies }}</td>
                                        <td>{{ $item->price * $item->pivot->number_of_copies }} $</td>
                                        <td>
                                            <form style="float:right; margin: auto 5px" method="post" action="{{ route('cart.remove_all', $item->id) }}">
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm" type="submit">Remove All</button>
                                            </form>

                                            <form style="float:right; margin: auto 5px" method="post" action="{{ route('cart.remove_one', $item->id) }}">
                                                @csrf
                                                <button class="btn btn-outline-warning btn-sm" type="submit">Remove One</button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            </table>
                            <h4 class="mb-5">Total Price : {{$totalPrice}} $ </h4>

                            <a href="{{route('credit.checkout')}}" class="d-inline-block mb-4 float-start btn bg-cart" style="text-decoration: none">
                                <span>Credit Card</span>
                                <i class="fas fa-credit-card"></i>
                            </a>
                        @else
                            <div class="alert alert-info text-center">
                                There Is No Books In Cart
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
