@extends('layouts.mainlayout')
@section('title', 'Confirmar redirección')
@section('content')

    <form action="{{route('payment.store')}}" method="POST">
        @csrf
        @method('POST')
        <div class="webcheckout-section">
            <div class="row">
                <div class="col-75">

                    <div class="container-web">
                    <div class="col-50">
                        @if($errors->any())
                                <ul>
                                    <div class="alert-danger {{session('alert') ?? 'alert-info'}}">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                    </div>
                                </ul>
                        @endif
                    </div>
                        <form>

                            <div class="row">
                                <div class="col-50">
                                    <h3>Billing Address</h3>

                                    <label for="first_name"><i class="fa fa-user"></i> {{__('Full Name')}}</label>
                                    <input type="text"
                                           id="first_name"
                                           name="first_name"
                                           data-dismiss="alert"
                                           value="{{old('first_name',$user->first_name)}}">

                                    <label for="last_name"><i class="fa fa-user"></i>{{__('Last Name')}}</label>
                                    <input type="text"
                                           id="last_name"
                                           name="last_name"
                                           value="{{old('last_name', $user->last_name)}}">

                                    <label for="email"><i class="fa fa-envelope"></i> {{__('Email')}}</label>
                                    <input type="text"
                                           id="email"
                                           name="email"
                                           value="{{old('email',$user->email)}}">

                                        <label>{{__('Document Type')}}</label>
                                        <select class="form-control"
                                                name = "document_type">
                                            <option name = "document_type" value="{{__('CC')}}"> {{(('Cédula de Ciudadanía'))}}</option>
                                            <option name = "document_type" value="{{__('CE')}}"> {{('Cédula Extranjería')}}</option>
                                        </select>

                                    <label for="email">{{__('Document Number')}}</label>
                                    <input type="text"
                                           id="document_number"
                                           name="document_number"
                                           value="{{old('document_number')}}">
                                </div>

                                <div class="col-50">
                                    <h3>{{__('Address')}}</h3>

                                    <label for="mobile"><i class="fa fa-phone"></i> {{__('Mobile')}}</label>
                                    <input type="text"
                                           id="mobile"
                                           name="mobile"
                                           value="{{old('mobile')}}">

                                    <label for="state"><i class="fa fa-institution"></i> {{__('State')}}</label>
                                    <input type="text"
                                           id="state"
                                           name="state"
                                           value="{{old('state')}}"
                                           placeholder="{{__('Type your state')}}">

                                    <label for="city"><i class="fa fa-address-card-o"></i> {{__('City')}}</label>
                                    <input type="text"
                                           id="city"
                                           name="city"
                                           placeholder="542 W. 15th Street"
                                           value="{{old('city')}}">

                                    <label for="street"><i class="fa fa-address-card-o"></i> {{__('Street')}}</label>
                                    <input type="text"
                                           id="street"
                                           name="street"
                                           value="{{old('address')}}"
                                           placeholder="542 W. 15th Street">

                                    <div class="row">
                                        <div class="col-50">
                                            <label for="address">Address</label>
                                            <input type="text"
                                                   id="address"
                                                   name="address"
                                                   value="{{old('state')}}"
                                                   placeholder="NY">
                                        </div>
                                        <div class="col-50">
                                            <label for="zip">Zip</label>
                                            <input type="text"
                                                   id="zip"
                                                   name="zip"
                                                   value="{{old('zip')}}"
                                                   placeholder="10001">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <label>
                                <input type="checkbox"
                                       checked="checked"
                                       name="sameadr"> Shipping address same as billing
                            </label>
                            <input type="submit" value={{__('Continue to checkout')}} class="btn">
                        </form>
                    </div>
                </div>
            <!--
                <div class="col-25">
                    <div class="container">
                        <h4>Cart
                            <span class="price" style="color:black">
                  <i class="fa fa-shopping-cart"></i>
                  <b>4</b>
                </span>
                        </h4>
                        <p><a href="#">Product 1</a> <span class="price">$15</span></p>
                        <p><a href="#">Product 2</a> <span class="price">$5</span></p>
                        <p><a href="#">Product 3</a> <span class="price">$8</span></p>
                        <p><a href="#">Product 4</a> <span class="price">$2</span></p>
                        <hr>
                        <p>Total <span class="price" style="color:black"><b>$30</b></span></p>
                    </div>
                </div>
                -->
            </div>
        </div>
    </form>
@endsection
