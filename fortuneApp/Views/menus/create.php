<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">菜单管理</h3>
			<p class="animated fadeInDown">
				菜单 <span class="fa-angle-right fa"></span> 新增
			</p>
		</div>
	</div>
</div>

<div class="form-element">
	<div class="col-md-12 padding-0">
		<div class="col-md-12">
			<div class="panel form-element-padding">
				<div class="panel-heading">
					<h4>新增菜单表单</h4>
				</div>
				<div class="panel-body" style="padding-bottom:30px;">
					<div class="col-md-12">
						<form method="post" class="form-horizontal" role="form">

							<div class="form-group"><label class="col-sm-2 control-label text-right">菜单名</label>
								<div class="col-sm-10">
									<input type="text" name="name" class="form-control">
									<?= \Config\Services::validation()->showError('name'); ?>
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">class</label>
								<div class="col-sm-10"><input type="text" name="class" class="form-control border-bottom" placeholder="请输入类名"></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">method</label>
								<div class="col-sm-10"><input type="text" name="method" class="form-control border-bottom" placeholder="输入方法名"></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">菜单层级</label>
								<div class="col-sm-10"><input type="text" name="level" class="form-control" placeholder="输入菜单级数"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">排序</label>
								<div class="input-group">
	                                <span class="input-group-addon" id="basic-addon3">从小排到大</span>
			                        <input type="text" name="order_by" value="1"  class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                </div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label text-right">ICON</label>
								<div class="col-sm-10"><input type="text" name="icon" class="form-control border-bottom" placeholder="icon小图标类名"></div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label text-right">是否显示</label>
								<div class="col-sm-10">
									 
	                                <div class="mini-onoffswitch onoffswitch-success">
										<input type="radio" name="is_show" value="1" class="onoffswitch-checkbox" id="myonoffswitch1FC" checked>
										<label class="onoffswitch-label" for="myonoffswitch1FC" title="显示"></label>
									</div>

									<div class="mini-onoffswitch onoffswitch-default">
										<input type="radio" name="is_show" value="0" class="onoffswitch-checkbox" id="myonoffswitch1FE" >
										<label class="onoffswitch-label" for="myonoffswitch1FE" title="不显示"></label>
									</div>

								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label text-right">所属上级</label>
								<div class="col-sm-10" style="margin-top: -30px;">
									<select name="parent" class="form-control">
										<option selected="selected">请选择</option>
										<?php if($menus): ?>
											<?php foreach($menus as $key=>$value): ?>
												<option style="color: red;" value="<?=$value->id?>" <?=$value->id==$parent?'selected="selected"':''?>>|<?=$value->name?></option>
												<?php if($value->child): ?>
													<?php foreach($value->child as $k =>$val): ?>
														<option value="<?=$val->id?>" <?=$val->id==$parent?'selected="selected"':''?>>|-----<?=$val->name?></option>
													<?php endforeach; ?>	
												<?php endif;?>	
											<?php endforeach; ?>
										<?php endif; ?>
										 
									</select>
								</div>
							</div>
							 

							<div class="form-group"><label class="col-sm-2 control-label text-right">所属顶级</label>
								<div class="col-sm-10" style="margin-top: -30px;">
										 
									<select name="department" class="form-control">
										<option selected="selected">请选择</option>
										<?php foreach ($department as $key => $value): ?>
											<option value="<?=$value->id?>" <?=$value->id==$parent?'selected="selected"':''?> ><?=$value->name?></option>
										<?php endforeach; ?>
									</select>
									 
								</div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label text-right"> </label>
								<div class="col-sm-10">
									<div class="col-sm-12 padding-0">
										<input type="hidden" name="jumpURL" value="<?=site_url('menus/index/'.$parent);?>" >
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

