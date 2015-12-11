<?php echo $this->getContent(); ?>

<ul class="pager">
    <li class="previous">
        <?php echo $this->tag->linkTo(array('admin/group/list', '&larr; Go Back')); ?>
    </li>
    <li class="next">
        <?php echo $this->tag->linkTo(array('admin/register/index', '添加用户')); ?>
    </li>
</ul>
<h2>用户管理</h2>
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
        	<th>Id </th>
            <th>用户名 </th>
            <th>昵称</th>
            <th>手机号码</th>
            <th>用户头像</th>
            <th>添加时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
<?php if ($list) { ?>
   <?php foreach ($list as $user) { ?>
    <tbody>
        <tr>
            <td><?php echo $user['userId']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['nickname']; ?></td>
            <td><?php echo $user['mobile']; ?></td>
            <td><?php echo $user['userAvatar']; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $user['addTime']); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/user/role/?userId=' . $user['userId'], '<i class="glyphicon glyphicon-access"></i> 角色', 'class' => 'btn btn-default')); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/user/edit/?userId=' . $user['userId'], '<i class="glyphicon glyphicon-edit"></i> 编辑', 'class' => 'btn btn-default')); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/user/delete/?userId=' . $user['userId'], '<i class="glyphicon glyphicon-remove"></i> 删除', 'class' => 'btn btn-default')); ?></td>
        </tr>
    </tbody>
     <?php } ?>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                <?php echo $page; ?>
                </div>
            </td>
        </tr>
    </tbody>
   
<?php } else { ?>
    <tbody><tr><td colspan="7">没有数据</td></tr></tbody>
<?php } ?>
</table>
   
    
    

