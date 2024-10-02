<?php

namespace App\Controllers;

class Vendor extends BaseController
{
	public function index()
	{
		$session = session();
		$logged_in = $session->get('vendor_logged_in');
		if ($logged_in) {
			return redirect()->to(base_url('vendor/dashboard'));
		} else {
			echo view('vendor/login');
		}
	}

	public function auth()
	{
		$session = session();
		$Vendors = new \App\Models\Vendors();
		$uname = $this->request->getPost('username');

		if ($res = $Vendors->where('access_code', $uname)->find()) {
			$newdata = array(
				'admin' => $res[0]['name'],
				'admincode' => $uname,
				'clear' => $res[0]['clearance'],
				'vendor_logged_in' => TRUE
			);
			$session->set($newdata);
			return redirect()->to(base_url('vendor/dashboard'));
		} else {
			return redirect()->to(base_url('vendor/'));
		}
	}

	public function logout()
	{
		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			session()->destroy();
			return redirect()->to(base_url('vendor/'));
		} else {
			echo view('vendor/login');
		}
	}

	public function dashboard()
	{
		// echo('dashboard');	
		$logged_in = session()->get('vendor_logged_in');
		$Pins = new \App\Models\Pins();
		$Vendors = new \App\Models\Vendors();
		if ($logged_in) {
			$headerdata = [
				'admin' => session()->get('admin'),
				'clear' => session()->get('clear'),
				'admin_code' => session()->get('admincode'),
			];

			$data = array(
				'pins' => $Pins->where('vendor', session()->get('admin'))->find(),
				'log' => $Vendors->where('name', session()->get('admin'))->find()[0]['log']
			);

			echo view('vendor/header', $headerdata);
			echo view('vendor/dashboard', $data);
			echo view('vendor/footer');
		} else {
			echo view('vendor/login');
		}
	}

    public function manual()
    {
        // echo('dashboard');
        $logged_in = session()->get('vendor_logged_in');
        $Pins = new \App\Models\Pins();
        $Vendors = new \App\Models\Vendors();
        if ($logged_in) {
            $vendor = $Vendors->where('name', session()->get('admin'))->find()[0];
            $headerdata = [
                'admin' => session()->get('admin'),
                'clear' => session()->get('clear'),
                'admin_code' => session()->get('admincode'),
            ];

            $client = \Config\Services::curlrequest();

            $response = $client->request('GET', 'https://opensheet.elk.sh/1YD3D_WsBJxO6r91A9QPWK-C1GZWkUuElziA0Z1vRAZM/pmc'.$vendor['sheet']);
            $res = json_decode($response->getBody());
            // var_dump($res);

            $data = array(
                'dels' => $res,
                'reg' => count($res),
                'link' => $vendor['log'],
                'locked' => $vendor['locked'],
                'sheet' => $vendor['sheet'],
            );

            echo view('vendor/header', $headerdata);
            echo view('vendor/manual', $data);
            echo view('vendor/footer');
        } else {
            echo view('vendor/login');
        }
    }

    public function sync($sheet)
    {
        $logged_in = session()->get('vendor_logged_in');
        if ($logged_in) {
            $Vendors = new \App\Models\Vendors();
            $vend =$Vendors->where('sheet',$sheet)->find()[0];
            $vID = $vend['id'];

            if($vend['locked']){
                echo "You are locked out. Contact Registrar <a href='javascript:history.back()'>Go Back</a>";
                return redirect()->back();
            }else{

                $client = \Config\Services::curlrequest();

                $response = $client->request('GET', 'https://opensheet.elk.sh/1YD3D_WsBJxO6r91A9QPWK-C1GZWkUuElziA0Z1vRAZM/pmc'.$sheet);
                $res = json_decode($response->getBody());

                $Delegates = new \App\Models\Delegates();

                $allDel = [];
                foreach ($res as $key => $delegate){
                    $dt = [
                        'fname' =>$delegate->fname,
                        'lname' =>$delegate->lname,
                        'lb' =>$delegate->lb,
                        'phone' =>$delegate->{'phone '},
                        'email' =>$delegate->email,
                        'category' =>$delegate->category,
                        'school' =>$delegate->school,
                        'ref' =>'m',
                        'old' => 0,
                        'paid' =>'',
                        'gender' =>$delegate->gender,
                        'org' =>$delegate->org,
                    ];
                    array_push($allDel, $dt);
                }
                if(count($allDel) > 0){
                    $Delegates->insertBatch($allDel);
                }
                $Vendors->update($vID, ['locked' => 1,]);
                 echo "Data uploaded to CAMP DB. Ensure you remove these set of data from Google Spreadsheet to avoid duplication. <a href='javascript:history.back()'>Go Back</a>";
                return redirect()->back();

             }
        } else {
            echo view('vendor/login');
        }
    }


    public function lock($vID)
    {
        $logged_in = session()->get('vendor_logged_in');
        if ($logged_in) {
            $Vendors = new \App\Models\Vendors();
            $vend =$Vendors->where('id',$vID)->find()[0];

            if($vend['locked']){
                $Vendors->update($vID, ['locked' => 0,]);
            }else{
                $Vendors->update($vID, ['locked' => 1,]);
             }
             return redirect()->back();
        } else {
            echo view('vendor/login');
        }
    }

	public function sellpin()
	{
		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			$incoming = $this->request->getGet('pn');
			$Pins = new \App\Models\Pins();

			$Pins->update($incoming, ['sold' => '1']);
			return redirect()->back();
		} else {
			echo view('vendor/login');
		}
	}

	public function sharepin()
	{
		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			$incoming = $this->request->getPost();
			$range = explode('-',$incoming['range']);
			$user = $incoming['user'];
			// $worth = $incoming['worth'];
			
			$Pins = new \App\Models\Pins();
			$Vendors = new \App\Models\Vendors();
			for ($i=$range[0]; $i < ($range[1]+1); $i++) { 
				$Pins->update($i, ['vendor' => $user]);
			}
			$vend = $Vendors->where('name', $user)->find()[0];
			$vendID = $vend['id'];
			$vendedPin = $vend['pins'];
			$val = ($range[1] - $range[0]) + 1;
			$Vendors->update($vendID, ['pins' => ($vendedPin + $val)]);
			return redirect()->back();
		} else {
			echo view('vendor/login');
		}
	}

	public function logupdate()
	{
		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			$incoming = $this->request->getPost();
			$user = $incoming['user'];
			
			$Vendors = new \App\Models\Vendors();
			$vendID = $Vendors->where('name', $user)->find()[0]['id'];
			$Vendors->update($vendID, ['log' => $incoming['log']]);
			return redirect()->back();
		} else {
			echo view('vendor/login');
		}
	}

	public function resetPin()
	{
		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			$Pins = new \App\Models\Pins();
			for ($i=0; $i < 1001; $i++) { 
				$Pins->update($i+1, ['used' => 'no']);
			}
			return redirect()->back();
		} else {
			echo view('vendor/login');
		}
	}

	public function calibrate()
	{
		// $logged_in = session()->get('vendor_logged_in');
		// if ($logged_in) {
		// 	$Pins = new \App\Models\Pins();
		// 	$Delegates = new \App\Models\Delegates();

		// 	$allPined = $Delegates->findAll();
		// 	$allPins = $Pins->findAll();
		// 	foreach ($allPined as $key => $alp) {
		// 		// $Pins->where('pin',$alp['ref'])->update(['used' => 'yes']);
		// 		var_dump($alp);
		// 		$pinID = $Pins->where('pin',$alp['ref'])->find()[0]['id'];
		// 		var_dump($pinID);
		// 		$Pins->update($pinID,['used' => 'yes']);
		// 	}
		// 	return redirect()->back();
		// } else {
		// 	echo view('vendor/login');
		// }

		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			$Pins = new \App\Models\Pins();
			$Delegates = new \App\Models\Delegates();

			$allPined = $Delegates->findAll();
			$allPins = $Pins->findAll();
			foreach ($allPined as $key => $alp) {
				// $Pins->where('pin',$alp['ref'])->update(['used' => 'yes']);
				var_dump($alp);
				$pinID = $Pins->where('pin',$alp['ref'])->find()[0]['id'];
				var_dump($pinID);
				$Pins->update($pinID,['used' => '1']);
			}
			return redirect()->back();
		} else {
			echo view('vendor/login');
		}
	}


	public function special()
	{
		$logged_in = session()->get('vendor_logged_in');
		if ($logged_in) {
			$Pins = new \App\Models\Pins();
			$Vendors = new \App\Models\Vendors();
			$headerdata = [
				'admin' => session()->get('admin'),
				'clear' => session()->get('clear'),
				'admin_code' => session()->get('admincode'),
			];

			$data = [
				'tpin' => $Pins->countAll(),
				'spin' => $Pins->where('sold','1')->countAllResults(),
				'upin' => $Pins->where('used','yes')->countAllResults(),
				'vendors' => $Vendors->findAll(),
				'cursor' => $Pins->where('vendor','new')->first()['id']
			];

			echo view('vendor/header', $headerdata);
			echo view('vendor/special', $data);
			echo view('vendor/footer');
		} else {
			echo view('vendor/login');
		}
	}


    public function tag()
    {
        $logged_in = session()->get('vendor_logged_in');
        if ($logged_in) {
            $Pins = new \App\Models\Pins();
            $Delegates = new \App\Models\Delegates();
            $Vendors = new \App\Models\Vendors();
            $headerdata = [
                'admin' => session()->get('admin'),
                'clear' => session()->get('clear'),
                'admin_code' => session()->get('admincode'),
            ];

            $data = [
                'tdel' => $Delegates->countAll(),
                'rpin' => $Pins->where('vendor','Remo')->countAllResults(),
                'ipin' => $Pins->where('vendor','Ijebu')->countAllResults(),
                'epin' => $Pins->where('vendor','Egba')->countAllResults(),
                'aapin' => $Pins->where('vendor','AdoOdo')->countAllResults(),
                'opin' => $Pins->where('vendor','online')->countAllResults(),
                'spin' => $Pins->where('sold','1')->countAllResults(),
                'upin' => $Pins->where('used','1')->countAllResults(),
                'vendors' => $Vendors->findAll(),
                'cursor' => $Pins->where('vendor','new')->first()['id'],
                // 'locked' => 0,
            ];

            echo view('vendor/header', $headerdata);
            echo view('vendor/tag', $data);
            echo view('vendor/footer');
        } else {
            echo view('vendor/login');
        }
    }


    public function printtag()
    {
        $logged_in = session()->get('vendor_logged_in');
        if ($logged_in) {
            $incoming = $this->request->getPost();
            $range = explode('-',$incoming['range']);

            $Delegates = new \App\Models\Delegates();
            $del = '';
            if(count($range)==1){
                $del = $Delegates->where('id',$range[0])->find();
            }else{
                $del = [];
                for ($i=$range[0]; $i < ($range[1]+1); $i++) {
                   array_push($del,$Delegates->where('id', $i)->find());
                }
            }

            echo view('vendor/tags', ['del'=>$del]);
        } else {
            echo view('vendor/login');
        }
    }

	public function uniqidReal($lenght = 4) {
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			echo("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}

    public function samp()
    {

    	//  $Pins = new \App\Models\Pins();

        // for ($i=1; $i <= 2000; $i++) {
        //     $p = strtoupper($this->uniqidReal(8));
        //     echo ($i.' '.$p.'<br>');
        //     $id = $Pins->insert(['pin'=> $p, 'used'=>0,'vendor'=>'new','sold'=>0,'worth'=>'0']);

        // }
    }

    // https://opensheet.elk.sh/1YD3D_WsBJxO6r91A9QPWK-C1GZWkUuElziA0Z1vRAZM/pmca

	//--------------------------------------------------------------------

}
