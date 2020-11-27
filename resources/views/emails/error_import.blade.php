<table class="table">
    <thead>
    <tr>
        <th scope="col">@lang('Row')</th>
        <th scope="col">@lang('Errors')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($errors as $error)
        <tr>
            <th scope="row">{{$error['row']}}</th>
            <td>{{$error['message']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
