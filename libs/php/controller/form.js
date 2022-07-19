var legacyData=null;
var legName='';
var legIn=null;
function createInput(input){
    var res;
    console.log
    switch(input.type){
        case 'text':
            res='<div class="col-md-4"><div class="form-group mb-4"><label class="col-md-12 p-0">'+input.placeholder+'</label><div class="col-md-12 border-bottom p-0"><input type="'+input.type+'" id="'+input.code+'" placeholder="'+input.placeholder+'" name="'+input.name+'"  class="form-control p-0"></div></div></div>';
            break;
        case 'select':
            var name = 'ui_sel'+Math.floor(Math.random() * (123-0 ) + 123);
            input.code=name;
            res=loadSelect(input);
            break;
        case 'option':
            res='';
            break;
        case 'email':
            res='<div class="col-md-4"><div class="form-group mb-4"><label class="col-md-12 p-0">'+input.placeholder+'</label><div class="col-md-12 border-bottom p-0"><input type="'+input.type+'" id="'+input.code+'" placeholder="'+input.placeholder+'" name="'+input.name+'" class="form-control p-0 border-0"></div></div></div>';
            break;
        case 'radio':
            res='';
            break;
        case 'db':
            console.log("sadsda");
            apiCall({
                'argument':input.table,
            },loadSelect);
            res='';
            break;
        default:
            break;
    }
    return res;
}
function loadSelect(data){
    var input =legIn;
    var option = Option({value:'',label:'Choose' + input.placeholder});
    console.log(input)
    if(input.type==="db"){
        console.log(data);
        for(var i=0;i<data.length;i++){
            option=option + Option({value:data[i].id,label:data[i].name });
        }
    }
    else{
        for(var i=0;i<input.options.length;i++){
            option=option+Option({value:input.option[i],label:input.option[i]});
        }
    }
    $("#"+legName).append('<select onchange="'+input.onchange+'" name="'+input.name+'" class="form-control">'+option+'</select>');
}
function Option(o){
    return '<option value="'+o.value+'">'+o.label+'</option>';
}
function buildForm(data){
    data=JSON.parse(data);
    $('#form').append('<form class="glass_form"></form>');
    for(var i=0;i<data.block.length;i++){
        var header = '<h4><b>'+data.block[i].name+'</b></h4>';
        $('.glass_form').append(header);
        var name = 'ui'+Math.floor(Math.random() * (123-0 ) + 123);
        legName= name;
        $('.glass_form').append('<div id="'+name+'" class="row"></div>')
        for(var u=0;u<data.block[i].inputs.length;u++){
            legIn=data.block[i].inputs[u];
            $("#"+name).append(createInput(data.block[i].inputs[u]));
        }
    }
}
function clearForm(){
    $('#form').html('<p></p>');
}
function sloader(){
    // setTimeout(function(){
        $("#loader").show();
    // },3000);
}
function hloader(){
    setTimeout(function(){
        $("#loader").hide();
    },2000);
}
function csnav(){
    var elems = document.querySelectorAll('.sidenav');
    var options ={
        edge: 'left',
        draggable: true,
        inDuration: 1400,
        outDuration: 2000,
        onOpenStart: null,
        onOpenEnd: null,
        onCloseStart: null,
        onCloseEnd: null,
        preventScrolling: true
    };
    var instances = M.Sidenav.init(elems);
    $(document).ready(function(){
        $(".sidenav").sidenav();
    });
}
function comply(data){
    $("#app").html(data);
}
function serror(string){
    var obj = jQuery.parseJSON(string);
//    alert( obj.name === "John" );
     M.toast({html: obj.message, classes: 'rounded'});
     $("#response").html("<script>"+obj.sresponse+"</scrip"+"t>");
}
function error(str){
    M.toast({html: str, classes: 'rounded'});
}
$(function(){
    $("#error").on("click",function(){
        $("#error").hide();
    });
});
function load_page(key,val){ 
    var domcon;
    $.ajax({
       url: '../libs/php/engine.php',
       method: 'POST',
       data: {'key':key,'val':val},
       beforeSend: function(){
           sloader();
       },
       success: function(data){
           $("#app").html(data);
           domcon=data;
           hloader();
       },
       error: function(){
           hloader();
       }
    });
    return domcon;
}
function loadToDiv(key,val,dom){
    $.ajax({
       url: '../libs/php/engine.php',
       method: 'POST',
       data: {'key':key,'val':val},
       beforeSend: function(){
           sloader();
       },
       success: function(data){
           $("#"+dom).html(data);
           hloader();
       },
       error: function(){
           hloader();
       }
    });
}
async function apiCall(params,funv){
    var response;
    var baseURl='http://localhost/bpmis/';
    $.ajax({
        url: baseURl+'engine.php',
        method:'POST',
        data:params,
        beforeSend: function(){
            sloader()
        },
        success: function(data){
            legacyData=data;
            response=data;
            funv(data)
            hloader();
        }
    })
    return response;
}
function loadDistrict(){
    
}
