@extends('adm.__layout')

@section('content')

 <h2>Фабрики</h2>

 <a href="/adm/factories/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>

    <table class="ui striped selectable table">
   <thead>
   <tr>
       <th>Фабрика</th>
       <th>Наценка</th>
       <th>Всего  [{{$total_total}}]</th>
       <th>Удалено  [{{$deleted_total}}]</th>
       <th>"Не проверено"  [{{$status_1_total}}]</th>
       <th>"Проверено"  [{{$status_2_total}}]</th>
       <th>"Недочеты" [{{$status_3_total}}]</th>
       <th>"Скрыто" [{{$status_4_total}}]</th>
       <th>Экспорт CSV</th>
       <th>Прайсы</th>
       <th>Действия</th>
   </tr>
   </thead>

        <tbody>
@foreach($factories as $item)
        <tr>
            <td style="font-size: 150%;"><a href="/adm/factories/{{$item->id}}/edit">{{$item->factory}}</a></td>
            <td>{{$item->margin}}</td>
            <td>{{$total[$item->id] ?? '-'}}</td>
            <td>{{$deleted_by_factory[$item->id] ?? '-'}}</td>
            <td>{{$status_1[$item->id] ?? '-'}}</td>
            <td>{{$status_2[$item->id] ?? '-'}}</td>
            <td>{{$status_3[$item->id] ?? '-'}}</td>
            <td>{{$status_4[$item->id] ?? '-'}}</td>
            <td><a href="/adm/factories/{{$item->id}}/csv"><i class="file code outline grey icon"></i> CSV</a></td>
            <td><a href="/adm/factories/{{$item->id}}/price"><i class="redo grey icon"></i> Загрузить</a></td>
            <td><a href="/adm/factories/{{$item->id}}/actions"><i class="paper plane grey icon"></i> действия</a></td>
        </tr>
@endforeach
        </tbody>
    </table>

@endsection
