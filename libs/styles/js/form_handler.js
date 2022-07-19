function err_fill(){
    alert("Please fill all mandatory fields");
}
$(function () {
    $("#vercod").on("click", function (e) {
        var x=[],y=[];
        $('input[name^="lon"]').each(function() {
//             alert($(this).val());
             x.push($(this).val());  
         });
        $('input[name^="lat"]').each(function() {
//            alert($(this).val());
            y.push($(this).val());
        });
        data = {'lon':x,'lat':y};
        $.ajax({
            url: 'coordinate_verifier.php',
            data: data,
            type: 'POST',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                $("#loader").hide();
                $("#response").html(data);
            },
            error: function () {
                alert("An error Occured while processing your request, try again!");  
            }
        });
    });
    $("#step1").on("click",function(){
        var cname = document.forma.cname.value;
        var cphone= document.forma.cphone.value;
        var caddr=document.forma.caddr.value;
        if(cname!="" && cphone!="" && caddr!=""){
            $("#stp1").hide("fast");
            $("#stp2").show("fast");
        }
        else{
            err_fill();
        }
    });
    $("#step2").on("click",function(){
        var area = document.forma.area.value;
        var plstat= document.forma.mstat.value;
        var plot=document.forma.plot.value;
        var block=document.forma.block.value;
        if(plstat=="yes"){
            if(plot!="" && area!="" && block!=""){
                $("#stp3").show("fast");
                $("#stp2").hide("fast");
            }
            else{
                err_fill();
            }
        }
        else{
            $("#stp3").show("fast");
            $("#stp2").hide("fast");
        }
    });
    $("#step3").on("click",function(){
        var pl_a=document.forma.plinth_area.value;
        var bl_a=document.forma.built_area.value;
        var blc=document.forma.built_coverage.value;
        var pl_rat=document.forma.plot_ratio.value;
        var fset=document.forma.fset.value;
        var rset=document.forma.rearset.value;
        var lset=document.forma.lset.value;
        var rhs=document.forma.rset.value;
        if(pl_a!="" && bl_a!="" && blc!="" && pl_rat!="" && fset!=""
        && rset!="" && lset!="" && rhs!=""){
            $("#stp4").show("fast");
            $("#stp3").hide("fast");
        }
    });
    $("#step4").on("click",function(){
        $("#stp5").show("fast");
        $("#stp4").hide("fast");
    });
});

function onEachFeature(feature, layer) {
    var popupContent = "<p>I started out as a GeoJSON " + feature.type;
    // feature.geometry.type + ", but now I'm a Leaflet vector!</p>"+
    // feature.properties.name;

    if (feature.properties && feature.properties.popupContent) {
        popupContent += feature.properties.popupContent;
    }

    layer.bindPopup(popupContent);
}

function onEachFeature(feature, layer) {
    var popupContent = feature.properties.name;

    if (feature.properties && feature.properties.popupContent) {
        popupContent += feature.properties.popupContent;
    }

    layer.bindPopup(popupContent);
}
function drawmap(amp) {
    var map = L.map('map').setView([-4, 34.183690220894121], 5);
    var baseballIcon = L.icon({
        iconUrl: 'baseball-marker.png',
        iconSize: [32, 37],
        iconAnchor: [-4, 34.183690220894121],
        popupAnchor: [0, -28]
    });

    L.geoJSON([amp], {
        style: function (feature) {
            var myStyle = {
                "color": "#10D337",
                radius: 8,
                "weight": 1,
                "opacity": 0.95,
                "fillColor": "#2797F5",
            };
            return myStyle;
        },

        onEachFeature: onEachFeature,

        pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, {
                radius: 8,
                fillColor: "#ff7800",
                color: "#000",
                weight: 1,
                opacity: 1,
                fillOpacity: 0.8
            });
        }
    }).addTo(map);
}
