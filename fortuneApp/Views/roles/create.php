<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">角色</h3>
			<p class="animated fadeInDown">
				角色管理 <span class="fa-angle-right fa"></span>新加
			</p>
		</div>
	</div>
</div>

<div class="form-element">
	<div class="col-md-12 padding-0">
		<div class="col-md-12">
			<div class="panel form-element-padding">
				<div class="panel-heading">
					<a href="javascript:history.back(-1);" class="btn btn-default right">返回</a>
					<h4>新增角色</h4>
				</div>
				<div class="panel-body" style="padding-bottom:30px;">
					<div class="col-md-12">
						<form method="post" class="form-horizontal" role="form">
							<div class="form-group"><label class="col-sm-2 control-label text-right">ID</label>
								<div class="col-sm-10"><input type="text" name="id" class="form-control border-bottom" placeholder="可不填"></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">角色名</label>
								<div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">默认访问</label>
								<div class="col-sm-10"><input type="text" name="default" class="form-control border-bottom" placeholder=""></div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label text-right">是否显示</label>
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
															<input type="checkbox" name="rights[]" value="<?= $method->right_id; ?>" class="<?= $method->right_class; ?>" > <?= $method->right_class.'@'.$method->right_method; ?></label>
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
										
										<input class="submit btn btn-danger" type="submit" value="提交">
										&nbsp; &nbsp; &nbsp;
										<input class="btn btn-default" type="reset" value="重置">
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