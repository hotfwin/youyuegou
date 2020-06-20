<div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
            <h3 class="animated fadeInLeft">修改密码</h3>
            <p class="animated fadeInDown">
                首页 <span class="fa-angle-right fa"></span> 修改密码
            </p>
        </div>
    </div>
</div>


<div class="form-element">
    <div class="col-md-12 padding-0">
        <div class="col-md-12">
            <div class="panel form-element-padding">
                <div class="panel-heading">
                    <h4>表单</h4>
                </div>
                
                <div class="panel-body" style="padding-bottom:30px;">
                    <div class="col-md-12">
                        <!-- 警告(提示) start -->
                        <?= view('alert/fade') ?>
                        <!-- 警告(提示) end -->
                        
                        <form method="post" class="form-horizontal" role="form">

                            <div class="form-group"><label class="col-sm-2 control-label text-right">原来密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="former" class="form-control">
                                    <?= $validation->showError('former'); ?>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">新密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control">
                                    <?= $validation->showError('password'); ?>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">确认密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="passwd" class="form-control">
                                    <?= $validation->showError('passwd'); ?>
                                </div>
                            </div>


                            <div class="form-group"><label class="col-sm-2 control-label text-right"> </label>
                                <div class="col-sm-10">
                                    <div class="col-sm-12 padding-0">
                                        <button class="btn btn-info btn-success" type="Submit">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            确认修改
                                        </button>
                                        &nbsp; &nbsp; &nbsp;
                                        <button class="btn" type="reset" onclick="javascript:history.back(-1);">
                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                            取消
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>