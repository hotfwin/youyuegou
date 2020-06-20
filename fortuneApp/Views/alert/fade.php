<?php if($message=\Config\Services::session()->getFlashdata('message')): ?>
	<div class="col-md-12">
		<?php if(\Config\Services::session()->getFlashdata('type')): ?>
			<div class="alert alert-success alert-outline alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success!</strong> <?=$message?>
			</div>
		<?php else: ?>
			<div class="alert alert-danger alert-outline alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Danger! Oh snap!</strong> <?=$message?>
			</div>
		<?php endif;?> 

		<!-- <div class="alert alert-warning alert-outline alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Warning!</strong> Best check yo self, you're not looking too good.
		</div>

		<div class="alert alert-primary alert-outline alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Primary!</strong> Best check yo self, you're not looking too good.
		</div>

		<div class="alert alert-info alert-outline alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Info!</strong> Best check yo self, you're not looking too good.
		</div>

		<div class="alert alert-default alert-outline alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Default!</strong> Best check yo self, you're not looking too good.
		</div>	 -->				

	</div>
<?php endif; ?>