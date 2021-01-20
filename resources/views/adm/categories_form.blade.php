@extends('adm.__layout')

@section('content')
    <a href="/adm/categories">&larr; Все разделы</a>

    @if(isset($category))
        <h3>Редактировать раздел</h3>


        {{ Form::model($category, [
    'route' => ['adm.categories.update', $category->id],
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить раздел</h3>
        {{ Form::open(['route' => 'adm.categories.store','class' => 'ui form',]) }}
    @endif

    <div class="fields">

        <div class="six wide field">
            <label>Название категории</label>
            {!! Form::text('category') !!}
        </div>
        <div class="six wide field">
            <label>Короткое название (для меню)</label>
            {!! Form::text('shortname') !!}
        </div>
    </div>
        <div class="fields">



    <div class="field">
        <label>Основной раздел</label>
        {!! Form::select('parent_id', $top_categories, ($cat_id ?? null), ['placeholder' => '[главный раздел]']) !!}
    </div>


    <div class="field">
        <label for="">Подраздел (необязательно)</label>
        {!! Form::select('subparent_id',$categories,($subcat_id ?? null),['placeholder' => 'без подраздела...']) !!}
    </div>
            <div class="field">
                <label>{!! Form::checkbox('is_hidden',1) !!} Спрятать раздел с сайта</label>
            </div>

</div>


   <div class="fields">
       <div class="field">
           <label for="">Текстовое описание</label>
           {!! Form::textarea('info') !!}

       </div>
   </div>


    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($category))
    {!! Form::model($category, ['route' => ['adm.categories.destroy',$category->id],
'onsubmit'=> "return confirm('действительно УДАЛИТЬ?');",'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif

    <br clear="all">
    <br><br><br><br>
    {!! $category->html_code ?? '' !!}

@endsection
