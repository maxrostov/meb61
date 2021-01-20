@extends('__layout')
@section('body')

    <h1 class="is-size-2">{{$text->title}}</h1>


    <div class="text_content">

        {!!  $text->text !!}

    </div>

@endsection
