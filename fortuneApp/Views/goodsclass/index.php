<div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
            <h3 class="animated fadeInLeft">商品分类</h3>
            <div class="row">
                <ol class="animated fadeInDown breadcrumb col-md-2 col-sm-12 col-xs-12">
                    <li><a href="<?= site_url() ?>">首页</a></li>
                    <li><a href="<?= site_url('GoodsClass/index') ?>">列表</a></li>
                    <!--按钮-->
                    <span class="hidden-md hidden-lg pull-right" id="search-btn" style="display: inline-block;cursor: pointer;">
                        搜索
                        <span class="caret"></span>
                    </span>
                </ol>

                <!--搜索内容-->
                <div class="col-md-10 col-sm-12 col-xs-12" id="search">
                    <ul class="">
                        <!-- <form method="get">
							<li>
								<label>姓名：</label>
								<input type="text" name="" style="height:35px;width:100px">
							</li>
							
							<li>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon3">姓名</span>
									<input type="text" name="full_name" value="<?= $_GET['full_name'] ?? '' ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3">
								</div>
							</li>
							<li>
								<input type="submit" class="btn btn-default" value="搜索">
							</li>
						</form> -->
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
                <form method="post" action="<?=site_url($className.'/expurgate/')?>" >
                <div class="col-md-12 padding-0" style="padding-bottom:20px;">

                    <!-- <h4 style="padding-left:10px;">列表</h4> -->

                    <div class="col-md-6" style="padding-left:10px;">
                        <input type="checkbox" class="icheck pull-left gou" name="checkbox1" />

                        <input type="Submit" onclick="return confirm('是否删除选中的数据？？');"  class="btn btn-gradient btn-danger" value="删除" />

                        <!-- 
                        <input type="button" class=" btn btn-gradient btn-primary" value="修改" />
                        <input type="button" class="btn  btn-gradient btn-success" value="新增" /> -->
                        <?php if ($pid) : ?>
                            <input type="button" class="btn btn-gradient btn-default" value="后退" onclick="javascript:history.back(-1);" />
                        <?php endif; ?>
                        <!-- <input type="button" class="btn btn-gradient btn-warning" value="警告" /> -->
                        <a href="<?= site_url('GoodsClass/create/' . $pid) ?>" title="新增" class="btn btn-gradient btn-info">新增</a>
                    </div>
                </div>

                <div class="responsive-table">

                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="icheck gou" name="checkbox1" />
                                </th>
                                <th>分类名称</th>
                                <th>分类图片</th>
                                <th>分佣比例</th>
                                <th>标签</th>
                                <th>进入下级</th>


                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($list) : ?>
                                <?php foreach ($list as $key => $value) : ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="icheck none" name="id[<?=$key?>]" value="<?= $value->id ?>" />
                                        </td>
                                        <td><b class="hidden-md hidden-lg">分类名称：</b><?= $value->name ?></td>
                                        <td>
                                            <b class="hidden-md hidden-lg">分类图片：</b>
                                            <a href="<?= showQiniu($value->thumb) ?>" target="_blank" title="商品预览" >
												<span class="fa"><img src="<?= showQiniu($value->thumb) ?>" style="width: 50px;height: 50px"></span>
											</a>
                                        </td>
                                        <td><b class="hidden-md hidden-lg">分佣比例：</b><?= $value->rate ?></td>
                                        <td><b class="hidden-md hidden-lg">标签：</b><?= $value->tags ?></td>


                                        <td>
                                            <a href="<?= site_url('GoodsClass/index/' . $value->id) ?>">进入下级</a>
                                        </td>

    

                                        <td>
                                            <a href="<?= site_url('goods/index?goods_name=&goods_sn=&cid=' . $value->id) ?>" style="color:#27C24C;"><i class="fa fa-th"></i> 此类商品 <span class="text-muted"></span></a> |
                                            <a href="<?= site_url('GoodsClass/edit/' . $value->id) ?>"><i class="fa fa-edit"></i> 修改 <span class="text-muted"></span></a> |
                                            <a style="color: red;" onclick="return confirm('是否删除-<?= $value->name ?>（ID:<?= $value->id ?>）？？');" href="<?= site_url('GoodsClass/delete/' . $value->id) ?>"><i class="fa fa-trash-o"></i> 删除</a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
                </form>
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