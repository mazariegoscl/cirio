$( document ).ready( function() {
      /*$( "#datepicker" ).datepicker({
            inline: true,
            showOn: "button",
            buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
            buttonImageOnly: true
      });*/
      $( "nav > .nav-wrapper > ul > li > a" ).click( function() {
            var mn = $(this);
            var tgl = $(this).next( "ul" );
            tgl.slideToggle(100, function() {
                  if ( tgl.is(":visible") ) {
                        mn.removeClass( "inactive" ).addClass( "active" );
                  } else {
                        mn.removeClass( "active" ).addClass( "inactive" );
                  }
            });
      });

      $( ".burger-button" ).click( function() {
            var nav = $( "nav" );
            var pos = nav.position();
            if ( pos.left == "-250" ) {
                  $( "nav" ).css("transform", "translateX(0px)");
                  setTimeout( function() {
                        $( ".burger-button" ).html( "<i class='fa fa-chevron-left'></i>" );
                        $( ".burger-button" ).css( "color", "white" );
                  }, 300);
            } else {

                  $( "nav" ).css("transform", "translateX(-250px)");
                  setTimeout( function() {
                        $( ".burger-button" ).css( "color", "black" );
                        $( ".burger-button" ).html( "<i class='fa fa-bars'></i>" );
                  }, 400);
            }
      });
});
