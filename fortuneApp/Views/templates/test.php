<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">首页测试</h3>
			<p class="animated fadeInDown">
				表格&nbsp;<span class="fa-angle-right fa"></span>&nbsp;表格测试
			</p>
		</div>
	</div>
</div>

<div class="col-md-12 top-20 padding-0">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
                
                <!-- 警告(提示) start -->
                <?=view('alert/fade')?>
				<!-- 警告(提示) end -->

				<div class="col-md-12 padding-0" style="padding-bottom:20px;">

					<div class="col-md-6" style="padding-left:10px;">
						<input type="checkbox" class="icheck pull-left" name="checkbox1"/>

						<input type="button" class="btn btn-gradient btn-danger" value="删除" onclick="return confirm('是否要删除ID:（用途：）？？');" />
						<input type="button" class=" btn btn-gradient btn-primary" value="修改"/>
						<input type="button" class="btn  btn-gradient btn-success" value="新增"/>
						<input type="button" class="btn btn-gradient btn-default" value="返回"/>
						<input type="button" class="btn btn-gradient btn-warning" value="警告"/>
						<input type="button" class="btn btn-gradient btn-info" value="通知"/>

					</div>

					<div class="col-md-6">
						<div class="col-lg-12">
							<div class="input-group">
								<input type="text" class="form-control" aria-label="...">
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">搜索<span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#">Action</a></li>
										<li><a href="#">Another action</a></li>
										<li><a href="#">Something else here</a></li>
										<li role="separator" class="divider"></li>
										<li><a href="#">Separated link</a></li>
									</ul>
								</div><!-- /btn-group -->
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
					</div>
				</div>
				<div class="responsive-table">

					<table class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th><input type="checkbox" class="icheck" name="checkbox1" /></th>
								<th>名字</th>
								<th>Position</th>
								<th>办公室</th>
								<th>Age</th>
								<th>Start date</th>
								<th>Salary</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>

							<tr>
								<td><input type="checkbox" class="icheck" name="checkbox1" /></td>
								<td>Tiger Nixon</td>
								<td>System Architect</td>
								<td>Edinburgh</td>
								<td>61</td>
								<td>2011/04/25</td>
								<td>$320,800</td>
								<td>
									<div class="btn-group">
										<a class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</a>

										<a class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</a>

										<a class="btn btn-xs btn-danger" onclick="return confirm('是否要删除ID:（用途：）？？');" >
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</a>

										<a class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</a>
									</div>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="icheck" name="checkbox1" /></td>
								<td>Garrett Winters</td>
								<td>Accountant</td>
								<td>Tokyo</td>
								<td>63</td>
								<td>2011/07/25</td>
								<td>$170,750</td>
								<td >
									<a href="" style="color:#27C24C;"><i class="fa fa-plus-square-o"></i> 新增 <span class="text-muted"></span></a> |
									<a href=""><i class="fa fa-edit"></i> 修改 <span class="text-muted"></span></a> |
                                    <a style="color: red;" href="" onclick="return confirm('是否要删除ID:（用途：）？？');"><i class="fa fa-trash-o"></i>删除</a>
									
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" class="icheck" name="checkbox1" /></td>
								<td>Herrod Chandler</td>
								<td>Sales Assistant</td>
								<td>San Francisco</td>
								<td>59</td>
								<td>2012/08/06</td>
								<td>$137,500</td>
								<td style="text-align: center;">
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-danger" onclick="return confirm('是否要删除ID:（用途：）？？');">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</button>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a href="javascript:void(0)" class="tooltip-info" data-rel="tooltip" title="View">
														<span class="blue">
															<i class="ace-icon fa fa-search-plus bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a href="javascript:void(0)" class="tooltip-success" data-rel="tooltip" title="Edit">
														<span class="green">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a href="javascript:void(0)" class="tooltip-error" data-rel="tooltip" title="Delete">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="col-md-6" style="padding-top:20px;">
					 
					<span>
						<input type="checkbox" class="icheck pull-left" name="checkbox1"/>
						<input type="button" class="btn btn-gradient btn-danger" value="删除"/>
						<input type="button" class=" btn btn-gradient btn-primary" value="修改"/>
						<input type="button" class="btn  btn-gradient btn-success" value="新增"/>
						<input type="button" class="btn btn-gradient btn-default" value="返回"/>
						<input type="button" class="btn btn-gradient btn-warning" value="警告"/>
						<input type="button" class="btn btn-gradient btn-info" value="通知"/>
					</span>
				</div>
				<div class="col-md-6">
					<div class="pull-right">

					<ul class="pagination">
						<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
							<a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>

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

		// alert('kk');

	});

	
</script>