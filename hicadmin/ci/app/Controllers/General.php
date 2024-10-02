<?php

namespace App\Controllers;

class General extends BaseController
{
	public function index()
	{
		$session = session();
		$logged_in = $session->get('admin_logged_in');
		if ($logged_in) {
			return redirect()->to(base_url('stat/dashboard'));
		}else if($session->get('vendor_logged_in')){
			return redirect()->to(base_url('vendor/dashboard'));
		}else {
			echo view('loginOptions');
		}
	}
}