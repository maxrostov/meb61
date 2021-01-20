<div style="width: 250px;margin-left: 10px;margin-bottom: 90px;">
    <ul style="font-size: 100%;line-height: 110%;margin: 0;list-style-type: none;padding: 0">
        @foreach ($cat_tree as $cat)
            <li style="margin-left: 0;padding-left: 0;">
                <br><span style="font-weight: 300;" class="@if($cat->is_hidden) is_hidden @endif">{{ $cat->category }}</span>
                <ul style="margin-left: 0;list-style-type: none;padding-left: 0">
                    @foreach ($cat->subcat->where('subparent_id',0) as $scat)
                        <li>
                            <a href="/adm/products?category_id={{$scat->id}}"
                               class="@if($scat->is_hidden) is_hidden @endif"
                               @if (isset($_GET['category_id']) AND $_GET['category_id']==$scat->id) style='font-weight:500;border-bottom: 1px solid grey' @endif
                            >{{ $scat->category }}</a>
                            <span style="font-size: 80%;">{{ $product_count[$scat->id] ?? '-'}}</span>
                            <ul style="margin-left: 0;list-style-type: none;padding-left: 0;">

                                @foreach ($scat->subchildren as $sscat)
                                    <li>↳
                                        <a href="/adm/products?category_id={{$sscat->id}}"
                                           class="@if($sscat->is_hidden) is_hidden @endif"
                                           @if (isset($_GET['category_id']) AND $_GET['category_id']==$sscat->id) style='font-weight:500;border-bottom: 1px solid grey' @endif
                                        >{{ $sscat->category }}</a>
                                        <span style="font-size: 80%;">{{ $product_count[$sscat->id] ?? '-'}}</span>
                                        <ul style="margin-left: 2rem;padding-left: 0;color: lightgrey">

                                    @foreach ($sscat->subchildren as $ssscat)
                                                <li>

                                                    <a href="/adm/products?category_id={{$ssscat->id}}"
                                                       class="@if($ssscat->is_hidden) is_hidden @endif"
                                                       @if (isset($_GET['category_id']) AND $_GET['category_id']==$ssscat->id) style='font-weight:500;border-bottom: 1px solid grey' @endif
                                                    >{{ $ssscat->category }}</a>

                                                </li>
                                    @endforeach
                            </ul>
                                @endforeach

                            </ul>

                    @endforeach
                </ul>
        @endforeach
    </ul>
</div>
