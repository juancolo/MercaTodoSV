@extends('layouts.mainlayout')

@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-3">{{__('Thank You!')}}</h1>
            <p class="lead">
                <strong>{{__('Your Payment Transaction was '. $order->status)}}</strong>
            </p>
            <p>
             {{__('Your Payment Transaction is '. $order->status)}}
            </p>
        <hr>
        <p>
            Having trouble? <a href="">Contact us</a>
        </p>
        @if($order->status == 'FAILED' || $order->status == 'REJECTED')
            <form action="{{route('payment.redone', $order)}}" method="POST">
                @csrf
                @method('POST')
                <button class="btn btn-primary btn-sm"
                        role="button"
                        type="submit"> {{__('Redone Payment')}}</button>
            </form>
        @endif
    </div>

@endsection
