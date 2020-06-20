<div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
            <h3 class="animated fadeInLeft">后台日志</h3>
            <p class="animated fadeInDown">
                日志 <span class="fa-angle-right fa"></span>列表
            </p>
        </div>
    </div>
</div>

<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12 padding-0" style="padding-bottom:20px;">
                    <div class="col-md-6" style="padding-left:10px;">
                        <input type="checkbox" class="icheck pull-left" name="checkbox1" />

                        <input type="button" class="btn btn-gradient btn-danger" value="删除" />

                        <input type="button" class=" btn btn-gradient btn-primary" value="修改" />
                        <input type="button" class="btn  btn-gradient btn-success" value="新增" />
                        <input type="button" class="btn btn-gradient btn-default" value="返回" />
                        <input type="button" class="btn btn-gradient btn-warning" value="警告" />
                        <input type="button" class="btn btn-gradient btn-info" value="通知" />
                    </div>

                    <div class="col-md-6">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="...">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">搜索<span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#">功能</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="responsive-table">
                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="icheck" name="checkbox1" />
                                </th>
                                <th>表 => ID</th>
                                <th>用户 => ID</th>
                                <th>动作</th>
                                <th>IP</th>
                                <th>操作时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($list) : ?>
                                <?php foreach ($list as $key => $value) : ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="icheck" name="checkbox1" />
                                        </td>
                                        <td>
                                            <?= $value->table_name . ' => ' . $value->table_id ?>
                                        </td>
                                        <td>
                                            <?= $value->username . ' => ' . $value->user_id ?>
                                        </td>
                                        <td><?= $value->action ?></td>
                                        <td><?= $value->ip ?></td>
                                        <td><?= $value->record_time ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6" style="padding-top:20px;">
                    <span>总共<?= $total ?>条</span>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <?= $pager->links() ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script src="asset/js/plugins/icheck.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

    });
</script>