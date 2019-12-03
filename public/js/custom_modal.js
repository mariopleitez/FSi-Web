
$(function(){
     var base = $("#main-wrapper").attr('base');
     console.log(base);
  //  var direccion = $("#updatediv").attr("dir");
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
    //we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
    $(document).on('click', '.showModalButton', function(e){
        e.preventDefault();
         //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        if ($('#modalDefault').data('bs.modal').isShown) {
             
             $('#modalDefault').find('#modalContent').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'), function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success"){
                    console.log($(".select2").length);
                        if ($(".select2").length > 0) {
                            $(".select2").select2();
                        }
                }
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });

            //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
           
        } else {
            //if modal isn't open; open it and load content
           //  $('#modalDefault').modal('show').find('#modalContent').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'));
           
           $('#modalDefault').find('#modalContent').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'), function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success"){
                    console.log($(".select2").length);
                        if ($(".select2").length > 0) {
                            $(".select2").select2();
                        }
                }
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });


             //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';


           
        }



    });


    $(document).on('click', '.showModalButtonAuthor', function(e){
        e.preventDefault();
         //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        if ($('#modalDefaultAuthor').data('bs.modal').isShown) {
             
             $('#modalDefaultAuthor').find('#modalContentAuthor').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'), function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success"){
                    console.log($(".select2").length);
                        if ($(".select2").length > 0) {
                            $(".select2").select2();
                        }
                }
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });

            //dynamiclly set the header for the modal
            document.getElementById('modalHeaderAuthor').innerHTML = '<h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
           
        } else {
            //if modal isn't open; open it and load content
           //  $('#modalDefault').modal('show').find('#modalContent').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'));
           
           $('#modalDefaultAuthor').find('#modalContentAuthor').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'), function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success"){
                    console.log($(".select2").length);
                        if ($(".select2").length > 0) {
                            $(".select2").select2();
                        }
                }
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });


             //dynamiclly set the header for the modal
            document.getElementById('modalHeaderAuthor').innerHTML = '<h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';


           
        }



    });



    $(document).on('click', '.showModalButtonClinica', function(e){
        e.preventDefault();
         //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        if ($('#modalDefaultClinica').data('bs.modal').isShown) {
             
             $('#modalDefaultClinica').find('#modalContent').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'), function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success")
                 //   alert("External content loaded successfully!");
                    $('.selectpicker2').selectpicker();
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });

            //dynamiclly set the header for the modal
            document.getElementById('modalHeaderClinica').innerHTML = '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4>';
           
        } else {
            //if modal isn't open; open it and load content
             $('#modalDefaultClinica').modal('show').find('#modalContent').html("<div style='text-align:center; margin-top: 25px'><img src='"+base+"/img/loading_nice.gif' style='width:128px'></div>").load($(this).attr('link'));
             //dynamiclly set the header for the modal
            document.getElementById('modalHeaderClinica').innerHTML = '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4>';
        }
    });


    $(document).on('click', '.showModalDeleteButton', function(e){
        e.preventDefault();
        var link = $(this).attr("link");
        var name = $(this).attr("name");
        var id   = $(this).attr("id");
        // var tbl  = $(this).attr("tbl");
        if ($('#modalNarrower').data('bs.modal').isShown) {
            $('#modalNarrower').find('#modalContent2').html("¿Seguro que desea eliminar: \"" + name + '"?');
            //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4>';
            $('#modalNarrower').find(".deleteRecord").attr('link', link);
            $('#modalNarrower').find(".deleteRecord").attr('id', id);
            // $('#modalNarrower').find(".deleteRecord").attr('tbl', tbl);
        } else {
            //if modal isn't open; open it and load content
            $('#modalNarrower').find('#modalContent2').html("¿Seguro que desea eliminar: \"" + name + '"?');
             //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 style="margin: 0px !important">' + $(this).attr('title') + '</h4>';
            $('#modalNarrower').find(".deleteRecord").attr('link', link);
            $('#modalNarrower').find(".deleteRecord").attr('id', id);
            // $('#modalNarrower').find(".deleteRecord").attr('tbl', tbl);
        }
    });

});





// $('body').on('show.bs.modal', function () {
//     $('.showModalButton .modal-body').css('overflow-y', 'auto');
        
//     $('.showModalButton .modal-body').css('max-height', $(window).height() * 0.7);
    
//     $('.selectpicker').selectpicker('refresh');
// });




    // function notificaciones (mensaje, tipo) {
    //  Command: toastr["success"]("Are you the six fingered man?")
    //  toastr.options = {
    //    "closeButton": false,
    //    "debug": false,
    //    "newestOnTop": false,
    //    "progressBar": false,
    //    "positionClass": "toast-top-right",
    //    "preventDuplicates": false,
    //    "onclick": null,
    //    "showDuration": "300",
    //    "hideDuration": "1000",
    //    "timeOut": "5000",
    //    "extendedTimeOut": "1000",
    //    "showEasing": "swing",
    //    "hideEasing": "linear",
    //    "showMethod": "fadeIn",
    //    "hideMethod": "fadeOut"
    //  }
    // }
