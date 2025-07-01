<style>
#custom-bootstrap-menu.navbar-default .navbar-brand {
    color: rgba(255, 255, 255, 1);
}
#custom-bootstrap-menu.navbar-default {
    font-size: 14px;
    background-color: #df172e;
    border-width: 1px;
    border-radius: 4px;
}
#custom-bootstrap-menu.navbar-default .navbar-nav>li>a {
    color: rgba(250, 250, 250, 1);
    background-color: #df172e;
}
#custom-bootstrap-menu.navbar-default .navbar-nav>li>a:hover,
#custom-bootstrap-menu.navbar-default .navbar-nav>li>a:focus {
    color: rgba(224, 143, 153, 1);
    background-color: rgba(248, 248, 248, 0);
}
#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a,
#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a:hover,
#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a:focus {
    color: rgba(255, 255, 255, 1);
    background-color: #9c0012;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle {
    border-color: #c20017;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle:hover,
#custom-bootstrap-menu.navbar-default .navbar-toggle:focus {
    background-color: #c20017;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle .icon-bar {
    background-color: #c20017;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle:hover .icon-bar,
#custom-bootstrap-menu.navbar-default .navbar-toggle:focus .icon-bar {
    background-color: #c74152;
}
.a_delete_user {
    background-color: #000000 !important;
}
a.ban_user {
    background-color: #fbff00 !important;
    color: #000000 !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <nav id="custom-bootstrap-menu" class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header" style="margin-right: 15px;">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">PELAJAR</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li <?php if($page == ""){ echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>users/admin_view_student_detail/?u=<?php echo $user_detail['uacc_id']; ?>">Dashboard <span class="sr-only">(current)</span></a></li>
                        <li <?php if($page == "user_profile"){ echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>users/admin_view_student_detail/?u=<?php echo $user_detail['uacc_id']; ?>&page=user_profile">Profile</a></li>
                        
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</div>