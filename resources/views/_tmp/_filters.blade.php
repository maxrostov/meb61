<div class="filters">

    <span class="filters_title">подобрать по параметрам</span>

    <div class="filter_dimensions">
        <form action="">

            <div class="dim_fields">
                <div class="dim_fields_label">Ширина, мм</div>
                <input  type="number" class="dim_fields_input" value="{{request()->dim_width_from}}" name="dim_width_from" placeholder="Ширина, от">
                <input  type="number" class="dim_fields_input" value="{{request()->dim_width_to}}" name="dim_width_to" placeholder="Ширина, до">
            </div>
            <div class="dim_fields">
                <div class="dim_fields_label">Высота, мм</div>
                <input  type="number" class="dim_fields_input" value="{{request()->dim_height_from}}" name="dim_height_from" placeholder="Высота, от">
                <input  type="number" class="dim_fields_input" value="{{request()->dim_height_to}}" name="dim_height_to" placeholder="Высота, до">
            </div>
            <div class="dim_fields">
                <div class="dim_fields_label">Глубина, мм</div>
                <input  type="number" class="dim_fields_input" value="{{request()->dim_depth_from}}" name="dim_depth_from" placeholder="Глубина, от">
                <input  type="number" class="dim_fields_input" value="{{request()->dim_depth_to}}" name="dim_depth_to" placeholder="Глубина, до">
            </div>




            <button class="filters_submit" type="submit">Фильтровать</button>
        </form>
    </div>
</div>
