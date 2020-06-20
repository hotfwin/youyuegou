<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">菜单管理</h3>
			<p class="animated fadeInDown">
				菜单 <span class="fa-angle-right fa"></span> 列表
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
					<?php if ($parent) : ?>
						<a href="javascript:history.back(-1);" class="right btn btn-gradient btn-default" style="margin-left:8px;">后退</a>
					<?php endif; ?>
					<a href="<?= site_url('menus/create/' . $parent) ?>" class="right btn btn-gradient btn-success">新增</a>
					<h4 style="padding-left:10px;">列表（<?= $total ?>条）</h4>
				</div>

				<div class="responsive-table">

					<table class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th><input type="checkbox" class="icheck" name="checkbox1" /></th>
								<th>排序</th>
								<th>菜单名称</th>
								<th>对应类</th>
								<th>对应方法</th>
								<th>层级</th>
								<th>是否显示</th>
								<th>所属顶级</th>
								<th>进入下级</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($list) : ?>
								<?php foreach ($list as $key => $value) : ?>
									<tr>
										<td><input type="checkbox" class="icheck" name="checkbox1" /></td>
										<td><?= $value->order_by ?></td>
										<td><?= $value->name ?></td>
										<td><?= $value->class ?></td>
										<td><?= $value->method ?></td>
										<td><?= $value->level ?></td>
										<td>
											<?php if ($value->is_show) : ?>
												<span class="label label-success">显示</span>
											<?php else : ?>
												<span class="label label-danger">不显示</span>
											<?php endif; ?>
										</td>
										<td><?= $value->department ?></td>
										<td>
											<a href="<?= site_url('menus/index/' . $value->id) ?>" style="color: green;">进入下级</a>
										</td>
										<td style="text-align: center;">
											<a href="<?= site_url('menus/edit/' . $value->id) ?>"><i class="fa fa-edit"></i> 修改 <span class="text-muted"></span></a> |
											<a style="color: red;" href="<?= site_url('menus/delete/' . $value->id) ?>" onclick="return confirm('是否删除-<?= $value->name ?>（ID:<?= $value->id ?>）？？');"><i class="fa fa-trash-o"></i> 删除</a>
										</td>

									</tr>
								<?php endforeach; ?>
							<?php endif; ?>

						</tbody>
					</table>
				</div>
				<div class="col-md-6" style="padding-top:-20px;">
					 
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

		// alert('kk');

	});
</script>