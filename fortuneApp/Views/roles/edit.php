<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">角色</h3>
			<p class="animated fadeInDown">
				角色管理 <span class="fa-angle-right fa"></span>修改
			</p>
		</div>
	</div>
</div>

<div class="form-element">
	<div class="col-md-12 padding-0">
		<div class="col-md-12">
			<div class="panel form-element-padding">
				<div class="panel-heading">
					<h4>角色修改</h4>
				</div>
				<div class="panel-body" style="padding-bottom:30px;">
					<div class="col-md-12">
						<form method="post" class="form-horizontal" role="form">
							<div class="form-group"><label class="col-sm-2 control-label text-right">角色名</label>
								<div class="col-sm-10"><input type="text" name="name" value="<?=$roles->name?>" class="form-control"></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">默认访问</label>
								<div class="col-sm-10"><input type="text" name="default" value="<?=$roles->default?>" class="form-control border-bottom" placeholder=""></div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label text-right">权限</label>
								<div class="col-sm-10">
							        
									<?php foreach($rights as $key=>$value): ?>

										<div class="col-md-6 panel" style="padding:20px;padding-bottom:0px;">
											<div class="form-group form-animate-checkbox">
												<input type="checkbox" value="" name="rights[]" id="<?= $value['class']; ?>" class="checkbox <?= $value['class']; ?>" onclick="mySelectAll('<?=$value['class']?>');">
												<label for="<?= $value['class']; ?>"> <?= $value['class']; ?></label>
											</div>
											    <div class="col-sm-10" style="top: -15px;left:-5px;">
													<?php foreach ($value['methods'] as $method): ?>
														<div class="col-sm-12 padding-0">
															<label>
															<input type="checkbox" name="rights[]" value="<?= $method->right_id; ?>" class="<?= $method->right_class; ?>" <?= in_array($method->right_id, $roles->rights)?'checked':''; ?> > <?= $method->right_class.'@'.$method->right_method; ?></label>
														</div>
													<?php endforeach; ?>
												</div>
										</div>
									<?php endforeach; ?>

								</div>
							</div>

						

						

							<div class="form-group"><label class="col-sm-2 control-label text-right"> </label>
								<div class="col-sm-10">
									<div class="col-sm-12 padding-0">
										
										<button class="btn btn-info btn-success" type="Submit">
											<i class="ace-icon fa fa-check bigger-110"></i>
											提交
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

<script type="text/javascript">
	function mySelectAll(c){
		if($("#"+c).prop("checked")){
			$("."+c).prop('checked',true);
		}else{
			$("."+c).prop('checked',false);
		}
	}
</script>