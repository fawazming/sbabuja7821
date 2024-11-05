<div class="col-lg-6 d-flex flex-column content-right">
	<div class="container my-auto py-5">
		<div class="row mb-5">
			<div class="col-12">
				<a hx-get="<?=base_url('vendors')?>" hx-target="#app" hx-swap="replace"><button type="button" class="forward">Buy Pin via Vendors</button></a>
				<a href="<?=base_url('payonline')?>"><button type="button" class="forward">Buy Pin Online</button></a>
			</div>
			
		</div>
		<div class="row"><br><br>
			<div class="col-lg-9 col-xl-7 mx-auto" id="app">
				<form hx-get="<?=base_url('pin')?>" hx-target="#app" hx-swap="replace"
					style="display: flex; flex-direction: column; align-items: center; width: 100%;">
				<h3 class="main_question">Input your pin to proceed</h3>
					<div class="mb-3 row" style="align-items: center;">
						<label for="inputName" class="col-sm-1-12 col-form-label">Pin:</label>
						<div class="col-sm-1-12">
							<input type="text" class="form-control" style="width: 200px;" name="pin" id="pin"
								placeholder="e.g N097C" required>
						</div>
					</div>
					<div class="mb-3 row">
						<div class="text-center">
							<button type="submit" class="btn btn-primary">Begin Registeration</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="container copy">
		<span class="float-start">© SB HIC</span>
		<a class="btn_help float-end" href="https://wa.me/+2348108097322" target="_blank"><i
				class="bi bi-question-circle"></i>Help</a>
		<a class="btn_help float-end" href="#modal-pStatus" id="modal_p"><i class="bi bi-question-circle"></i>Pin Status
			&nbsp; &nbsp; &nbsp;</a>
		<br>
	</div>
	<center style="margin-top: 0px;">Designed with ❤️ by <a href="https://rayyantech.sgm.ng">Rayyan Technologies</a>
	</center>

</div>