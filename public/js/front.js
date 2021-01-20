$(document).ready(function() {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    // Check for click events on the navbar burger icon
    $(".navbar-burger").click(function() {

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");

    });


    // https://bulma.io/documentation/elements/notification/
// close session notification banner
         (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
            $notification = $delete.parentNode;

            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
            });
        });





//or

    // Inputmask({"mask": "(999) 999-9999", ... other_options, ...}).mask(selector);
    // Inputmask("9-a{1,3}9{1,3}").mask(selector);
    // Inputmask("9", { repeat: 10 }).mask(selector);
    //
    // Inputmask({ regex: "\\d*" }).mask(selector);
    // Inputmask({ regex: String.raw`\d*` }).mask(selector);


});
