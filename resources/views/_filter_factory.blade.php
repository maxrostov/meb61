<div style="line-height: 210%;word-spacing: 150%;user-select: none">
    @if(request()->factory_id)
        <a href="{{request()->url()}}">[все производители]</a>

    @else
        <span style="border-bottom: 1px dashed grey;cursor:pointer;" onclick="my_toggle('factories_list')">Производители</span>
    @endif
    <span id="factories_list" @if(!isset(request()->factory_id)) style="display: none" @endif>@foreach($factories as $factory)
            @if(request()->factory_id == $factory->id)
                <span
                    style="padding: 3px 8px;border: 1px solid rgba(60,179,113,0.82); background: rgba(235,255,229,0.86);"> {{$factory->factory}}</span>
            @else
                <a href="?factory_id={{$factory->id}}">{{$factory->factory}}</a>
            @endif
        @endforeach</span>
</div>
