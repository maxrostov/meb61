@extends('adm.__layout')

@section('content')
<h2>Разделы</h2>
    <a href="/adm/categories/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>

    <ul style="font-size: 120%;line-height: 170%;">
        @foreach($categories as $item)
            <li style="font-weight: bold;">    <a href="/adm/categories/{{$item->id}}/edit" class="@if($item->is_hidden) is_hidden @endif">{{$item->category}}</a>
                <a href="/adm/categories/create?cat_id={{$item->id}}"><i class="ui icon plus"></i></a>

            </li>

          <ul>
              @foreach($item->children->where('subparent_id',0)->sortBy('category') as $subcat)
                  <li>  <a href="/adm/categories/{{$subcat->id}}/edit" class="@if($subcat->is_hidden) is_hidden @endif">{{$subcat->category}}</a> {{$subcat->shortname}}
                      <a href="/adm/categories/create?cat_id={{$item->id}}&subcat_id={{$subcat->id}}"><i class="ui small icon plus"></i></a>

                  </li>
                  <ul>
                  @foreach($subcat->subchildren->sortBy('category') as $subsubcat)
                          <li>  <a href="/adm/categories/{{$subsubcat->id}}/edit" class="@if($subsubcat->is_hidden) is_hidden @endif">{{$subsubcat->category}}</a>
                          <a href="/adm/categories/create?cat_id={{$item->id}}&subcat_id={{$subsubcat->id}}"><i class="ui small icon plus"></i></a>

                          </li>

                          <ul>
                          @foreach($subsubcat->subchildren->sortBy('category') as $subsubsubcat)
                  <li>  <a href="/adm/categories/{{$subsubsubcat->id}}/edit" class="@if($subsubsubcat->is_hidden) is_hidden @endif">{{$subsubsubcat->category}}</a>   </li>
                              @endforeach
                          </ul>
              @endforeach
          </ul>
                  @endforeach

          </ul>


        @endforeach

    </ul>
@endsection
