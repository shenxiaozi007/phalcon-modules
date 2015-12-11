<script>
 function add_type(){
	 $.get("/admin/manageType/add", function(res){
		 if(res.code==1){
			 $("#form").show();
		 }
	 },"json");
 }
 
 function close_div(){
	 $("#form").hide();
 }
 
 function edit_type(id){
	 $.get("/admin/manageType/edit?id="+id,function(res){
		 if(res.code==1){
			 var data=res.data;
			 $("input[name=typeName]").val(data.typeName);
			 $("input[type=hidden]").val(id);
			 $("#form").show();
			 $("#form form").attr("action","/admin/manageType/edit");
		 }
	 },"json");
 }
</script>

<div>
  <button onclick="add_type()">添加管理类型</button>
</div>

<table class="table table-striped">
<thead>
<tr>
  <td>ID</td>
  <td>管理类型</td>
  <td>操作</td>
</tr>
</thead>
<tbody>
<?php foreach ($data as $item) { ?>
    <tr>
      <td><?php echo $item['manageTypeId']; ?></td>
      <td><?php echo $item['typeName']; ?></td>
      <td>
        <a href="javascript:void(0)"  onclick = "edit_type( <?php echo $item['manageTypeId']; ?> )">编辑</a>
        <a href="/admin/manageType/delete?manageTypeId=<?php echo $item['manageTypeId']; ?>">删除</a>
      </td>
    </tr>
    <?php } ?>
</tbody>
<tfoot>
     <div class="btn-group">
                <?php echo $page; ?>
       </div>
</tfoot>
</table>

<div id="form" style="display:none;margin-top:20px;padding-top:10px;">
   <form action="/admin/manageType/add" method="post"  class="form-inline">
         <div class="form-group">
         <label>管理类型：</label>
         <input type="text" name="typeName"  class="form-control"  required="required"/>
         <input type="hidden" name="id" vlaue=""/>
         </div>
        <input type="submit" value="提交" class="btn btn-primary"/>
         <input type="button"  value="取消"  onclick="close_div()"class="btn btn-primary"/>
   </form>
</div>