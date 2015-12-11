<nav class="navbar navbar-default navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
    <nav>
    
    <ul class="pager">
	    
	    
    	<?php if ($this->session->get('userInfo')) { ?>
    		<li><?php echo $this->tag->linkto('admin/user/list', '用户管理'); ?></li>
	    	<li><?php echo $this->tag->linkto('admin/group/list', '角色管理'); ?></li>
	    	<li><?php echo $this->tag->linkto('admin/resource/list', '资源管理'); ?></li>
	    	<li><?php echo $this->tag->linkto('admin/plate/index', '市场管理'); ?></li>
	    	<li><?php echo $this->tag->linkto('admin/managetype/index', '检查类型管理'); ?></li>
    		<li><?php echo $this->tag->linkto('admin/login/out', '退出'); ?></li>
    	<?php } else { ?>
    		<li><?php echo $this->tag->linkto('admin/login/index', '登陆'); ?></li>
    		<li><?php echo $this->tag->linkto('admin/register/index', '注册'); ?></li>
    	<?php } ?>
    </ul>

</nav>
</nav>

<div class="container">
    <?php echo $this->flash->output(); ?>
    <?php echo $this->getContent(); ?>
    <hr>
    <footer>
        <p>&copy; fuck you 2015</p>
    </footer>
</div>
