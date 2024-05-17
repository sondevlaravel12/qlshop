$(function() {
    $('form').on('keyup change', '.auto_formatting_input_value', function(event){
        auto_formatting_input_value($(this));
    });
    function auto_formatting_input_value($input){
        // When user select text in the document, also abort.
        var selection = window.getSelection().toString();
        if ( selection !== '' ) {
        return;
        }

        // When the arrow keys are pressed, abort.
        // if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
        // return;
        // }


        var $this = $input;

        // Get the value.
        var input = $this.val();

        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "es-AR" );
        } );
    };

});
