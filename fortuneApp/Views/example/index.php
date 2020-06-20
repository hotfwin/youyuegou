<div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
            <h3 class="animated fadeInLeft">原始凭证</h3>
            <div class="row">
                <ol class="animated fadeInDown breadcrumb col-md-2 col-sm-12 col-xs-12">
                    <li><a href="<?= site_url() ?>">首页</a></li>
                    <li class="active">列表</li>

                    <!--按钮-->
                    <span class="hidden-md hidden-lg pull-right" id="search-btn" style="display: inline-block;cursor: pointer;">
                        搜索
                        <span class="caret"></span>
                    </span>
                </ol>
                <!--搜索内容-->
                <div class="col-md-10 col-sm-12 col-xs-12" id="search">
                    <ul class="">
                        <form method="get">
                            <li>
                                <label>开票日期：</label>
                                <input type="text" name="year" value="<?= $_GET['year'] ?? '' ?>" placeholder="年" style="height:35px;width:100px">
                                <span>-</span>
                                <input type="text" value="<?= $_GET['month'] ?? '' ?>" name="month" placeholder="月" style="height:35px;width:100px">
                            </li>
                            <!-- <li>
								<label>上传人：</label>
								<input type="text" name="fullName" value="<?= $_GET['fullName'] ?? '' ?>" placeholder="上传人" style="height:35px;width:100px">
							</li> -->
                            <li>
                                <select name="companyID" id="company" class="form-control">
                                    <option value="">所属公司</option>

                                </select>
                            </li>
                            <li>
                                <select name="chargeUp">
                                    <option value="">是否入账</option>
                                    <option value="1" <?= isset($_GET['chargeUp']) && $_GET['chargeUp'] == '1' ? 'selected="selected"' : '' ?>>已入账</option>
                                    <option value="0" <?= isset($_GET['chargeUp']) && $_GET['chargeUp'] == '0' ? 'selected="selected"' : '' ?>>未入账</option>
                                </select>
                            </li>
                            <li>
                                <input type="submit" class="btn btn-default" value="搜索">
                            </li>
                        </form>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">

                <!-- 警告(提示) start -->
                <?= view('alert/fade') ?>
                <!-- 警告(提示) end -->

                <div class="col-md-12 " style="padding-bottom:20px;">
                    <!-- <a href="javascript:history.back(-1);" class="right btn btn-gradient btn-default" style="margin-left:8px;" >后退</a> -->
                    <a href="<?= site_url('example/create/') ?>" title="新增" class="right btn btn-gradient btn-info">新增</a>
                    <h4 style="padding-left:10px;">列表（<?= $total ?>条）</h4>
                </div>

                <div class="responsive-table">
                    <form method="post" action="<?= site_url($className . '/expurgate/') ?>">
                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="icheck gou" name="checkbox1" />
                                    </th>
                                    <th>所属公司</th>
                                    <th>明细用途</th>
                                    <th>发票类别</th>
                                    <th>价税合计</th>
                                    <th>开票日期</th>
                                    <th>发票文件</th>
                                    <th>上传人</th>
                                    <!-- <th>上传日期</th> -->
                                    <th>存档编号</th>
                                    <th>是否入账</th>
                                    <th>是否报销</th>


                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($list) : ?>

                                    <?php foreach ($list as $key => $value) : ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="icheck none" name="id[<?= $key ?>]" value="<?= $value->id ?>" />
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">所属：</b>
                                                <?= $value->companyName ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">用途：</b>
                                                <?= $value->detail ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">发票类别：</b>
                                                <?= $value->category ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">价税合计：</b>
                                                <?= $value->valoremTax ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">开票日期：</b>
                                                <?= $value->invoiceDate ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url($value->invoiceFile) ?>" target="view_window">
                                                    <?= $value->invoiceTitle . $value->invoiceExtension ?>
                                                </a>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">上传人：</b>
                                                <?= $value->fullName ?>
                                            </td>
                                            <!-- <td>
											<b class="hidden-md hidden-lg">上传日期：</b>
											<?= date('Y-m-d H:i:s', $value->create) ?>
										</td> -->

                                            <td>
                                                <b class="hidden-md hidden-lg">原件存档编号：</b>
                                                <?= $value->archivalNumber ?>
                                            </td>

                                            <td>
                                                <b class="hidden-md hidden-lg">是否入账：</b>
                                                <?= $value->chargeUp == '1' ? '<span class="label label-info ">已入账</span>' : '<span class="label label-warning ">未入账</span>' ?>
                                            </td>

                                            <td>
                                                <b class="hidden-md hidden-lg">是否报销：</b>
                                                <?= $value->reimburse == '1' ? '<span class="label label-info ">已报销</span>' : '<span class="label label-warning ">未报销</span>' ?>
                                            </td>



                                            <td>
                                                <a href="" style="color:#27C24C;"><i class="fa fa-cny"></i>去记账 <span class="text-muted"></span></a> |
                                                <a href="<?= site_url('example/edit/' . $value->id) ?>"><i class="fa fa-edit"></i>修改 <span class="text-muted"></span></a> |
                                                <a style="color: red;" href="<?= site_url('example/delete/' . $value->id) ?>" onclick="return confirm('是否要删除ID:<?= $value->id ?>（用途：<?= $value->detail ?>）？？');"><i class="fa fa-trash-o"></i>删除</a>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="999">
                                            <div class="pull-right">
                                                <?= $pager->links() ?>
                                            </div>

                                            <input type="checkbox" class="icheck pull-left gou" name="checkbox1" />

                                            <!-- <input type="button" class="btn btn-gradient btn-danger" value="删除" /> -->
                                            <input type="Submit" onclick="return confirm('是否删除选中的数据？？');" class="btn btn-gradient btn-danger" value="删除" />

                                            <input type="button" class=" btn btn-gradient btn-primary" value="修改" />
                                            <a href="<?= site_url('example/create/') ?>" title="新增" class="btn  btn-gradient btn-success">新增</a>
                                            <!-- <input type="button" class="btn btn-gradient btn-default" value="返回" /> -->
                                            <input type="button" class="btn btn-gradient btn-default" value="返回" onclick="javascript:history.back(-1);" />

                                            <input type="button" class="btn btn-gradient btn-warning" value="警告" />
                                            <input type="button" class="btn btn-gradient btn-info" value="通知" />



                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>


<link type="text/css" href="asset/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="asset/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="asset/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script src="asset/js/plugins/icheck.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // 选项样式
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
        /*全选与反选*/
        var num = 0;
        $('.gou').next().each(function(i) {
            $(this).on('click', function() {

                if (num == 0) {
                    $('.icheck').prop('checked', true).parent().addClass('checked');
                    num += 1;
                } else {
                    $('.icheck').prop('checked', false).parent().removeClass('checked');
                    num = 0;
                }
            });
        });

        /*搜索居右设置*/
        var width = $(window).width();
        if (width > 990) {
            $('#search ul').addClass('pull-right');
        }
        $("#search-btn").click(function() {
            $('#search').toggle();
        });

    });
</script>