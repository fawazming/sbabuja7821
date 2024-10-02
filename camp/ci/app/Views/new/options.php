
<div class="col-lg-6 d-flex flex-column content-right">
				<div class="container my-auto py-5">
                <div class="row">
                <a href="<?=base_url('buypin')?>"><button type="button" class="forward">Buy Pin</button></a>
                </div>
					<div class="row"><br><br><br>
						<div class="col-lg-9 col-xl-7 mx-auto" id="app">
							<h3 class="main_question">Input your pin to proceed</h3>
							<form hx-get="<?=base_url('pin')?>" hx-target="#app" hx-swap="replace" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
								<div class="mb-3 row" style="align-items: center;">
									<label for="inputName" class="col-sm-1-12 col-form-label">Pin:</label>
									<div class="col-sm-1-12">
										<input type="text" class="form-control" style="width: 200px;" name="pin" id="pin" placeholder="e.g N097C" required>
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
				<div class="container pb-4 copy">
					<span class="float-start">© SB HIC</span>
					<a class="btn_help float-end" href="#modal-help" id="modal_h"><i class="bi bi-question-circle"></i>Help</a>
					<a class="btn_help float-end" href="#modal-pStatus" id="modal_p"><i class="bi bi-question-circle"></i>Pin Status &nbsp; &nbsp; &nbsp;</a>
                    <br>
				</div>
			</div>