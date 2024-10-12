</div>
<!-- /row -->
</div>
<!-- /container -->

<nav>
	<ul class="cd-primary-nav">
		<li><a href="#!" class="animated_link"></a></li>
	</ul>
</nav>
<!-- /menu -->

<div class="cd-overlay-nav">
	<span></span>
</div>
<!-- /cd-overlay-nav -->

<div class="cd-overlay-content">
	<span></span>
</div>
<!-- /cd-overlay-content -->

<!-- <a href="#0" class="cd-nav-trigger">Menu<span class="cd-icon"></span></a> -->
<!-- /menu button -->

<div class="panel" id="panel_info">
	<div class="panel__content">
		<a href="#" class="close_panel">
			<i class="bi bi-x-circle"></i>
		</a>
		<div class="container">
			<h2 class="mb-5">HIC Program Schedule</h2>

			<section class="wrapper">
				<div class="container py-10">
					<!-- /.row -->
					<div class="strip_info">
					<div class="row gx-lg-8 gx-xl-12 gy-8 mb-14 mb-md-17" id="ourW">
					</div>
					</div>
				</div>
				<!-- /.container -->
			</section>
		</div>
	</div>
</div>
<!-- /panel_info  -->

<!-- Modal terms -->
<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="termsLabel">Privacy data terms</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>,
					mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus,
					pro ne quod dicunt sensibus.</p>
				<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam
					dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt
					sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum
					accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum
					sanctus, pro ne quod dicunt sensibus.</p>
				<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam
					dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt
					sensibus.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn_1" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Help form Popup -->
<div id="modal-help" class="custom-modal zoom-anim-dialog mfp-hide">
	<div class="small-dialog-header">
		<h3>Ask Us Anything</h3>
		<p class="mb-3">Please fill the form with your questions and<br>we will reply soon!</p>
	</div>
	<div id="message-help"></div>
	<form method="post" action="phpmailer/help.php" id="helpform" autocomplete="off">
		<div class="modal-wrapper">
			<div class="mb-3 form-floating">
				<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name">
				<label for="fullname">Full Name</label>
			</div>
			<div class="mb-3 form-floating">
				<input type="email" name="email_help" id="email_help" class="form-control" placeholder="Email Address">
				<label for="email_help">Email Address</label>
			</div>
			<div class="mb-3 form-floating">
				<textarea name="message_help" id="message_help" class="form-control short"
					placeholder="Your Message"></textarea>
				<label for="message_help">Your Message</label>
			</div>
			<div class="mb-5 form-floating">
				<input class="form-control" type="text" name="verify_help" id="verify_help"
					placeholder="Are you human? 3 + 1 =">
				<label for="verify_help">Are you human? 3 + 1 =</label>
			</div>
			<div class="text-center submit"><input type="submit" value="Submit" class="btn_1" id="submit-help">
			</div>
		</div>
	</form>
</div>
<!-- /Help form Popup -->
<div id="loading" style="display:none;">
	<img src="<?=base_url('assets/puff.svg')?>" />
</div>
<!-- pStatus form Popup -->
<div id="modal-pStatus" class="custom-modal zoom-anim-dialog mfp-hide">
	<div class="small-dialog-header">
		<h3>Input your pin</h3>
		<p class="mb-3">Use this form to check if your form is valid or not</p>
	</div>
	<div id="message-help"></div>
	<div class="container">
		<form hx-get="<?=base_url('pinstat')?>" hx-target="#app" hx-indicator="#loading" hx-swap="replace"
			hx-trigger="submit" hx-reset="true"
			style="display: flex; flex-direction: column; align-items: center; width: 100%;">
			<div class="mb-3 " style="align-items: center;">
				<label for="inputName" class="col-sm-1-12 col-form-label">Pin:</label>
				<input type="text" class="form-control" required name="pin" id="pin" placeholder="e.g iop0842">
			</div>
			<div class="mb-3 row">
				<div class="text-center">
					<button type="submit" class="btn btn-primary">Check Pin</button>
				</div>
			</div>
		</form>
		<div id="app"></div>
	</div>
</div>
<!-- /pStatus form Popup -->

<!-- COMMON SCRIPTS -->
<script src="<?= base_url('assets/js/jquery-3.7.0.min.js')?>"></script>
<script src="<?= base_url('assets/js/common_scripts.min.js')?>"></script>
<script src="<?= base_url('assets/js/velocity.min.js')?>"></script>
<script src="<?= base_url('assets/js/functions.js')?>"></script>
<script src="<?= base_url('assets/js/validate.js')?>"></script>
<script src="<?= base_url('assets/js/htmx.js')?>"></script>
<script>
	async function fetchData() {
	const baseUrl = 'https://sheet.spacet.me'
	const sheetId = '1pQPTTC-lg4jaNbvFx8R-5tqHb8_YqZM4yY6OerJLj8k'
	const sheetName = 'Sheet1'
	const endpoint = `${baseUrl}/${sheetId}/${sheetName}.json`
	const { values } = await fetch(endpoint)
	  .then(response => {
		if (!response.ok) {
		  throw new Error('Unable to load data from ' + endpoint)
		}
		return response.json()
	  })
	const [header, ...rows] = values
	return rows.map(row => {
	  const entries = header.map((key, i) => [key, row[i]])
	  return Object.fromEntries(entries)
	})
  }
  
  let ourW = document.querySelector('#ourW');
  
  fetchData()
  .then((data)=>{
	let all = ``
	let tempcol1 = '';
	for (let i = 0; i < data.length; i++) {
	  let col1 = data[i].DAY
	  let col2 = `${data[i].TIME}`
	  let col3 = `${data[i].ACTIVITY}`
  
	  if(col1 != '' && col1 == undefined){
		let prog = `<div class="col-md-6 col-lg-4 mb-4">
			  <div class="d-flex flex-row">
				<div>
				</div>
				<div>
				  <h4 class="mb-1">THE DAY HAS ENDED</h4>
				  <p class="mb-0">----==-----</p>
				</div>
			  </div>
			</div>`
		all+=`${prog}`
	  }else if(col1 != ''){
		tempcol1 = col1;
		let prog = ''
  
		prog = `<div class="col-md-6 col-lg-4 mb-4">
			  <div class="d-flex flex-row">
				<div>
				</div>
				<div>
				  <h4 class="mb-1">${col1},${col2}</h4>
				  <p class="mb-0">${col3}</p>
				</div>
			  </div>
			</div>`
		all+=`${prog}`
	  }else{
		let prog = ''
  
		prog = `<div class="col-md-6 col-lg-4 mb-4">
			  <div class="d-flex flex-row">
				<div>
				</div>
				<div>
				  <h4 class="mb-1">${tempcol1},${col2}</h4>
				  <p class="mb-0">${col3}</p>
				</div>
			  </div>
			</div>`
		all+=`${prog}`
	  }
	}
	ourW.innerHTML = all
  
  
  // console.log(all)
	// console.log(data[10])
  }
  )
  </script>

</body>

</html>