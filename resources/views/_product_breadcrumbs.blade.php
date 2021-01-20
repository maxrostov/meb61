
@if($category)
<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        <li><a href="/">Главная</a></li>

        <li><a href="/main/{{$category->parent->id}}">{{$category->parent->category}}</a></li>

        @if($category->subparent AND $category->subparent->subparent_id)
            <li>    <a href="/cat/{{$category->subparent->subparent->id}}">{{$category->subparent->subparent->category}}</a>
            </li>
        @endif

        @if($category->subparent_id)
            <li>    <a href="/cat/{{$category->subparent->id}}">{{$category->subparent->category}}</a>
            </li>
        @endif


        <li>
            <a href="/cat/{{$category->id}}">{{$category->category}}</a>
        </li>
    </ul>
</nav>
@endif
