function sloader() {
    $("#loader").show("fade");
}

function hloader() {
    $("#loader").hide("fade");
    $(".modal-backdrop").hide();
}

function csnav() {
    var elems = document.querySelectorAll('.sidenav');
    var options = {
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
    $(document).ready(function () {
        $(".sidenav").sidenav();
    });
}

function comply(data) {
    $("#app").html(data);
}

function serror(string) {
    var obj = jQuery.parseJSON(string);
    //    alert( obj.name === "John" );
    M.toast({
        html: obj.message,
        classes: 'rounded'
    });
    $("#response").html("<script>" + obj.sresponse + "</scrip" + "t>");
}

function error(str) {
    M.toast({
        html: str,
        classes: 'rounded'
    });
}
$(function () {
    $("#error").on("click", function () {
        $("#error").hide();
    });
});

function load_page(key, val) {
    $.ajax({
        url: 'engine.php',
        method: 'POST',
        data: {
            'key': key,
            'val': val
        },
        beforeSend: function () {
            sloader();
        },
        success: function (data) {
            $("#app").html(data);
            hloader();
        },
        error: function () {
            hloader();
        }
    });
}

function loadToDiv(key, val, dom) {
    $.ajax({
        url: 'engine.php',
        method: 'POST',
        data: {
            'key': key,
            'val': val
        },
        beforeSend: function () {
            sloader();
        },
        success: function (data) {
            $("#"+dom).html(data);
            hloader();
        },
        error: function () {
            hloader();
        }
    });
}