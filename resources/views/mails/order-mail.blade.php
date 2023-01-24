<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Hello {{$user->name}}</p>
    <p>Your Order Has Been Successfully</p>
    <br>

    <table style="width: 600px; text-align: left">
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Price</th>
                <th>Number Of Copies</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subTotal = 0
            @endphp
            @foreach($order as $product)
                <tr>
                    <td>{{$product->title}}</td>
                    <td>{{$product->price}} $</td>
                    <td>{{$product->pivot->number_of_copies}}</td>
                    <td>{{ $product->price *  $product->pivot->number_of_copies}}</td>
                    @php
                        $subTotal += $product->price * $product->pivot->number_of_copies
                    @endphp
                </tr>
            @endforeach
            <hr>
            <tr>
                <td colspan="3" style="border-top: 1px solid #ccc"></td>
                <td style="font-size: 15px; font-weight: bold; border-top: 1px solid #ccc">Total Price : {{$subTotal}} $</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
