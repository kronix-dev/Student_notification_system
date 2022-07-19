function sin_mult(str){
    if(str=="sin"){
        $('#stories').hide('fast');
        $('#multistore').hide('fast');
        $('#stories_pl').hide();
        structure_();
    }
    else{
        $('#stories').show('fast');
        $('#multistore').show('fast');
        $('#stories_pl').show('fast');
    }
}
$(function(){
   $("#use").on("change",function(){
      structure_();
      rating_();
   });
});
$("#multistore").hide();
$(function(){
   $("#stories").on("change",function(){
       var sr= Number($("#stories").val());
       var sx=Number($("#use").val());
    //   alert(sr);
       if(sr>3){
           $("#eia").show('fast');
       }
       else{
           $("#eia").hide('fast');
           rating_();
       }
   });
});
function mstatology(){
    var choice=document.forma.mstat.value;
    if(choice=="yes"){
        $("#planned").show('fast');
        $("#unplanned").hide('fast');
        $("#cs_up").show("fast");
    }
    else{
        $("#planned").hide('fast');
        $("#cs_up").hide("fast");
        $("#unplanned").show('fast');
    }
}
$(function(){
    $("#adcood").on("click",function(){
        var coodn =$("#codn").val();
        $("#coords").append('<div class="col-md-12">Coordinate #'+coodn+'</div><div class="row"><div class="col-md-6"><input class="form-control mb-2" type="text" name="lat[]" placeholder="X"/></div><div class="col-md-6"><input class="form-control mb-2" type="text" name="lon[]" placeholder="Y"/></div></div>');
        coodn++;
        $("#codn").val(coodn);
    });
});
$(function(){
    $("#clform").on("submit",function(e){
       e.preventDefault();
       var form = $('#clform')[0];
       var data = new FormData(form);
       $.ajax({
           url: $(this).attr("action"),
           type: 'POST',
           enctype: "multipart/form-data",
           data: data,
           processData: false,
           contentType: false,
           cache: false,
           timeout: 600000,
           beforeSend: function(){
               $("#loader").show();
           },
           success: function(data){
               $("#loader").hide();
               $("#response").html(data);
           },
           error: function(){
               $("#loader").hide();
               $("#error").show();
           }
       });
    });
});
$(function(){
    $("#bl_area").on("keyup",function(){
        var plintarea=Number($("#pl_area").val());
        var bl_area=Number($("#bl_area").val());
        var plotcov=bl_area*100/plintarea;
        var plrat=bl_area/plintarea;
        $("#pl_rat").val(plrat.toFixed(2));
        $("#bl_cov").val(plotcov.toFixed(2)+"%");
    });
});
$(function(){
    $("#pl_area").on("keyup",function(){
        var plintarea=Number($("#pl_area").val());
        var bl_area=Number($("#bl_area").val());
        var plotcov=plintarea*bl_area;
        var plrat=plotcov/100;
        $("#pl_rat").val(plrat);
        $("#bl_cov").val(plotcov);
    });
});