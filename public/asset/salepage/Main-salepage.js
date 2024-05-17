(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=400094016838103";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

  window.___gcfg = {lang: 'vi'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  
  function dn()
{
    var TK = document.getElementById("txtTK").value;
    if(TK=='Email của bạn')
    {
        alert('Vui lòng nhập tài khoản');
        document.getElementById("txtTK").focus(); return;
    }    
    var MK = document.getElementById("txtMK").value;    
    if(MK=='Mật khẩu')
    {
        alert('Vui lòng nhập mật khẩu');
        document.getElementById("txtMK").focus(); return;
    }
    window.location.href="Login.aspx?tk="+TK+"&MK="+MK;
}
function disableEnterKey(e) 
{ 
 try {
    var key; 
     if(window.event) 
          key = window.event.keyCode;     //IE 
     else 
          key = e.which;     //firefox 
     if(key == 13) 
        dn();
    }
    catch (e) {}
} 
function timkiem()
{
    try {    
        var TuKhoa = document.getElementById("txtTuKhoa").value;
        if(TuKhoa=='Nhập từ khóa' || TuKhoa=='')
        {
            alert('Vui lòng nhập từ khóa tìm kiếm');
            document.getElementById("txtTuKhoa").focus(); return;
        }     
        window.location.href="Search.aspx?tk="+TuKhoa;        
     }
    catch (e) {} 
}
function disableEnterKey1(e) 
{ 
   try {
         var key; 
         if(window.event) 
              key = window.event.keyCode;     //IE 
         else 
              key = e.which;     //firefox 
         if(key == 13) 
            timkiem();
            else return;
           }
    catch (e) {}   
} 

ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})