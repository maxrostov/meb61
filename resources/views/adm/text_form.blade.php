@extends('adm.__layout')

@section('content')

{{--    <script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>--}}
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
 <h2>Редактирование текста</h2>

     {{ Form::model($text, [
     'route' => ['adm.texts.update', $text->id],

      'class' => 'ui form',
     'method' => 'patch']
 ) }}

      <div class="field">
         <label >Заголовок</label>

        <input name="title" placeholder="Заголовок статьи"
            @if(isset($text)) value="{{$text->title}}" @endif
            style="width: 100%;" required> <br><br>
         </div>

{{--     <input name="url" placeholder="URL (ЧПУ)"--}}
{{--            @if(isset($text)) value="{{$text->url}}" @endif--}}
{{--            style="width: 100%;" required> <br><br>--}}

{{--     <textarea placeholder="бриф (анонс статьи)" name="brief" cols="90" rows="4" style="width: 100%;">@if(isset($text)) {{$text->brief}} @endif</textarea>--}}
       <div class="field">

{{--           <div id="editor">--}}

{{--               @if(isset($text))  {!! $text->text !!} @endif--}}

{{--           </div>--}}

     <textarea name="text" id="texteditor" cols="90" rows="120" style="width: 100%; height: 100% " required>
     @if(isset($text))  {{$text->text}} @endif
 </textarea>
         </div>
     <div class="fields">
<div class="field">


         <button class='ui green tiny button' type="submit">Сохранить</button>
</div>
     </div>
     {!! Form::close() !!}

    <script>
        CKEDITOR.replace( 'text' );

        // ClassicEditor
        //     .create( document.querySelector( '#texteditor' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );
    </script>



@endsection
