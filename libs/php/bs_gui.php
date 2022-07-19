<?php
class gui {
    //CHECK IF INPUT IS EMPTY AND DISPLAY BOOTSTRAP ALERT MESSAGE
    function check_empty_error($var,$msg){
        if(empty($var)){
//            echo "<div class='alert alert-danger'>".$msg."</div>";
            $this->toast_($msg, "danger");
        }
    }
    //A SCRIPT TO SUBMIT ALL FORMS VIA JAVASCRIPT
    function form_script($url="engine.php"){
        ?>
<script>
$(function(){
    $(".select2").select2();
   $(".glass_form").on("submit",function(e){
       e.preventDefault();
       var formData = new FormData(this);
       $.ajax({
           url: '<?php echo $url ?>',
           method: 'POST',
           data:formData,
           cache: false,
           enctype: 'multipart/form-data',
           contentType: false,
           processData: false,
           beforeSend: function(){
               sloader();
           },
           success: function(data){
               hloader();
               $("#applet").html(data);
           },
           error: function(){
               hloader();
           }
            
       });
   }); 
});
</script>
            <?php
    }
    //A SCRIPT TO CALCULATE PRICE OF A INVOICE INSERTED
    function invoice_form_script(){
      ?>
<script type="text/javascript">
    $(function(){
        $("#price, #quantity").on("keyup",function(){
//            alert("");
            var price = Number($("#price").val());
            var quantity = Number($("#quantity").val());
            var total = price*quantity;
            $("#total").val(total);
        });
    });
</script>
          <?php  
    }
    //Toat Message With A Button
    function toast_button($msg,$status,$btn){
        $x="";
        ?>
<script>
    new Toast({
        message: '<?php echo $msg ?>',
        type: '<?php echo $status ?>',
        customButtons: [
    <?php 
            foreach ($btn as $b){
                $x.=",{text:'".$b[0]."',onClick: function() {".$b[1]."}}";
            }
            $x= substr($x, 1);
            echo $x;
    ?>
        ]
    });
</script>
            <?php
    }
    //ClEAR FORM
    function clear_form(){
        ?>
<script>
    $('.glass_form')[0].reset();
</script>
            <?php
    }
    function close_modal(){
        ?><script>
            setTimeout(function(){
                $(".modal").modal("hide");
                $(".modal-backdrop").hide();
            },2000);
            
        </script><?php
    }
    function toast_($msg,$color){
        ?>
        <script>
            new Toast({
                message: '<?php echo $msg ?>',
                type: '<?php echo $color ?>'
              });
        </script>
            <?php
    }
    function load_page($str,$ref){
        ?>
        <script>
            $("#<?php echo $ref?>").html('<?php echo $str?>');
        </script>
        
            <?php
    }
    function close_tab(){
        ?>
        <script>
            window.close();
        </script>
            <?php
    }
    function open_modal($modal_Id){
        ?>
        <script>
       $("#<?php echo $modal_Id?>").modal("show");
        </script>
    <?php }
    function page_refresh(){
        ?>
        <script>
            location.reload();
       </script>
        <?php
    }
    function colour_gen($i){
        $colors=[
            
            "#57009e","#ff0000","#00fff2","#fff200","#ff8c00",
            "#74c21b","#9e4400","#9e0000","#009e5f","#77009e",
            "#179187","#4e9117","#177991","#7a5d6a","#5d617a",
            "#5d7a68","#707a5d","#7a655d","#ff7575","#fff875",
            "#8cff75","#75ffb1","#75daff","#7587ff","#f475ff",
            "#ff7f7f","#a17fff","#7fc8ff","#551a61","#1a611f",
            "#614f1a","#611a1a","#8a7ca3","#86a37c","#33378c"
        ];
        return $colors[$i];
    }
    function pickaday_date_factor($date){
        $ad= explode(" ", $date);
        $ret="";
        switch($ad[1]){
            case 'Jan':$ret="91";break;
            case 'Feb':$ret="02";break;
            case 'Mar':$ret="3";break;
            case "Apr":$ret="4";break;
            case "May":$ret="5";break;
            case "Jun":$ret="6";break;
            case "Jul":$ret="7";break;
            case "Aug":$ret="8";break;
            case "Sep":$ret="9";break;
            case "Oct":$ret="10";break;
            case "Nov":$ret="11";break;
            case "Dec":$ret="12";break;
            default : $ret="unknown";break;
        }
        $ret=$ad[2]."-".$ret."-".$ad[3];
        return $ret;
    }
    function ret_timestampdate_pickaday($d){
        $ad= explode("-", $d);
        return $ad[2].$ad[1].$ad[0];
    }
    function textField($name,$holder,$type,$size,$extras=null,$value=null,$format=0){
        if($type=="textarea"){
        ?>
       <div class="col-<?php echo $size ?> mb-3">
            <!--<i><?php echo $holder ?></i>-->
            <textarea class="form-control" rows="10" <?php echo $extras ?> placeholder="<?php echo $holder ?>" name="<?php echo $name ?>"></textarea>
        </div>
        
        <?php        
        }
        else if($type=="date"){
                 ?>
        <div class="col-<?php echo $size ?> mb-3">
            <i><?php echo $holder ?></i>
            <input type="<?php echo "text" ?>" class="form-control date" <?php echo $extras ?> placeholder="<?php echo $holder ?>" name="<?php echo $name ?>" value="<?php echo $value ?>"/>
        </div>
       <script>
            $(".date").datepicker({
                    minDate: new Date(),
                    format: 'dd-mm-yyyy'
                });
       </script>
                <?php
        }
        else{
            ?>
        <div class="col-<?php echo $size ?> mb-3">
            <i><?php echo $holder ?></i>
            <input type="<?php echo $type ?>" class="form-control" <?php echo $extras ?> placeholder="<?php echo $holder ?>" name="<?php echo $name ?>" value="<?php echo $value ?>"/>
        </div>
                <?php
        }
    }
}
