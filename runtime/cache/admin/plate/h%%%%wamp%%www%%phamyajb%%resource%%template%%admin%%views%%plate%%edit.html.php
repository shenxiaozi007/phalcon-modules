
 <?php echo $this->tag->form(array('admin/plate/edit', 'method' => 'post', 'class' => 'form-inline')); ?>
        <div class= "form-group">
         <label>上一级：</label>
         <select name="parentId"  class="form-control">
           <option value="0">一级</option>
          <?php echo $taxonomys; ?>
         </select>
        </div>
         <div class="form-group">
         <label>名称：</label>
         <input type="text" name="plateName"  class="form-control"  required="required"  value="<?php echo $plateData['plateName']; ?>"/>
         </div>
         <div class="form-group">
             <label>类型：</label>
            <select name="plateType"  class="form-control">
	           <option value="1" <?php if ($plateData['plateType'] == 1) { ?> selected="selected"<?php } ?>>版块</option>
	           <option value ="2" <?php if ($plateData['plateType'] == 2) { ?> selected="selected"<?php } ?>>市场</option>
           </select>
         </div>
         <input type="hidden"  name="plateId" value="<?php echo $plateData['plateId']; ?>"/>
        <input type="submit" value="提交" class="btn btn-primary"/>
        
   </form>