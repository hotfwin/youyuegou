<div class="panel box-shadow-none content-header">
	<div class="panel-body">
		<div class="col-md-12">
			<h3 class="animated fadeInLeft">商品分类</h3>
			<ol class="animated fadeInDown breadcrumb">
				<li><a href="<?= site_url() ?>">首页</a></li>
				<li><a href="<?= site_url('category/index') ?>">分类列表</a></li>
				<li class="active">修改</li>
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
					<h4>分类修改</h4>
				</div>
				<div class="panel-body" style="padding-bottom:30px;">
					<div class="col-md-12">
						<form method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label text-right">分类名称</label>
								<div class="col-sm-10"><input type="text" name="name" value="<?= $edit->name ?>" class="form-control" placeholder="请输入分类名称"></div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label text-right">
									分类图片<br>尺寸：<b style="color: red;">0*0</b>
								</label>
								<div class="col-sm-10">
									<input type="file" name="thumb">
								</div>
							</div>


							<div class="form-group"><label class="col-sm-2 control-label text-right">所属上级</label>
								<div class="col-sm-10">
									<div class="col-sm-12 padding-0" style="margin-top: -30px;">

										<select name="parent_id" class="form-control">
											<option selected="selected">请选择</option>
											<?php if ($category) : ?>
												<?php foreach ($category as $key => $value) : ?>
													<?= $value ?>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>

									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label text-right">排序</label>
								<div class="input-group" style="margin-top: -15px;">
									<span class="input-group-addon" id="basic-addon3">从小排到大</span>
									<input type="text" name="is_sort" value="<?= $edit->is_sort ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label text-right">分佣比例</label>
								<div class="col-sm-10"><input type="text" name="rate" value="<?=$edit->rate?>" class="form-control border-bottom" placeholder="分佣比例"></div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label text-right">标签</label>
								<div class="col-sm-10"><input type="text" name="tags" value="<?=$edit->tags?>" class="form-control border-bottom" placeholder="标签"></div>
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

<!-- 图片上传样式 start -->
<link href="asset/uploader/src/jquery.fileuploader.css" media="all" rel="stylesheet">
<link href="asset/uploader/css/thumbnails.css" media="all" rel="stylesheet">
<script src="asset/uploader/src/jquery.fileuploader.js" type="text/javascript"></script>
<!-- 图片上传样式 end -->
<script type="text/javascript">
	$(function () {
		/*商品图(列表商品时显示176*255))*/
		$('input[name="thumb"]').fileuploader({
			limit: 1,
			extensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'],
			changeInput: 'image',    //把input中的name转回来
			theme: 'thumbnails',
			enableApi: true,
	        addMore: false,    //true为多文件，false为单个文件
	        thumbnails: { 
				box: '<div class="fileuploader-items">\
	                      <ul class="fileuploader-items-list">\
						      <li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner">+</div></li>\
	                      </ul>\
	                  </div>',
				item: '<li class="fileuploader-item">\
					       <div class="fileuploader-item-inner">\
	                           <div class="thumbnail-holder">${image}</div>\
	                           <div class="actions-holder">\
	                               <a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>\
	                           </div>\
	                       	   <div class="progress-holder">${progressBar}</div>\
	                       </div>\
	                   </li>',
				item2: '<li class="fileuploader-item">\
					       <div class="fileuploader-item-inner">\
	                           <div class="thumbnail-holder">${image}</div>\
	                           <div class="actions-holder">\
	                               <a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>\
	                           </div>\
	                       </div>\
	                   </li>',
				startImageRenderer: true,
				canvasImage: false,
				_selectors: {
					list: '.fileuploader-items-list',
					item: '.fileuploader-item',
					start: '.fileuploader-action-start',
					retry: '.fileuploader-action-retry',
					remove: '.fileuploader-action-remove'
				},
				onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
					var plusInput = listEl.find('.fileuploader-thumbnails-input'),
						api = $.fileuploader.getInstance(inputEl.get(0));
					
					if(api.getFiles().length >= api.getOptions().limit) {
						plusInput.hide();
					}
					
					plusInput.insertAfter(item.html);
					
					
					if(item.format == 'image') {
						item.html.find('.fileuploader-item-icon').hide();
					}
				},
				onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
					var plusInput = listEl.find('.fileuploader-thumbnails-input'),
						api = $.fileuploader.getInstance(inputEl.get(0));
					
	                html.children().animate({'opacity': 0}, 200, function() {
	                    setTimeout(function() {
	                        html.remove();
							
							if(api.getFiles().length - 1 < api.getOptions().limit) {
								plusInput.show();
							}
	                    }, 100);
	                });
					
	            }
			},
	        <?php if($edit->image): ?>
	        files: [
			{
				name: '<?=$edit->id?>',
				type: 'image/jpeg',
				file: '<?=base_url($edit->image)?>',
				data: {
					url: '<?=base_url($edit->image)?>'							  
			    }
		  	},
		  	],
			<?php endif; ?>
			upload: {
				//后台上传图片
				url: '<?=site_url("GoodsClass/uploadImg/".$edit->id."/".$edit->thumb)?>',
	            data: null,
	            type: 'POST',
	            enctype: 'multipart/form-data',
	            start: true,
	            synchron: true,
	            beforeSend: null,
	            onSuccess: function(data, item) {
					setTimeout(function() {
						item.html.find('.progress-holder').hide();
						item.renderImage();
					}, 400);
					// alert('图片上传成功');
	            },
	            onError: function(item) {
	            	alert('图片上传出错');
					item.html.find('.progress-holder').hide();
					item.html.find('.fileuploader-item-icon i').text('Failed!');
	            },
	            onProgress: function(data, item) {
	            	// alert('进度条');
	                var progressBar = item.html.find('.progress-holder');
					
	                if(progressBar.length > 0) {
	                    progressBar.show();
	                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
	                }
	            }
	        },
	        afterRender: function(listEl, parentEl, newInputEl, inputEl) {
	        	var plusInput = listEl.find('.fileuploader-thumbnails-input'),
	        	api = $.fileuploader.getInstance(inputEl.get(0));

	        	plusInput.on('click', function() {
	        		api.open();
	        	});
	        },

	    });

	    

	});
</script>