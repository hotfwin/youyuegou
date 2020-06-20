<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">角色</h3>
			<p class="animated fadeInDown">
				角色管理 <span class="fa-angle-right fa"></span>列表
			</p>
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
				<div class="col-md-12 padding-0" style="padding-bottom:20px;">
					<a href="<?=site_url('roles/create/')?>" class="right btn  btn-gradient btn-success" >新增</a>
					<h4 style="padding-left:10px;">列表</h4>   
				</div>

				<div class="responsive-table">
					<table class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th><input type="checkbox" class="icheck" name="checkbox1" /></th>
								<th>ID</th>
								<th>角色名</th>
								<th >rights</th>
								 
								<th>&nbsp;&nbsp;&nbsp;修改&nbsp;|&nbsp;删除</th>
								 
							</tr>
						</thead>
						<tbody>
							<?php if($list): ?>
								<?php foreach ($list as $key => $value): ?>
							<tr>
								<td>
									<input type="checkbox" class="icheck" name="checkbox1" />
								</td>
								<td><?=$value->id?></td>
								<td><?=$value->name?></td>
								<td><?=$value->rights?></td>
								<td>
									<div class="btn-group">
										<a href="<?=site_url('roles/edit/'.$value->id)?>" class="btn btn-xs btn-info" title="修改">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</a>
										<a href="<?=site_url('roles/delete/'.$value->id)?>" onclick="return confirm('是否删除-<?= $value->name ?>（ID:<?= $value->id ?>）？？');" class="btn btn-xs btn-danger" title="删除">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</a>
									</div>
								</td>

							</tr>
								<?php endforeach; ?>
							<?php else: ?>
							<tr>
								<td colspan="200" style="text-align: center;">
									暂无数据!! 现在<a href="<?=site_url('roles/create/')?>">新增</a>数据
								</td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6" style="padding-top:20px;">
					<span>总共<?=$total?>条</span>
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
	$(document).ready(function(){

		$('input').iCheck({
			checkboxClass: 'icheckbox_flat-red',
			radioClass: 'iradio_flat-red'
		});

	});

</script>