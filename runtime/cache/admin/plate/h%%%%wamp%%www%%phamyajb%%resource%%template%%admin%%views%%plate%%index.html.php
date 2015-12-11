<div>
  <button onclick="location.href='/admin/plate/add'">添加</button>
</div>

<table class="table table-striped">
<thead>
    <tr>
      <td>ID</td>
      <td>名称</td>
      <td>类型</td>
      <td>操作</td>
    </tr>
</thead>
<tbody>
 <?php foreach ($data as $item) { ?>
     <tr>
        <td><?php echo $item['plateId']; ?></td>
        <td><a href="/admin/plate/index?plateId=<?php echo $item['plateId']; ?>"><?php echo $item['plateName']; ?></a></td>
        <td><?php if ($item['plateType'] == 1) { ?> 版块 <?php } else { ?> 市场 <?php } ?></td>
        <td>
          <a href="/admin/plate/edit?plateId=<?php echo $item['plateId']; ?>">编辑</a>
          <a href="/admin/plate/delete?plateId=<?php echo $item['plateId']; ?>">删除</a>
        </td>
     </tr>
  <?php } ?>
</tbody>
</table>
     <div class="btn-group">
                <?php echo $page; ?>
       </div>