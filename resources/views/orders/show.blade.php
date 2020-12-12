@extends('layouts.mainlayout')

@section('content')

        <div class="featured-section">
            <div class="container" style="padding-top: 20px" >
                <h2>{{__('ORDERS')}}</h2>
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                            @if($order->status == 'OK')
                        @else
                                <div class="card" style="margin-top: 20px">
                                    <div class="card-header">
                                       <h5>{{__('Payment '.$order->status)}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{__('Reference: '.$order->reference)}}</h5>
                                        <h6 class="card-title">{{__('Pay: '.$order->PresentPrice())}}</h6>
                                        <p class="card-text">{{__('This payment was done at '.$order->updated_at)}}</p>

                                        @if($order->status == \App\Constants\OrderStatus::FAILED || $order->status == \App\Constants\OrderStatus::PENDING)

                                            <form action="{{route('payment.redone', $order)}}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <button class="btn btn-primary rightButton"
                                                        role="button"
                                                        style="float: right;"
                                                        type="submit"> {{__('Redone Payment')}}</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                        @endif
                        @endforeach
                    @else
                        <div >
                            <h3>{{__('You dont have any order yet')}}</h3>
                        </div>
                    @endif
            </div>
            {{$orders->appends(request()->only('search'))->links()}}
        </div>
@endsection
