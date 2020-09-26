@extends('layouts.mainlayout')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="featured-section">
        <div class="container">
            <h2>CART</h2>
            @if(\Cart::session(auth()->id())->getContent()->count() > 0)
            <table class="table text-center" >
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <div class="row">
                <tbody>

                @foreach(\Cart::session(auth()->id())->getContent() as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td><img src="{{asset($item->attributes['0'])}}" class="w-25 h-25"></td>
                        <td class="form-control" type="int">{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->getPriceSum() }}</td>
                        <td>
                            <form action="{{route('cart.destroy', $item->id)}}" method="POST" style=" width: 300px">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro desea elminar a {{$item->name}} ?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                </div>
                @endforeach
                </tbody>
            </table>
            <table class="table">
                <tr>
                    <td>Items on Cart:</td>
                    <td>{{Cart::session(auth()->id())->getContent()->count()}}</td>
                </tr>
                <tr>
                    <td>Total Qty:</td>
                    <td>@{{ details.total_quantity }}</td>
                </tr>
                <tr>
                    <td>Sub Total:</td>
                    <td>{{Cart::session(auth()->id())->getSubtotal()}}</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>{{Cart::session(auth()->id())->getTotal()}}</td>
                </tr>
            </table>
        </div>
        @else
            <h2> {{'There is no products into de Cart'}}</h2>
        @endif
    </div>

@endsection

