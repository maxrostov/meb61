$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

function select_all(){
    $('.js_checkbox').prop( "checked", true );
}



// (function($){
//     $.fn.selectMultiple = function(){
//         return this.mousedown(function(e){
//             e.preventDefault();
//             //save scrollTop to prevent scrolling on selection change.
//             //see: http://stackoverflow.com/questions/24543862/selecting-multiple-from-an-html-select-element-without-using-ctrl-key/
//             var scroll = this.scrollTop;
//             e.target.selected = !e.target.selected;
//             this.scrollTop = scroll;
//             $(this).focus();
//         }).mousemove(function(e){e.preventDefault()});
//     };
// })(jQuery);


$( document ).ready(function(){


    $('.ui.dropdown').dropdown();

    // $(".js_select select[multiple]").selectMultiple();


// мульти селект без контрола.
    jQuery('.js_select select option').mousedown(function(event) {

        if (event.shiftKey) return;
        event.preventDefault();
        this.focus();
        var scroll = this.scrollTop;
        event.target.selected = !event.target.selected;
        this.scrollTop = scroll;
    });

    // https://stackoverflow.com/questions/24543862/selecting-multiple-from-an-html-select-element-without-using-ctrl-key/
    // document.getElementById("category_ids_multiselect").addEventListener("onmousedown",
    //     function(event) {
    //         if (event.shiftKey) return;
    //         event.preventDefault();
    //         this.focus();
    //         var scroll = this.scrollTop;
    //         event.target.selected = !event.target.selected;
    //         this.scrollTop = scroll;
    //         // make sure that other listeners (like Vue) pick up on the change
    //         // even though we prevented the default.
    //         // this.dispatchEvent(new Event("change"));
    //     }
    //     );





    $('.js_click_toggle').click( function(event){
        // event.stopPropagation();
        // event.preventDefault();
        $(this).parent('tr').toggleClass('positive');
        // $(this).closest('input[type=checkbox]').prop('checked', function(_, checked) {return !checked; });
        $(this).parent('tr').children().find('input[type=checkbox]').prop('checked', function(_, checked) {
             return !checked;        });
    });


    $('.js_cat_label').click( function(event){
if (window.confirm('Удалить "'+this.textContent.trim()+'"?')){
        $.post( "/adm/ajax/detach_category",
            { product_id: $(this).data('product_id'),
            category_id: $(this).data('category_id') }
            )
            .done(( data ) =>
            {$('body').toast({class: 'success',
                position: 'bottom left',
                message: 'Раздел &laquo;'+this.textContent+'&raquo; удален'});
            $(this).hide('slow');
            }
            );
}  // window.confirm
    });



    // $('.inline_price_input').change( function(event){
    //    // alert('defaultValue='+this.defaultValue);
    //         $.post( "/adm/ajax/inline_price_input",
    //             { product_id: $(this).data('product_id'),
    //                 price: $(this).val() }
    //         )
    //             .done(( data ) =>
    //                 {$('body').toast({class: 'success',
    //                     position: 'top right',
    //                     message: 'Цена изменена: ' + this.defaultValue + ' &rarr; ' + $(this).val()});
    //                     $(this).addClass('inline_input_success');
    //
    //                 }
    //             );
    //
    // });


    $('.js_extend_textarea').focusin( function(event){

        this.setAttribute('style', 'height:4rem');

    });



    $('.js_inline_ajax_value').change( function(event){
        // alert('defaultValue='+this.defaultValue);

        $.post( "/adm/ajax/inline_value",
            {
                product_id: $(this).data('product_id'),
                field:$(this).data('field'),
                value: $(this).val()
            }
        )
            .done(( data ) =>
                {

                    $('body').toast({class: 'success',
                    position: 'top right',
                    message: 'Изменено: ' + this.defaultValue + ' &rarr; ' + data.field_updated_to});
                    $(this).addClass('inline_input_success');

                }
            );

    });





// vueJS pics sort & delete
    var app = new Vue({
        el: '#vue_photos',
        created() {
            var arr = $('#get_photos_initial').data('json');
            this.photos = arr.map( (item) => {
                return {name:item,
                    delete:false,
                    enlarge:false}
            } )
        },
        data() {
            return {photos: []}
        },
        computed:{
            my_photos(){
                return this.photos.map( (i) => { if(!i.delete) return  i.name} ).filter(x=> x);
            }
        },
        methods:{
            click_delete(id){
                this.photos[id].delete = !this.photos[id].delete ;
            },
            click_enlarge(id){
                this.photos[id].enlarge = !this.photos[id].enlarge ;
            }
        }
    });




});



