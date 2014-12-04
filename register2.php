
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <link rel="stylesheet" type="text/css" href="css/selectik.css" />
        <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.selectik.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2-min.js"></script>
<script type="text/javascript" src="js/jquery.Jcrop.js"></script>
        <style>
  .thumb {
/*    height: 280px;*/
    border: 1px solid #000;
/*    margin: 10px 5px 0 0;*/
  }
a{text-decoration :none ;}  
.btn_addPic{  
display: block;  
position: relative;  
width: 21px;  
height: 21px;  
overflow: hidden;   
/*background: none repeat scroll 0 0  #dcdcdc;  */
cursor: pointer;  
text-align: center;  
}  
.btn_addPic span{display: block;line-height: 39px;} 
.btn_addPic img{
    
}
.btn_addPic :hover  em{background-position:-19px 0;}  
.filePrew {  
/*display: block;  */
position: absolute;  
top: -50px;  
left: 0;  
width: 21px;  
height:300px;  
opacity: 0; /* 實現的關鍵點 */  
filter :alpha (opacity=0);/*兼容IE */  
}  
</style>

<style type="text/css">
.crop_preview{position:absolute; left:0px; top:0; width:220px; height:220px; overflow:hidden;}
</style>
    </head>
    <body>
        
        
        <div id="main">
            <a href="http://localhost/V1/home.php"><img class="logo" src="image/logo.png"></a>
            <img class="register_bg" src="image/register_bg.png">
           
            
            <img class="register_icon1" src="image/register_icon_gray.png">
            <img class="register_icon2" src="image/register_icon_normal.png">
            <img class="register_icon3" src="image/register_icon_gray.png">
            <div id="register_step1" style="color: #dcdcdc;">填寫基本資料</div>
            <div id="register_step2" style="color: #000000;">上傳照片</div>
            <div id="register_step3" style="color: #dcdcdc;">完成認證</div>
            <div id="register_no1">1</div>
            <div id="register_no2">2</div>
            <div id="register_no3">3</div>
            
            <div id="register_text1">建立您的男女配不PAY帳號，請依照以下1.2.3.步驟完成。</div>
            <div id="register_text2">學校認證信箱主要目的為確認學生身分，往後配對通知均以帳號信箱為主發送通知。</div>
            
<!--            <form name="myform" enctype="multipart/form-data">
                <div id="register_icon_pic">
                    
                    <a  class = "btn_addPic"  href= "javascript:void(0);" >
                        <span><img src="image/register_icon_pic.png"></span> 
                        <input  class = "filePrew" type= "file" id="files" name="image" multiple >
                    </a>
                </div>
            </form> -->

<form  enctype="multipart/form-data" method="post" action="upload.php?user_account=<?php echo $_GET['user_account'];?>">
        <a  id="register_icon_pic" class = "btn_addPic"  href= "javascript:void(0);" >
        <span><img src="image/register_icon_pic.png"></span> 
         <input class = "filePrew" type="file" id="files" name="image" />
        </a>
        <input type="hidden" id="pic_w" name="pic_w" />
        <input type="hidden" id="pic_h" name="pic_h" />
        <input type="hidden" id="pic_ml" name="pic_ml" />
        <input type="hidden" id="pic_mt" name="pic_mt" />

        <input type="hidden" id="user_account" name="user_account" value="101010"/>
        <div id="register_finish">
            <input type="image"img src="image/register_finish.png" onClick="document.this.submit();">
        </div>
</form>




           <div id="big_photo">
           <div id="list"></div> 
           </div>
           
           <div id="small_photo">
           <span id="preview_box" class="crop_preview"></span>
           </div>
            
<div id="t1"></div>
<div id="t2"></div>
<div id="t3"></div>
<div id="t4"></div>
            
           

          

<!--
<a id="finish_button" style="cursor:pointer">
    <img id="register_finish" src="image/register_finish.png">
</a>-->
            
          
        </div>      
            
          <div id="msg"></div>
          
         <script language="JavaScript">
             
  
    
  function handleFileSelect(evt) {
    
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }
      

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          
         
        
          
                       
          var bigphoto = document.createElement('img');
          bigphoto.id = 'xuwanting';
 
          
//          photo_buffer = e.target.result;
                            
          
          bigphoto.src = e.target.result,
                            '" title="', escape(theFile.name);   
          bigphoto.setAttribute('class','big');
          document.getElementById('list').insertBefore(bigphoto, null);
          
          
          
          var smallphoto = document.createElement('img');
          smallphoto.id = 'crop_preview';
          smallphoto.src = e.target.result,
                            '" title="', escape(theFile.name);
         document.getElementById('preview_box').insertBefore(smallphoto, null);
         
         
          
         
          $("#xuwanting").Jcrop({
			onChange:showCoords,
			onSelect:showCoords,
			aspectRatio:1
		});	
		//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
		function showCoords(obj){
//			$("#x").val(obj.x);
//			$("#y").val(obj.y);
//			$("#w").val(obj.w);
//			$("#h").val(obj.h);
                        
                        
			if(parseInt(obj.w) > 0){
				//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
				var rx = $("#preview_box").width() / obj.w; 
				var ry = $("#preview_box").height() / obj.h;
				//通过比例值控制图片的样式与显示
				$("#crop_preview").css({
					width:Math.round(rx * $("#xuwanting").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(rx * $("#xuwanting").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
					marginLeft:"-" + Math.round(rx * obj.x) + "px",
					marginTop:"-" + Math.round(ry * obj.y) + "px"
				});
                                $("#pic_w").val(Math.round(rx * $("#xuwanting").width()));
                                $("#pic_h").val(Math.round(rx * $("#xuwanting").height()));
                                $("#pic_ml").val(Math.round(rx * obj.x));
                                $("#pic_mt").val(Math.round(ry * obj.y));
                             
                                
			}
		}

                $("#crop_submit").click(function(){
			if(parseInt($("#x").val())){
				$("#crop_form").submit();	
			}else{
				alert("要先在图片上划一个选区再单击确认剪裁的按钮哦！");	
			}
		});
          
          
          
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }
  

  document.getElementById('files').addEventListener('change', handleFileSelect, false);
  
  
  window.history.forward(1);    //防止回上頁
</script>

    </body>
</html>