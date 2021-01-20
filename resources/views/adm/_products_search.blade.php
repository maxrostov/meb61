


    <div class="fields">
{{--        <div class="field">--}}
{{--            <a href="{{route('adm.products.create')}}" class="ui labeled icon tiny button green"><i class="ui icon plus"></i>Добавить</a>--}}

{{--        </div>--}}
        <div class="five wide field">
            <input type="search" name="search_name" placeholder="название, фабричное название" value="{{old('search_name')}}">

               </div>

        <div class="three field">

            {!! Form::select('category_id',$categories,old('category_id'),['placeholder' => 'все разделы']) !!}

        </div>
        <div class="three field">

            {!! Form::select('factory_id',$factories,old('factory_id'),['placeholder' => 'все фабрики']) !!}

        </div>
{{--        <div class="three field">--}}

{{--            {!! Form::select('filter',[1=>'Только с фото',2=>'Только без фото',3=>'Не проверены',4=>'Удаленные'],old('filter'),['placeholder' => 'любой статус']) !!}--}}

{{--        </div>--}}
                <div class="three field">

{!! Form::select('order_by',['name_asc'=>'По алфавиту','created_at_asc'=>'Сначала старые','created_at_desc'=>'Сначала новые'],old('order_by')) !!}

                </div>

        <div class="three field">

            {!! Form::select('status',$statuses,old('status'),['placeholder' => 'все статусы']) !!}

        </div>

        <div class="three field">
{{--            ,80=>'80',120=>'120',200=>'200',500=>'500',1200=>'1200',2000=>'2000'--}}
            {!! Form::select('pagination',[20=>'20' ,80=>'80',120=>'120'

],(old('pagination') ?? 20)) !!}

        </div>
        <div class="three field">

            <button type="submit" name="submit" value="submit" class="ui labeled icon blue tiny button"><i class="ui icon search"></i>Искать</button>
        </div>

    </div>
    <div style="display: flex; ">

     <div style="width: 50%;">
         <label title="возможна перестановка слов, символы и 2-буквенные слова отбрасываются"  class="my_label my_label_search">
             <input   checked type="radio" name="search_mode" value="natural">простой</label>
         <label title="+слово приоритет, -слово исключать из поиска" class="my_label my_label_search">
             <input @if(request()->search_mode=='boolean') checked @endif type="radio" name="search_mode" value="boolean">с префиксами</label>
         <label title="точное вхождение, как в текстовых редакторах, со всеми символами" class="my_label my_label_search">
             <input @if(request()->search_mode=='like') checked @endif type="radio" name="search_mode" value="like">точный</label>

     </div>
        <div style="width: 50%;text-align:right;">
            <label class="my_label">{!! Form::checkbox('checkbox_no_photo', '1',old('checkbox_no_photo')) !!} без фото</label>
            <label class="my_label">{!! Form::checkbox('checkbox_no_price', '1',old('checkbox_no_price')) !!} без цены</label>
            <label class="my_label">{!! Form::checkbox('checkbox_with_deleted', '1',old('checkbox_with_deleted')) !!} с удаленными</label>

        </div>
     </div>
{{--    <br clear="all">--}}
{{--    закрываю форму в самом низу страницы, чтобы захватить массовые действия--}}
{{--</form>--}}


