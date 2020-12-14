@component('mail::message')
    @if (! empty($greeting))
        # {{ $greeting }}
    @endif

    @if($failures === 0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">@lang('Row')</th>
                <th scope="col">@lang('field')</th>
                <th scope="col">@lang('Errors')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($failures as $failure => $error)
                <tr>
                    <th scope="row">{{$error['row']}}</th>
                    <td>{{$error['attribute']}}</td>
                    <td>{{$error['errors']}}</td>
                </tr>
            </tbody>
        </table>
        @endforeach
        <div>
            <div class="card-body">
                @lang('products.messages.import.error')
            </div>
        </div>

    @else()
        @component('mail::message')
            <div>
                <div class="card-body">
                    {{trans('products.messages.import.ready',['count'=>$count] )}}
                </div>
            </div>
        @endcomponent
    @endif

    {{ config('app.name') }}
@endcomponent
