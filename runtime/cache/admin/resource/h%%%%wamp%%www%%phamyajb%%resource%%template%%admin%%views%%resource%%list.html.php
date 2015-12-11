<?php echo $this->getContent(); ?>

<ul class="pager">
    <li class="previous">
        <?php echo $this->tag->linkTo(array('admin/resource/list', '&larr; Go Back')); ?>
    </li>
    <li class="next">
        <?php echo $this->tag->linkTo(array('admin/resource/add/?level=' . $level . '&resourceId=' . $resourceId, '添加资源')); ?>
    </li>
</ul>
<h2>资源管理</h2>
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
        	<th>Id </th>
            <th>标识 </th>
            <th>描述</th>
            <th>排序</th>
            <th>状态</th>
            <th>添加时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
<?php if ($list) { ?>
   <?php foreach ($list as $resource) { ?>
    <tbody>
        <tr>
            <td><?php echo $resource['resourceId']; ?></td>
            <td><?php echo $resource['resourceName']; ?></td>
            <td><?php echo $resource['describe']; ?> <!--<?php echo $resource['level']; ?>--> <!--<?php echo $resource['parentId']; ?>--></td>
            <td><?php echo $resource['sort']; ?></td>
            <td><?php echo $resource['status']; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $resource['modifyTime']); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/resource/list/?level=' . $resource['level'] . '&resourceId=' . $resource['resourceId'], '<i class="glyphicon glyphicon-edit"></i> 子类', 'class' => 'btn btn-default')); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/resource/edit/?resourceId=' . $resource['resourceId'], '<i class="glyphicon glyphicon-edit"></i> 编辑', 'class' => 'btn btn-default')); ?></td>
            <td width="7%"><?php echo $this->tag->linkTo(array('admin/resource/delete/?resourceId=' . $resource['resourceId'], '<i class="glyphicon glyphicon-remove"></i> 删除', 'class' => 'btn btn-default')); ?></td>
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
   
    
    

