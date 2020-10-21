@extends('layouts.mainlayout')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <div class="featured-section">
        <div class="container">
            <h2>CART</h2>
            @if($cartItems->count() > 0)
            <table class="table text-center" >
                <thead>
                <tr>
                    <th>@lang('Name')</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th></th>
                    <th>Unit Price</th>
                    <th>Subtotal Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <div class="row">
                <tbody>

                @foreach($cartItems as $item)
                    <tr>

                        <form class="form-control" action="{{ route('cart.update', $item->id) }}">
                            <td>{{ $item->name }}</td>
                            <td><img src="{{$item->attributes['0']}}" ></td>
                            <td>
                                <input name="quantity"
                                       type="number"
                                       min="1"
                                       value="{{ $item->quantity }}">
                            </td>
                            <td>
                                <button class="btn btn-secondary"
                                        type="submit"
                                        value="Guardar">{{__('Modify')}}
                                </button>
                            </td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->getPriceSum() }}</td>
                        </form>
                            <td>
                                <form action="{{route('cart.destroy', $item->id)}}" method="POST" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Seguro desea elminar a {{$item->name}} ?')">
                                        {{__('Delete')}}</button>
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
                    <td>{{$cartItems->count()}}</td>
                </tr>
                <tr>
                    <td>Sub Total:</td>
                    <td>{{$cartInfo ->getSubtotal()}}</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>{{$cartInfo ->getTotal()}}</td>
                </tr>
            </table>
                <row>
                    <form action="{{route('payment.index', $user)}}">
                        <input type="submit" value="{{__('Pay')}}" class="btn-payment">
                    </form>
                </row>
        </div>
        @else
            <h2> {{'There is no products into de Cart'}}</h2>
        @endif
    </div>
@endsection

