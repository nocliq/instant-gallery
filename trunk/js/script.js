     $(function() {

       $('.photo-link').drags();

       var $dragging = null;
       var maxZ = 0;

       $(".photo-link").on("click", function(e){

         e.preventDefault();

         if ($dragging==null) {
        //$dragging = null;
        var clicked = $(this).attr('href');
        TINY.box.show({image:clicked,boxid:'success',animate:true,opacity:80,close:true});

      } else {

        $dragging = $(e.target);

      }

    });

       $(".photo-link").on("mousedown", function(e){

         e.stopPropagation();

         $dragging = $(e.target);

       }).on("mousemove", 'body', function(e) {

        e.stopPropagation();
        $dragging = $(e.target);
        /* Find the max z-index property: */
        $('.photo-link').each(function(){
          var thisZ = parseInt($(this).css('zIndex'))
          if(thisZ>maxZ) maxZ=thisZ;
        });

        if($(e.target).hasClass("photo-link"))
        {
          /* Show the clicked image on top of all the others: */
          $(e.target).css({zIndex:maxZ+1});
        }
        else $(e.target).closest('.photo-link').css({zIndex:maxZ+1});

      }).on("mouseup", function (e) {

        e.preventDefault();
        $dragging = null;

      });



    })
//ORIGINAL//

/*        $(function() {

           $('.photo-link').drags();


           $(".photo-link").on("click", function(e){
             e.preventDefault();

             var maxZ = 0;


             $('.photo-link').each(function(){
              var thisZ = parseInt($(this).css('zIndex'))
              if(thisZ>maxZ) maxZ=thisZ;
            });

             if($(e.target).hasClass("photo-link"))
             {

              $(e.target).css({zIndex:maxZ+1});
            }
            else $(e.target).closest('.photo-link').css({zIndex:maxZ+1});


            var clicked = $(this).attr('href');
            TINY.box.show({image:clicked,boxid:'success',animate:true,opacity:80,close:true});


          });


         })

*/