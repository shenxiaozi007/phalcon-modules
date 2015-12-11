<?php echo $this->getContent(); ?>

<ul class="pager">
    <li class="previous">
        <?php echo $this->tag->linkTo(array('admin/group/list', '&larr; Go Back')); ?>
    </li>
    <li class="next">
        <?php echo $this->tag->linkTo(array('admin/group/add', '添加用户组')); ?>
    </li>
</ul>
<h2>角色管理</h2>
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
        	<th>Id </th>
            <th>上级Id </th>
            <th>管理组名</th>
            <th>状态</th>
            <th>组描述</th>
            <th>添加时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
<?php if ($list) { ?>
   <?php foreach ($list as $group) { ?>
    <tbody>
        <tr>
            <td><?php echo $group['groupId']; ?></td>
            <td><?php echo $group['parentId']; ?></td>
            <td><?php echo $group['groupName']; ?></td>
            <td><?php echo $group['status']; ?></td>
            <td><?php echo $group['describe']; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $group['modifyTime']); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/group/access/?groupId=' . $group['groupId'], '<i class="glyphicon glyphicon-edit"></i> 授权', 'class' => 'btn btn-default')); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/group/edit/?groupId=' . $group['groupId'], '<i class="glyphicon glyphicon-edit"></i> 编辑', 'class' => 'btn btn-default')); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/group/delete/?groupId=' . $group['groupId'], '<i class="glyphicon glyphicon-remove"></i> 删除', 'class' => 'btn btn-default')); ?></td>
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
   
    
    

