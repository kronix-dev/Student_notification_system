<?php
require_once 'dbnew.php';
class gui{
    public $role;
    function admin_dashboard(){
        ?>
<div class="row">
            <div class="col-sm">
                <div id="card">
                    <div class="text-center">
                        <h4>Welcome to UPAS!</h4>
                        <h3></h3>
                    </div>
                </div>
            </div>
            <div class>
            </div>
        </div>
            <?php
    }
    function atpo_dashboard(){
        ?>
<div class="row">
    <div class="col-sm">
        <div id="card">
            <div class="card-panel blue darken-3 white-text text-center">
                <h4>
                Welcome!</h4>
                <h3>4</h3>
            </div>
        </div>
    </div>
</div>
            <?php
    }
    function libraries(){
        ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo domain ?>/libs/bootstrap/css/bootstrap.min.css"/>    
    <link rel="stylesheet" href="<?php echo domain ?>/libs/materialize/css/materialize.min.css"/> 
    <link rel="stylesheet" href="<?php echo domain ?>/libs/material_icon/icons.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script type="text/javascript" src="<?php echo domain ?>/libs/jquery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo domain ?>/libs/materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="<?php echo domain ?>/libs/custom/main.js"></script>
    <link rel="stylesheet" href="<?php echo domain ?>/libs/leaflet/leaflet.css"/>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/> -->
    <!-- <link rel="stylesheet" href="https://gitcdn.link/repo/nickpeihl/leaflet-sidebar-v2/master/css/leaflet-sidebar.min.css"/> -->
    <link rel="stylesheet" href="<?php echo domain ?>/libs/custom/main.css"/>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
    <script type="text/javascript" src="<?php echo domain ?>/libs/leaflet/leaflet.js"></script>
    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js'></script> -->
    <!-- <script src='https://gitcdn.link/repo/nickpeihl/leaflet-sidebar-v2/master/js/leaflet-sidebar.min.js'></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
            <?php
    }
    function toast($msg){
        ?>
    <script>
        M.toast({html: "<?php echo $msg ?>", classes: 'rounded'});
    </script>
            <?php
    }
    function loader(){
        ?>
        <div id="loader" class="stylishLoader">
        <div class="loader">Loading...</div>
        </div>
        <?php
    }
    function simpleLoader(){
        ?>
        <div class="another">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
        <?php
    }
    function sidenav($navparams,$username,$email){
        
        ?>
<ul id="slide-out" class="sidenav noprint">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="../libs/img/flag.gif">
            </div>
            <a href="#user"><img class="circle white" src="../libs/img/coa.png"></a>
            <a href="#name"><span class="white-text name"><?php echo $username?></span></a>
            <a href="#email"><span class="white-text email"><?php echo $email ?></span></a>
        </div>
    </li>
    <?php 
            foreach ($navparams as $nav){
                ?>
    <li>
        
        <a href="#" class="waves-effect" id="<?php echo $nav[1]?>"><i class="material-icons"><?php echo $nav[2]?></i><?php echo $nav[0]?></a></li>
        <script type="text/javascript">
            $(function(){
               $("#<?php echo $nav[1]?>").on("click",function(){
                   
                   $.ajax({
                       url:'../libs/php/engine.php',
                       data: 'call=<?php echo $nav[1]?>',
                       method: 'post',
                       beforeSend:function(){
                           $("#load_txt").html("Please wait...");
                           sloader();
                       },
                       success:function(data){
                           comply(data);
                           csnav();
                           hloader();
                        },
                       error(){
                           csnav();
//                           hloader();
                           serror("Could not Complete your Request");
                       }
                   });
               }); 
            });
        </script>
                    <?php
            }
    ?>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Other Actions</a></li>
    <li>
        <a href="#" class="waves-effect" id="sett"><i class="material-icons">person</i>Profile</a></li>
        <script type="text/javascript">
            $(function(){
               $("#sett").on("click",function(){
                   
                   $.ajax({
                       url:'../libs/php/engine.php',
                       data: 'call=settings',
                       method: 'post',
                       beforeSend:function(){
                           $("#load_txt").html("Please wait...");
                           sloader();
                       },
                       success:function(data){
                           comply(data);
                           csnav();
                           hloader();
                       },
                       error(){
                           csnav();
//                           hloader();
                           serror("Could not Complete your Request");
                       }
                   });
               }); 
            });
        </script>
    <li><a class="waves-effect" href="../login/logout.php"><i class="material-icons">undo</i>Sign Out</a></li>
  </ul>
<div class="col s12 blue noprint">
    <div class="big-nav blue sidenav-trigger" data-target="slide-out"><a class=""><i class="material-icons">menu</i></a></div>
</div>
  
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  });

  $(document).ready(function(){
      $('.sidenav').sidenav();
    });</script>
            <?php
    }
    function errordiv(){
        ?>
<div class="fading-black fullwindow" id="error">
    <div class="center-top">
        <div class="col text-center s6">
            <div class="card-panel" id="error_m">
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    
    function addtpoform(){
        ?>
<div class="col-sm-4 offset-4">
    <div class="card-panel">
        <h3 class="text-center">Add Town Planner</h3>
        <form action="../libs/php/engine.php" id="aduserform" method="post">
    <div class="input-field">
      <i class="material-icons prefix">account_circle</i>
      <input id="fname" type="text" name="fname" required class="validate">
      <label for="fname">Full Name</label>
    </div>
    <div class="input-field">
      <i class="material-icons prefix">email</i>
      <input id="email" type="email" name="email" required class="validate">
      <label for="email">Email Address</label>
    </div>
    <div class="input-field">
      <i class="material-icons prefix">phone</i>
      <input id="phone" name="phone" type="tel" required class="validate">
      <label for="phone">Phone Number</label>
    </div>
    <div class="input-field">
        <i class="material-icons prefix">mode_edit</i>
        <input id="role" name="phone" type="tel" required class="validate" readonly value="Town Planner">
    </div>
    <script>
//        document.addEventListener('DOMContentLoaded', function() {
//            var elems = document.querySelectorAll('select');
//            var instances = M.FormSelect.init(elems);
//          });

          // Or with jQuery

          $(document).ready(function(){
            $('select').formSelect();
          });
    </script>
    <div class="input-field">
      <i class="material-icons prefix">account_circle</i>
      <input id="reg" type="text" required class="validate" name="reg"/>
      <label for="reg">Registration Number</label>
    </div>
    
    <div>
    <label>Gender</label>
    <p>
        <label>
            <input class="with-gap" name="gender" value="male" type="radio" checked />
          <span>Male</span>
        </label>
        <label>
            <input class="with-gap blue-text" value="female" name="gender" type="radio"/>
          <span>Female</span>
        </label>
      </p>
    </div>
    <input type="submit" name="adduser" value="Add User" class="btn blue"/>
        </form>
    </div>
</div>
<script>
    $(function(){
       $("#aduserform").on("submit",function(e){
          e.preventDefault();
          $.ajax({
             url: $(this).attr("action"),
             method: 'POST',
             data: $(this).serialize(),
             beforeSend:function(){
                 sloader();
             },
             success: function(data){
                 serror(data);
                 hloader();
             },
             error: function(){
                 serror("Error");
                 hloader();
             }
          });
       });
    });
</script>
        <?php
    }
    function table($heads,$body){
        ?>
<table class="table table-hover">
          <thead>
                <?php 
                echo tr;
                    foreach ($heads as $head){
                        echo th.$head.thc;
                    }
                echo trc;
                ?>
          </thead>
          <tbody>
              <?php
              foreach ($body as $data){
                  echo tr;
                  foreach($data as $d){
                      if(is_array($d)){
                          if($d[0]=="action"){
                              echo td;
                              $this->button($d);
                              echo tdc;
                          }
                      }
                      else{
                        echo td.$d.tdc;
                      }
                  }
                  echo trc;
              }
              ?>
          </tbody>
      </table>
            <?php
    }
    function button($case){
        ?><button type="button" class="btn blue waves-effect waves-light" id="<?php echo $case[0].$case[1]?>"><?php echo $case[2] ?></button>
            <script>
                $(function(){
                    $("#<?php echo $case[0].$case[1]?>").on("click",function(){
                        $.ajax({
                           url: "../libs/php/engine.php?id=<?php echo $case[1]?>",
                           type: "POST",
                           data: "req=<?php echo $case[3]?>",
                           beforeSend:function(){
                               sloader();
                           },
                           success:function(data){
                               comply(data);
                               hloader();
                           },
                           error:function(){
                               hloader();
                               serror("Could not Complete your request");
                           }
                        });
                    });
                });
            </script><?php
    }
    function modal($head,$body){
        ?>
            <div id="modal1" class="modal">
                <div class="modal-content">
                  <h4>User Details</h4>
                  <img class="circle white" src="../libs/img/<?php echo $body['profile'] ?>">
                  
                </div>
                <div class="modal-footer">
                  <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
                </div>
              </div>
            <script>
//                document.addEventListener('DOMContentLoaded', function() {
//                    var elems = document.querySelectorAll('.modal');
//                    var instances = M.Modal.init(elems, options);
//                });
//
//                // Or with jQuery

                $(document).ready(function(){
                $('#modal').modal();
                });
            </script>
            <?php
    }
    function view_user($arr){
        ?>
            <div class="col-md-6 offset-3">
                <div class="card-panel">
                    <div>
                        <center><img class="dp_profile_view z-depth-3" src="../libs/uploads/profile/<?php echo $arr['profile'] ?>"/></center>
                    </div>
                    <div>
                        <ul class="collection">
                            <li class="collection-item">Full name : <?php echo $arr['fname'] ?></li>
                            <li class="collection-item">Email Address : <?php echo $arr['email'] ?></li>
                            <li class="collection-item">Role : <?php echo $this->role_name($arr['role']) ?></li>
                            <li class="collection-item">Gender : <?php echo $arr['fname'] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
    }
    function role_name($role){
        if($role=="up"){
            $r="Urban Planner";
        }
        if($role=="hod"){
            $r="Head of Section District Level";
        }
        if($role=="rup"){
            $r="Regional Urban Planner";
        }
        if($role=="zup"){
            $r="Zonal Urban Planner";
        }
        if($role=="atpo"){
            $r="Authorized Town Planner";
        }
        if($role=="min"){
            $r="Ministry";
        }
        if($role=="admin"){
            $r="Administrator";
        }
        return $r;
    }
    function get_name($id){
        $auth= new auth();
        $con=$auth->opencon();
        $sel=$con->prepare("SELECT * FROM users WHERE id='$id'");
        $sel->execute();
        $d=$sel->fetch(PDO::FETCH_ASSOC);
        return $d['fname'];
    }
    function card($contents,$size,$color_class){
        ?>
            <div class="<?php echo $size?>">  
                <div class="card-panel <?php $color_class ?>">
               <?php if($contents[0]=="region_fom"){
                    // $this->addregion_form();
               }else if($contents[0]=="table"){
                   $this->table($contents[1][0], $contents[1][1]);
               }
               else if($contents[0]=="none"){
                   echo $contents[1];
               }
               ?>
                </div>
            </div>
            
        <?php
    }
    function select_input($name,$options,$elem,$label){
        ?>
<div class="input-field">
        <i class="material-icons prefix">mode_edit</i>
        <select required class="validate" name="<?php echo $name ?>">
          <option value="" disabled selected>Choose your option</option>
          <?php foreach($options as $option){
                echo "<option value='".$option[$elem[0]]."'>".$option[$elem[1]].optc;
          }
?>
        </select>
        <label><?php echo $label ?></label>
    </div>
<script>
    $(document).ready(function(){
            $('select').formSelect();
          });
</script>
            <?php
    }
    function uploadform($name){
        ?>
<form action="<?php echo engine?>" method="post" enctype="multipart/form-data">
    <input type="file" name="<?php $name ?>" id="<?php echo $name ?>" class="hiddendiv"/>
</form>
<script>
    $(function(){
        $("#<?php echo $name; ?>").on("change",fileUpload<?php echo $name ?>);
    });
    function fileUpload<?php echo $name ?>(event){
        files = event.target.files;
        //form data check the above bullet for what it is  
        var data = new FormData();                                   

        //file data is presented as an array
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if(file.size > 2004857600000000){
                //check file size (in bytes)
                $("#<?php echo $name?>label").html("Sorry, your file is too large (>20 MB)");
            }else{
                //append the uploadable file to FormData object
                data.append('<?php echo $name?>', file, file.name);

                //create a new XMLHttpRequest
                var xhr = new XMLHttpRequest();     

                //post file data for upload
                xhr.open('POST', '../libs/php/engine.php', true);  
                xhr.send(data);
                $("#<?php echo $name?>label").html('<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
                xhr.onload = function () {
                    //get response and show the uploading status
                    var response = JSON.parse(xhr.responseText);
                    if(xhr.status === 200 && response.status == 'ok'){
                        $("#<?php echo $name?>label").html("<i class='material-icons prefix' style='font-size:50px;color:green;'>check_circle</i>");
                    }else if(response.status == 'type_err'){
                        $("#<?php echo $name?>label").html("Please choose A DWG file. Click to upload another.");
                    }else if(response.status == 'invalid'){
                        $("#<?php echo $name?>label").html("Invalid File. Try Again");
                    }
                };
            }
        }
    }
</script>
        <?php
    }
    function uploadform_label($name,$placeholder){
        ?>
<label class="file_upload_label text-center text-darken-3 purple-text" for="<?php echo $name?>" id="<?php echo $name?>label">
    <div class=""><i class="material-icons prefix">attach_file</i><br/><?php echo $placeholder?></div>
</label>
            <?php
    }
    function tinput($id,$name,$placeholder,$extra,$icon,$type){
        ?>
    <div class="input-field">
      <i class="material-icons prefix"><?php echo $icon?></i>
      <input id="<?php echo $id ?>" type="<?php echo $type?>" name="<?php echo $name?>" <?php echo $extra ?> class="validate">
      <label for="<?php echo $id ?>"><?php echo $placeholder ?></label> 
    </div>
            <?php
    }
    function form_tracker($val){
        ?>
<input type="hidden" value="<?php echo $val ?>" name="tracker"/>
        <?php
    }
    function hinput($name){
        ?><input type="hidden" value="<?php echo $name?>" name="<?php echo $name?>"/><?php
    }
    function double_input($id,$valz,$names,$addmore,$sum,$stroke){
        ?>
        <div>
            <table class="table table-bordered table-striped" id="il<?php echo $id?>">
            <tbody>
                <tr>
                <?php
                    foreach($names as $name){
                        echo td.$name.tdc;
                    }
                ?>
                </tr>
                <tr id="sample">
                <?php
                $idno=0;
                $foro='';
                $scr='';
                $scr.='<script>$(function(){';
                $ix=0;
                foreach($valz as $val){
                        $foro.='<td><div class="input-field">';
                        ?>
                        <td style="border: 1px;">
                        <div class="input-field">
                        <?php
                            if($val[1]=="select"){
                                $foro.='<select name="'.$val[0].'[]" class="validate"><option disabled value="">'.$names[$ix].'</option>';
                                ?>

                                <select name="<?php echo $val[0]?>[]" class="validate">
                                    <option disabled><?php echo $names[$ix] ?></option>
                                    <?php
                                    foreach($val[2] as $o){
                                        $foro.='<option value="'.$o["id"].'">'.$o["name"].'</option>';
                                        ?>
                                        <option value="<?php echo $o["id"] ?>"><?php echo $o["name"] ?></option>
                                        <?php
                                    } 
                                    ?>
                                </select>
                                
                                <?php
                                $foro.="</select>";
                            }
                            else{
                                $foro.='<input name="'.$val[0].'[]" type="'.$val[1].'" class="validate '.$val[0].'_sum"/>';
                                echo "<input name='".$val[0]."[]' type='$val[1]' class='validate $val[0]_sum'/>";
                            }
                            // echo $foro;
                            $idno++;
                        $foro.='</td></div>';
                        $scr.='$(".'.$val[0].'_sum").on("change keyup",function(){var '.$val[0].'sum=0;$(".'.$val[0].'_sum").each(function(){'.$val[0].'sum+=parseFloat(this.value);});$("#'.$val[0].'_total").html('.$val[0].'sum);});';
                        ?>

                        </div>
                        </td>
                    <?php
                    $ix++;
                }
                $scr.='});</'."'+'".'script>';
                ?>
                </tr>
                </tbody>
                <?php
                if($sum){
                    ?>
                    <tfoot>
                        <tr>
                            <?php 
                            foreach($valz as $val){
                                ?>
                                <td id='<?php echo $val[0] ?>_total'>Total</td>
                                <?php
                            }
                            ?>
                        </tr>
                    </tfoot>
                    <script>
                    $(function(){
                        <?php
                        foreach($valz as $val){
                            if($val[1]=="number"){
                            ?>
                            $('.<?php echo $val[0] ?>_sum').on('keyup change',function(){
                                var sum=0;
                                $('.<?php echo $val[0] ?>_sum').each(function(){
                                    sum += parseFloat(this.value);
                                    // alert("asd");
                                });
                                $('#<?php echo $val[0]?>_total').html(sum);

                            });
                        <?php
                        }
                    }?>
                    });
                    </script>
                    <?php
                }
                ?>
            </table>
            <div class="rw">
                <!-- <br/> -->
                <button id="<?php echo $id?>btn" type="button" class="btn blue white-text">Add another entry</button>
                <br/><br/>
            </div>
        </div>
        <script>
        $(function(){
            $("#<?php echo $id ?>btn").on("click",function(){
                var sample='<?php echo $foro ?>';
                var sampleScript='<?php echo $scr?>';
                $("#il<?php echo $id?>").append('<tr>'+sample+sampleScript+'</tr>');

                $('select').formSelect();
            });
        });
        </script>
        <?php
    }
    function form_script($response){
        ?>
<script>
    $(document).ready(function(){
            $('select').formSelect();
          });
//    $('.selectpicker').selectpicker();
$(function(){
   $(".glass_form").on("submit",function(e){
       e.preventDefault();
       var formData = new FormData(this);
       $.ajax({
           url: '../libs/php/engine.php',
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
               $("#<?php echo $response ?>").html(data);
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
    function form_script_upas($response="app"){
        ?>
<script>
    $(document).ready(function(){
            // $('select').formSelect();
          });
//    $('.selectpicker').selectpicker();
$(function(){
   $(".glass_form").on("submit",function(e){
       e.preventDefault();
       var formData = new FormData(this);
       $.ajax({
           url: '../libs/php/engine.php',
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
               serror($("#<?php echo $response ?>").html(data));
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
    function colour_gen($i){
        $colors=[
            "#74c21b","#9e4400","#9e0000","#009e5f","#77009e",
            "#57009e","#00fff2","#fff200","#ff8c00","#ff0000",
            "#179187","#4e9117","#177991","#7a5d6a","#5d617a",
            "#5d7a68","#707a5d","#7a655d","#ff7575","#fff875",
            "#8cff75","#75ffb1","#75daff","#7587ff","#f475ff",
            "#ff7f7f","#a17fff","#7fc8ff","#551a61","#1a611f",
            "#614f1a","#611a1a","#8a7ca3","#86a37c","#33378c"
        ];
        return $colors[$i];
    }
    function select_input_b($name,$placeholder,$values,$extra,$id,$mode="old"){
        if($mode=="old"){
            $ov=0;
            $ov1=1;
        }
        else{
            $ov="id";
            $ov1="name";
        }
?>
<select name="<?php echo $name?>" id="<?php echo $id ?>" class="validate" <?php echo $extra?>>
        <option value="" disabled><?php echo $placeholder ?></option>
        <?php 
        foreach($values as $value){
            ?>
            <option value="<?php echo $value[$ov] ?>"><?php echo $value[$ov1] ?></option>
            <?php
        }
        ?>    
</select>
<script>
// // $(document).ready(function() {
//     $("",funtion(){

//     });
// $(function(){
    // $('.js-search').select2();
    // $('.select-wrapper').hide();
// });
// });
</script>
            <?php
    }
    function live_search_select_input($name,$placeholder,$values,$id,$response,$key){
        ?>
<div class="input-field">
    <select id="<?php echo $id ?>" class="validate" required>
        <option value=""><?php echo $placeholder ?></option>
        <?php 
        foreach($values as $value){
            ?>
            <option value="<?php echo $value[0] ?>"><?php echo $value[1] ?></option>
            <?php
        }
        ?>    
    </select>
    <script>
        $(function(){
           $("#<?php echo $id ?>").on("change",function(){
               var value= $("#<?php echo $id?>").val();
               $.ajax({
                  url: "../libs/php/engine.php",
                  method: "POST",
                  data: {"key" : "<?php echo $key?>",
                          "val": value},
                  beforeSend: function(){      
                      sloader();
                  },
                  success: function(data){
                      hloader();
                      $("#<?php echo $response ?>").html(data);
                  },
                  error: function(){
                      hloader();
                  }
               });
           });
        });
    </script>
</div>
            <?php
    }
    function regionName($id,$ty){
        require_once 'auth.php';
        $a=new auth();
        if($ty=="region"){
            $n=$a->select_tbl("region","*","id='$id'")[0]["name"];

        }
        elseif($ty=="land"){
            $n=$a->select_tbl("land_uses","*","id='$id'")[0]["name"];
        }
        else{
            $n=$a->select_tbl("councils","*","id='$id'")[0]["name"];
        }
        return $n;
    }
}
