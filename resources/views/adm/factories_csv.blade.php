
<pre>
id;артикул;название;фабричное название;цена;цвет фасад;цвет корпус;ширина;глубина;высота;вес;объем;упаковка;материал фасад;материал корпус;статус;раздел1;раздел2;раздел3;раздел4;
@foreach($products as $p)
{{$p->id}};{{$p->artikul}};{{$p->name}};{{$p->fabric_name}};{{$p->price}};{{$p->color_face}};{{$p->color_body}};{{$p->width}};{{$p->depth}};{{$p->height}};{{$p->weight}};{{$p->volume}};{{$p->load}};@isset($p->material_face){{$p->material_face->material}}@endisset;@isset($p->material_body){{$p->material_body->material}}@endisset;{{$p->status->status}};@isset($p->categories[0]->parent){{$p->categories[0]->parent->category}}@endisset;@isset($p->categories[0]->subparent){{$p->categories[0]->subparent->category}}@endisset;@isset($p->categories[0]){{$p->categories[0]->category}}@endisset;@isset($p->categories[0]->subparent->subparent){{$p->categories[0]->subparent->subparent->category}}@endisset;
@endforeach
</pre>
