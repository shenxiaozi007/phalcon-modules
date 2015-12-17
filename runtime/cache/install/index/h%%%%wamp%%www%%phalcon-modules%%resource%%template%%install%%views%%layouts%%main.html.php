<div class="header">
	<div class="fl logo"></div>
	
	<div class="fr">
		<ul class="top_nav fr">
			<li>
				<a target="_blank" href="">官网</a>
			</li>
			<h2>欢迎使用砖头工通用后台</h2>
		</ul>
	</div>
</div>
<div class="content">
    <?php echo $this->flash->output(); ?>
	<div class="content_left">
		<h1>安装向导</h1>
		<ul class="step_l">
			<li <?php if ($style == 'index') { ?>class="curr" <?php } ?>>
				<span>1</span>
				<a>阅读许可协议</a>
			</li>
			<li <?php if ($style == 'check') { ?>class="curr" <?php } ?>>
				<span>2</span>
				<a>服务器检测</a>
			</li>
			<li <?php if ($style == 'start') { ?>class="curr" <?php } ?>>
				<span>3</span>
				<a>填写初始配置</a>
			</li>
			<li <?php if ($style == 'install') { ?>class="curr" <?php } ?>>
				<span>4</span>
				<a>详细安装进程</a>
			</li>
			
			<li <?php if ($style == 'finish') { ?>class="curr" <?php } ?>>
				<span>5</span>
				<a>安装完成</a>
			</li>
		</ul>
	</div>
	<div class="content_right">
		<?php echo $this->getContent(); ?>
	</div>
</div>