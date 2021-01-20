
    <div id="catalog_menu" class="catalog_menu columns is-multiline" style="{{$css_inline ?? ''}}">
        @foreach($main_categories as $cat)
            <div xstyle="white-space: nowrap" class="column is-one-fifth menu_column">
                <a class="catalog_title" href="/main/{{$cat->id}}">{{$cat->category}}</a>
                <br>
{{--                $cat->children->where('subparent_id',0)->sortBy('category')--}}
                @foreach($cat->children->where('subparent_id',0)->where('is_hidden',NULL)->sortBy('category') as $subcat)
                    <a href="/cat/{{$subcat->id}}">{{$subcat->shortname ?? $subcat->category}}</a><br>


{{--                @if($subcat->subchildren)--}}
{{--                        @foreach($subcat->subchildren as $subsubcat)--}}
{{--                        <a href="/cat/{{$subsubcat->id}}" style="font-size: 90%;margin-left: 10px;">{{$subsubcat->shortname ?? $subsubcat->category}}</a><br>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}


                @endforeach
            </div>
        @endforeach
    </div>

