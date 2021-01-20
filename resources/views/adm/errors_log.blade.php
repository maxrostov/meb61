@extends('adm.__layout')

@section('content')

                    <h2>Лог ошибок</h2>

<table class="ui table">
    <thead>
    <th>Дата</th>
    <th style="width: 70%">Ошибка</th>
    </thead>
                        @foreach ($errors as $error)
<tr>
 <td>{{$error->created_at}}
     <br>
     {{ \Illuminate\Support\Facades\Date::parse($error->created_at)->diffForHumans()}}
 </td>
    <td><a style="cursor:pointer;" onclick="$('#context{{$error->id}}').toggle()">{{$error->message}}</a>

        <div id="context{{$error->id}}" style="display: none">
            {{print_r(json_decode($error->context, true))}}
        </div>

    </td>
    <td>     </td>
</tr>




    @endforeach

</table>
                            {{ $errors->links('vendor/pagination/semantic-ui') }}


@endsection
