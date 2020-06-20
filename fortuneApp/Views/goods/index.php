<div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
            <h3 class="animated fadeInLeft">商品管理</h3>
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
                                <label>商品名称：</label>
                                <input type="text" name="goods_name" value="<?= $_GET['goods_name'] ?? '' ?>" placeholder="商品名称" style="height:35px;width:100px">
                            </li>
                            <li>
                                <label>编号：</label>
                                <input type="text" name="goods_no" value="<?= $_GET['goods_no'] ?? '' ?>" placeholder="商品编号" style="height:35px;width:100px">
                            </li>
                            <li>
                                <label>所属分类：</label>
                                <select name="cid" style="height:35px;width:180px">
                                    <option value="">请选择分类</option>
                                    <?php if (isset($category) && $category) : ?>
                                        <?php foreach ($category as $key => $value) : ?>
                                            <?= $value ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
                    <a href="<?= site_url('goods/create/') ?>" title="新增" class="right btn btn-gradient btn-info">新增</a>
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
                                    <th>商品名</th>
                                    <th>副标题</th>
                                    <th>所属分类</th>
                                    <th>数量</th>
                                    <th>商品价格</th>
                                    <th>市场价格</th>
                                    <th>创建时间</th>
                                    <th>自定义编号</th>
                                    <th>商品状态</th>


                                    <th>审核状态</th>


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
                                                <b class="hidden-md hidden-lg">商品名：</b>
                                                <?= $value->goods_name ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">副标题：</b>
                                                <?= $value->goods_subname ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">所属分类：</b>
                                                <?= $value->class_name ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">数量：</b>
                                                <?= $value->goods_num ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">商品价格：</b>
                                                <?= $value->goods_price ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">市场价格：</b>
                                                <?= $value->goods_market_price ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">创建时间：</b>
                                                <?= date('Y-m-d H:i:s', $value->add_time) ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">自定义编号：</b>
                                                <?= $value->goods_no ?>
                                            </td>
                                            <td>
                                                <b class="hidden-md hidden-lg">商品状态：</b>
                                                <?= $value->goods_status == '1' ? '上架' : '下架' ?>
                                            </td>



                                            <td>
                                                <b class="hidden-md hidden-lg">审核状态：</b>
                                                <?= $value->goods_verify == '1' ? '<span class="label label-info ">' . goodsVerify($value->goods_verify) . '</span>' : '<span class="label label-warning ">' . goodsVerify($value->goods_verify) . '</span>' ?>
                                            </td>





                                            <td>
                                                <a href="<?= site_url('goods/edit/' . $value->id) ?>"><i class="fa fa-edit"></i>修改 <span class="text-muted"></span></a> |
                                                <a style="color: red;" href="<?= site_url('goods/delete/' . $value->id) ?>" onclick="return confirm('是否要删除ID:<?= $value->id ?>（用途：<?= $value->goods_name ?>）？？');"><i class="fa fa-trash-o"></i>删除</a>
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

                                            <!-- <input type="button" class=" btn btn-gradient btn-primary" value="修改" /> -->
                                            <a href="<?= site_url('goods/create/') ?>" title="新增" class="btn  btn-gradient btn-success">新增</a>
                                            <!-- <input type="button" class="btn btn-gradient btn-default" value="返回" /> -->
                                            <input type="button" class="btn btn-gradient btn-default" value="返回" onclick="javascript:history.back(-1);" />

                                            <!-- <input type="button" class="btn btn-gradient btn-warning" value="警告" /> -->
                                            <!-- <input type="button" class="btn btn-gradient btn-info" value="通知" /> -->



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