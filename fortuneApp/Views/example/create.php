<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">上传发票</h3>
			<ol class="animated fadeInDown breadcrumb">
				<li><a href="<?=site_url()?>">首页</a></li>
				<li><a href="<?=site_url('receipt/index')?>">原始凭证</a></li>
				<li class="active">添加</li>
			</ol>
		</div>
	</div>
</div>

<div class="form-element">
	<div class="col-md-12 padding-0">
		<div class="col-md-12">
			<div class="panel form-element-padding">

				<div class="panel-heading">
					<a href="javascript:history.back(-1);" class="btn btn-default right">返回</a>
					<h4>上传发票</h4>
				</div> 

				<div class="panel-body" style="padding-bottom:30px;">
					<div class="col-md-12">
						<form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

							<!-- <div class="form-group">
								<label class="col-sm-2 control-label text-right">所属公司</label>
								<div class="col-sm-10" style="margin-top: -30px;">
									<select name="companyID" id="company" class="form-control" required>
										<option value="">选择所属公司</option>
										
									</select>
								</div>
							</div> -->

							<div class="form-group">
								<label class="col-sm-2 control-label text-right form_datetime">选择发票文件</label>
								<div class="col-sm-10">
									<input type="file" name="invoice_file">
								</div> 
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">开票日期</label>
								<div class="col-sm-10">
									<input size="16" type="text" name="invoiceDate" value="" readonly id="myYear">
								</div> 
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">价税合计</label>
								<div class="col-sm-10 input-group">
			                        <span class="input-group-addon">￥</span>
			                        <input class="form-control" aria-label="Amount (to the nearest dollar)" type="text" name="valoremTax" placeholder="0.00">
			                        <span class="input-group-addon">元</span>
			                    </div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">发票类别</label>
								<div class="col-sm-10" style="margin-top: -30px;">
									<select name="category" class="form-control" required>
										<option value="">选择发票类别</option>
										<option value="增值税专用发票">增值税专用发票</option>
										<option value="增值税普通发票">增值税普通发票</option>
										<option value="增值税电子普通发票">增值税电子普通发票</option>
										<option value="通用机打发票">通用机打发票</option>
										<option value="银行对账单">银行对账单</option>
										<option value="定额发票">定额发票</option>
										<option value="其它">其它</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">发票用途</label>
								<div class="col-sm-10">
									<input type="text" name="detail" placeholder="请输入发票用途" class="form-control">
								</div>
							</div>
							

							
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">原件存档编号</label>
								<div class="col-sm-10">
									<input type="text" name="archivalNumber" placeholder="存档编号" class="form-control">
								</div>
							</div>
							 
							<div class="form-group"><label class="col-sm-2 control-label text-right"> </label>
								<div class="col-sm-10">
									<div class="col-sm-12 padding-0">
										<input type="hidden" name="companyName" id="companyName" value="" >
										<input type="hidden" name="creditCode" id="creditCode" value="" >
										<input type="hidden" name="eID" value="<?=session('id')?>" >
										<input type="hidden" name="fullName" value="<?=session('username')?>" >
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

<link type="text/css" href="asset/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="asset/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="asset/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<!-- 文档：http://www.bootcss.com/p/bootstrap-datetimepicker/demo.htm -->
<!-- Github:https://github.com/smalot/bootstrap-datetimepicker -->
<script type="text/javascript">
	/*设置公司统一信用代码与公司名称*/
	$("#company").on('change',function(){
		// alert($('#company option:selected').data("code"));
		$("#companyName").val($('#company option:selected').text());  
		$("#creditCode").val($('#company option:selected').data("code"));
	});

	/*年-月-日*/
	$('#myYear').datetimepicker({
		format:'yyyy-mm-dd',
		language:'zh-CN', //设置为中文
		autoclose:true,   //自动关闭
		todayBtn:true,    //显示今天
		// todayHighlight: 1,  //是否在当前行显示选择
		startView: 2,    //时间（1为选择时间,2常用日期时间）;
		minView: 2,     //选择层数（0两层选择 1为一层选择）
		forceParse: 0
	});

	/*请假开始*/
	$('#begin_time').datetimepicker({
		format:'yyyy-mm-dd hh:ii',
		language:'zh-CN', //设置为中文
		autoclose:true,   //自动关闭
		todayBtn:true,    //显示今天
		// pickerPosition: "bottom-left"
	});

	/*请假结束时间*/
	$('#end_time').datetimepicker({
		format:'yyyy-mm-dd hh:ii',
		language:'zh-CN', //设置为中文
		autoclose:true,   //自动关闭
		todayBtn:true,    //显示今天
		// pickerPosition: "bottom-left"
	});
</script>