<div class="row">

    <div class="col-md-6">
        <div class="page-header">
            <h2>后台登陆</h2>
        </div>
        <?php echo $this->tag->form(array('admin/login/login', 'role' => 'form')); ?>
            <fieldset>
                <div class="form-group">
                    <label for="email">用户名/电话</label>
                    <div class="controls">
                        <?php echo $this->tag->textField(array('username', 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <div class="controls">
                        <?php echo $this->tag->passwordField(array('password', 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $this->tag->submitButton(array('登陆', 'class' => 'btn btn-primary btn-large')); ?>
                </div>
            </fieldset>
        </form>
    </div>
</div>