</div>

<!-- BEGIN: Page content-->
<div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<a class="btn btn-secondary" href="<?=base_url('vendor/calibrate')?>" role="button">Calibrate Pin</a>
					</div>
					<div class="row">
						<div class="col text-center">
							<div class="easypie" data-percent="100" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?=($tpin) ?></span></div>
							<h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Total Pin</h6>
						</div>
						<div class="col text-center">
							<div class="easypie" data-percent="<?=($spin/10) ?>" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?=($spin) ?></span></div>
							<h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Sold pin</h6>
						</div>
						<div class="col text-center">
							<div class="easypie" data-percent="<?=($upin/10) ?>" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?=($upin) ?></span></div>
							<h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Used pin</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h6>Share Pin</h6>
			<div class="container">
				<p>Last cursor: <?=$cursor?></p>
				<form action="<?=base_url('vendor/sharepin')?>" method="post">
					<div class="mb-3 row">
						<label for="range" class="col-sm-1-12 col-form-label">Range</label>
						<div class="col-sm-1-12">
							<input type="text" class="form-control" name="range" id="range" placeholder="">
						</div>
					</div>
					<!-- <div class="mb-3 row">
						<label for="range" class="col-sm-1-12 col-form-label">Worth</label>
						<div class="col-sm-1-12">
							<input type="text" class="form-control" name="worth" id="range" placeholder="Amount :: 6500,9500">
						</div>
					</div> -->
					<div class="mb-3 row">
						<label for="user" class="col-sm-1-12 col-form-label">Vendor</label>
						<div class="col-sm-1-12">
							<select class="form-control" name="user" id="">
								<option>Select a vendor</option>
								<?php foreach ($vendors as $key => $vendor):?>
									<option value="<?=$vendor['name']?>"><?=$vendor['name']?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<div class="offset-sm-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Share</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-4">
		<h6>Log update</h6>
			<div class="container">
				<form action="<?=base_url('vendor/logupdate')?>" method="post">
				<div class="mb-3 row">
						<label for="user" class="col-sm-1-12 col-form-label">Vendor</label>
						<div class="col-sm-1-12">
							<select class="form-control" name="user" id="">
								<option>Select a vendor</option>
								<?php foreach ($vendors as $key => $vendor):?>
									<option value="<?=$vendor['name']?>"><?=$vendor['name']?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
						<div class="mb-3">
						  <label for="" class="form-label">Log</label>
						  <textarea class="form-control" name="log" id="log" rows="3"><?php foreach ($vendors as $key => $vendor):?> <?=$vendor['name']?>: <?=$vendor['log']?><?php endforeach; ?></textarea>
						</div>
					<div class="mb-3 row">
						<div class="offset-sm-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-4">

		</div>
	</div>
</div>
</div>

</div>
<!-- END: Page content-->

<!-- BEGIN: Page backdrops-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
	<div class="page-preloader">Loading</div>
</div><!-- END: Page backdrops-->
