<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">后台用户</h3>
			<p class="animated fadeInDown">
				用户 <span class="fa-angle-right fa"></span> 修改
			</p>
		</div>
	</div>
</div>

<div class="form-element">
	<div class="col-md-12 padding-0">
		<div class="col-md-12">
			<div class="panel form-element-padding">
				<div class="panel-heading">
					<h4>后台用户</h4>
					
				</div>
				<div class="panel-body" style="padding-bottom:30px;">
				<div class="col-md-12 panel-body" style="padding-bottom:30px;">
					<div class="col-md-12">
						<form method="post" class="cmxform" id="signupForm">
							<div class="form-group form-animate-text" style="margin-top:40px !important;">
								<input type="text" class="form-text" id="validate_firstname" name="username" value="<?=$edit->username?>" required>
								<span class="bar"></span>
								<label>登录名称</label>
							</div>
							<div class="form-group form-animate-text" style="margin-top:40px !important;">
								<input type="password" class="form-text" id="validate_password" name="password" >
								<span class="bar"></span>
								<label>密码</label>
							</div>
							<div class="form-group form-animate-text" style="margin-top:40px !important;">
								<input type="text" class="form-text" id="validate_email" name="email" value="<?=$edit->email?>" required>
								<span class="bar"></span>
								<label>Email</label>
							</div>
							 

								<div class="col-sm-12 padding-0">
                                  <select name="role" class="form-control" multiple>
                                    <option>请选择角色</option>
                                    <?php foreach ($roles as $key => $value): ?>
	                                    <option value="<?=$key?>" <?=$edit->role==$key?'selected="selected"':''?> ><?=$value?></option>
	                                <?php endforeach; ?>
                                  </select>
                                  <br><br>
                                </div>

					
                            
                            <div class="col-md-4 col-sm-12">
								<div class="col-md-6 panel" style="padding:20px;padding-bottom:0px;">
									<div class="form-animate-radio">
										<label class="radio">
											<input id="radio1" type="radio" name="status" value="0" <?=$edit->status=='0'?'checked':''?> />
											<span class="outer">
											<span class="inner"></span></span> 正常
										</label>
									</div>
								</div>
								<div class="col-md-6 panel" style="padding:20px;padding-bottom:0px;">
									<div class="form-animate-radio">
										<label class="radio">
											<input id="radio1" type="radio" name="status" value="1" <?=$edit->status=='1'?'checked':''?> />
											<span class="outer">
											<span class="inner"></span></span> 冻结
										</label>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								
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


						</form>

					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>