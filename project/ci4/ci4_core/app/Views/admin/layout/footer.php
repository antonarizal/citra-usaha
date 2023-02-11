<footer class="main-footer" style="margin-top:20px">
    <!-- <strong>Copyright &copy; 2022-<?=date("Y")?> PT. Exrush Digital Nusantara.</strong> All rights reserved. <div
        class="float-right d-none d-sm-inline-block">
        <b>Version</b> 2.1.0-pre
    </div> -->
</footer>

<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
<script src="<?=base_url()?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<?php 
//include "modal.php";
?>
<script>
$.widget.bridge('uibutton', $.ui.button)

var base_url = '<?=base_url()?>';

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    let userLogin = getCookie("isLogin");
    let user_id = getCookie("user_id");
    if (userLogin == "true") {
        // alert("Welcome again " + user_id);
    } else {
        // window.location.replace(base_url+"/index.php/auth/login");
        // alert("Logout " + user_id);

    }
}
checkCookie()

function load(url, id) {
    $("#body").html("");
    $("#body").load(url);
    $(".nav-link").removeClass("active")
    $(".nav-link").removeClass("highlight")
    $("#nav_" + id).addClass("active")

    // $.get(url,function(resp){
    // $("#body").html(resp);
    // // console.log(url)
    // $(".nav-link").removeClass("active")
    // $(".nav-link").removeClass("highlight")
    // $("#nav_" + id).addClass("active")
    // })

}
//javascript get current url    
function getCurrentUrl() {
    var url = window.location.href;
    var url_array = url.split('/');
    var last_url = url_array[url_array.length - 1];
    return last_url;
}
if(getCurrentUrl() == "panel"){
    load(base_url+"/index.php/admin/dashboard", "dashboard")
}

</script>
<script src="<?=base_url()?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>/assets/js/adminlte.js"></script>

</body>

</html>