<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Logic extends BaseController
{
	use ResponseTrait;
    // protected $modelName = Delegates23::class;
    protected $format = 'json';
    
    private $categories = [
        'professionals' => 12605,
        'undergraduate' => 12604,
        'school_leaver' => 12600,
        'secondary_school_student' => 10100,
        'test' => 100,
    ];

    public function idsearchj()
    {
        // Get query parameters
        $name = $this->request->getGet('name');
        $gender = $this->request->getGet('gender');
        $class = $this->request->getGet('class');
        $id = $this->request->getGet('sbid');
        $lb = $this->request->getGet('lb');
        $category = $this->request->getGet('category');

        // Build query with filters if provided
        $builder = new \App\Models\Delegates23();;

        if ($name && strlen($name) > 3) {
            $builder->groupStart()
                    ->like('fname', $name)
                    ->orLike('lname', $name)
                    ->groupEnd();
        }
        if ($lb) {
            $builder->groupStart()
                    ->like('lb', $lb)
                    ->groupEnd();
        }
        if ($id) {
            $builder->where('id',$id);
        }
        if ($gender) {
            $builder->where('gender', $gender);
        }
        if ($class) {
            $builder->where('lb', $zone);
        }
        if ($category) {
            $builder->where('category', $category);
        }

        $results = $builder->get()->getResult();

        // Return JSON response
        return $this->respond($results);
    }

    public function modern() {
    }

    public function modern2() {
        echo view('modern/hom');
    }


	public function index()
	{
        echo view('modern/header');
        echo view('modern/home');
		echo view('modern/footer');
	}

	public function idsearch()
	{
        echo view('modern/header');
        echo view('modern/idsearch');
		echo view('modern/footer');
	}


	public function register()
	{
        echo view('modern/header');
        echo view('modern/register');
		echo view('modern/footer');
	}


    public function pregister()
    {
        $incoming = $this->request->getPost();
        $client = \Config\Services::curlrequest();

        $url = $_ENV['gateway'].'/api/authorize';
        $amount = explode('|',$incoming['category'])[1];
        $headers = [
            'Authorization' => 'Bearer '.$_ENV['st'],
            'api-key' => $_ENV['ak'],
            'Content-Type' => 'application/json',
        ];

        $data = [
            'email' => $incoming['email'],
            'amount' => $amount,
            'callback' => $_ENV['callback'],
        ];

        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $data,
            ]);

            $body = $response->getBody();
            $result = json_decode($body);

            #insert data in DB
            $pgtrans = new \App\Models\PgtransactionsModel();
            $pgtrans->insert(['business_id'=>$_ENV['bid'],'access_code'=>$result->data->access_code, 'customer_phone'=>$result->data->reference, 'callback_url'=>$data['callback'], 'amount'=>$data['amount']]);

            if (isset($result->data->authorization_url)) {
                // Redirect to the authorization_url
                return redirect()->to($result->data->authorization_url);
            } else {
                // Handle missing authorization_url
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Authorization URL not found in response',
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function notif() {
        echo view('modern/header');
        echo view('modern/notif');
        echo view('modern/footer');
    }


    public function cregister() {
        $ref1 = $this->request->getGet()['ref'];
        $ref = substr($ref1, 3);

        $pgModel = new \App\Models\PgtransactionsModel();

        // Call the /verifypro/$ref endpoint to get verification data
        $verifyUrl = $_ENV['gateway']."/verifypro/".$ref1;

        // Use CodeIgniter HTTP client to call the verifypro endpoint
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get($verifyUrl);

            if ($response->getStatusCode() !== 200) {
                return redirect()->to('/notification')->with('error', 'Verification failed.');
            }

            $verifyData = json_decode($response->getBody(), true)['data'];


            if (!$verifyData) {
                return redirect()->to('/notification')->with('error', 'Invalid verification response.');
            }

            // Fetch existing transaction by transaction_id (assuming $ref is transaction_id)
            $existingTransaction = $pgModel->where('customer_phone',$ref)->first();

            if (!$existingTransaction) {
                return redirect()->to('/notification')->with('error', 'Transaction not found.');
            }

            // Compare amount, access_code, business_id
            if (
                floatval($existingTransaction['amount']) !== floatval($verifyData['amount']) ||
                $existingTransaction['access_code'] !== $verifyData['access_code'] ||
                $existingTransaction['business_id'] !== $verifyData['business_id']
            ) {
                return redirect()->to('/notification')->with('error', 'Transaction data mismatch.');
            }

            // Update the transaction with incoming data from verifyData
            // Filter only allowed fields to update
            $updateData = [];

            $allowedFields = $pgModel->allowedFields;

            foreach ($allowedFields as $field) {
                if (isset($verifyData[$field])) {
                    $updateData[$field] = $verifyData[$field];
                }
            }

            $rr = $pgModel->set($updateData)->where('customer_phone',$ref)->update();

            // Determine category for registration completion form
            // Assuming category is part of verifyData or you can set default

            $category = $this->getCategoryByAmount($verifyData['amount']);
            // dd($category);

            // Load the registration completion form view based on category
            // Pass any data needed to the view

            echo view("modern/header");
            echo view("modern/creg", [
                'email' => $verifyData['email'],
                'category' => $category,
                'ref' => $ref1,
            ]);
            echo view("modern/footer");
        } catch (\Exception $e) {
            // Log error if needed
            log_message('error', 'Payment confirmation error: ' . $e->getMessage());
            return redirect()->to('/notification')->with('error', 'An error occurred during payment confirmation.');
        }
        
    }

    /**
     * Determine category based on amount
     *
     * @param int|float $amount
     * @return string
     */
    public function getCategoryByAmount($amount)
    {
        foreach ($this->categories as $category => $price) {
            if ($price == $amount) {
                return $category;
            }
        }

        return 'no category';
    }
    
	public function registration()
	{
		$incoming = $this->request->getPost();
        $Delegates23 = new \App\Models\Delegates23();
        
        $house = $this->generateHouse($incoming['gender']);
        $incoming['house'] = $house;
        $id = $Delegates23->insert($incoming);
        // $Pins->update($pin['id'],['used'=>'1']); Update the transaction ID as used
        return redirect()->to('/notification')->with('success', 'Congratulations! Your registration was successful <br> Reg. No: <b> '.$id.'</b> <br> Your house is <b>'.$house.'</b>');
        // $this->msg('Congratulations! Your registration was successful <br> Reg. No: <b> '.$id.'</b> <br> Your house is <b>'.$house.'</b>');
    		
	}
 
    // public function generateHouse($gender)
    // {
    //     $mHouses = ['Abu Bakr', 'Umar', 'Uthman', 'Alli'];
    //     $fHouses = ['Khadijah', 'Aishah', 'Ummu Khultum', 'Ummu Salamah'];
    //     if($gender=='male'){
    //         $key = array_rand($mHouses);
    //         return $mHouses[$key];
    //     }else{
    //         $key = array_rand($fHouses);
    //         return $fHouses[$key];
    //     }
    // }

	public function buypin()
	{
        echo view('header');
        echo view('buypin');
		echo view('footer');
	}

    public function payonline()
    {
        echo view('new/header');
        echo view('new/payonline');
        echo view('new/footer');
    }

	public function pinstatus()
	{
        echo view('header');
        echo view('pinstatus');
		echo view('footer');
	}

	public function vendors()
	{
        $Vendors = new \App\Models\Vendors();
        $vendors = $Vendors->find();
        // echo view('header');
		echo view('vendors',['vendors'=>$vendors]);
        // echo view('footer');
	}

	public function msg($mg = "Hello")
	{
		echo view('new/msg', ['mg' => $mg]);
	}

	public function pin()
	{
		$incoming = $this->request->getGet();
		$Pins = new \App\Models\Pins();
		$Variables = new \App\Models\Variables();
        $varData = ['lb'=> explode(',',$Variables->where('name','lb')->find()[0]['value'])];
		if($value = $Pins->where(['pin'=>$incoming['pin'],'used !='=>1])->find()){
			echo view('home',['ref'=>$incoming['pin'], 'pinworth'=>$value[0]['worth'], 'var'=>$varData] );

		}else{
			$this->msg("The pin you entered is invalid");
		}
	}

	public function pinstat()
	{
		$incoming = $this->request->getGet();
		$Pins = new \App\Models\Pins();

		$value = $Pins->where(['pin'=>$incoming['pin']])->find();
        if($value != null){
		echo ("Is this pin ".$incoming['pin']." used? ". $this->boolconv($value[0]['used']));
        }else{
            echo("The Pin ".$incoming['pin']." is invalid");
        }
	}

    private function boolconv($v)
    {
        switch ($v) {
            case '0':
                return 'No';
                break;

            case '1':
                return 'Yes';
                break;

            default:
                return 'Unknown';
                break;
        }
    }

	public function registratio()
	{
		$incoming = $this->request->getPost();
		$Pins = new \App\Models\Pins();
        $Delegates23 = new \App\Models\Delegates23();
		// $Delegates22 = new \App\Models\Delegates22();
        if(isset($incoming['lcamp']) && $incoming['lcamp'] == 'on'){
            // $wdata = [
            //     'fname' => $incoming['fname'],
            //     'lname' => $incoming['lname'],
            //     'lb' => $incoming['lb'],
            // ];
            // $res = $Delegates22->where($wdata)->find();
            // if($res){
            //     echo view('header');
            //     echo view('home2',['udata'=>$res[0],'ref'=>$incoming['ref'], 'catg' =>$incoming['category'] ]);
            //     echo view('footer');
            // }else{
            //     echo view('header');
            //     echo view('home',['ref'=>$incoming['ref'], 'catg' =>$incoming['category']]);
            //     echo view('footer');
            // }

        }else{
            $pin = $Pins->where('pin',$incoming['ref'])->find()[0];
            if($pin['used'] == 1){
                $this->msg('Sorry, this pin has been used.');
            }else{
              $house = $this->generateHouse($incoming['gender']);
              $incoming['house'] = $house;
    		  $id = $Delegates23->insert($incoming);
    		  $Pins->update($pin['id'],['used'=>'1']);
    		  $this->msg('Congratulations! Your registration was successful <br> Reg. No: <b> '.$id.'</b> <br> Your house is <b>'.$house.'</b>');
    		}
        }
	}

    public function generateHouse($gender)
    {
        $mHouses = ['Abu Bakr', 'Umar', 'Uthman', 'Alli'];
        $fHouses = ['Khadijah', 'Aishah', 'Ummu Khultum', 'Ummu Salma'];
        if($gender=='male'){
            $key = array_rand($mHouses);
            return $mHouses[$key];
        }else{
            $key = array_rand($fHouses);
            return $fHouses[$key];
        }
    }

	public function sms()
	{
		$incoming = $this->request->getJSON();
		$Alerts = new \App\Models\Alerts();
		$res = $Alerts->insert(['message' => $incoming->message]);

		$data = [
			'message' => 'created' . $res
		];
		if ($res) {
			return $this->respond($data, 200);
		} else {
			return $this->respond(['message' => 'Not Added'], 400);
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
        echo ($this->generateHouse('female'));
        // echo ($this->uniqidReal(16));

	}

    public function vend($vendor)
    {
        $Pins = new \App\Models\Pins();
        $pp = $Pins->where(['sold'=>0, 'used'=>0, 'vendor'=>'new'])->limit(10)->find();
        // var_dump($pp);
        echo ('20 Pins for vendor '.$vendor.'<br>');
        foreach ($pp as $key => $pin) {
            $Pins->update($pin['id'], ['sold'=>1, 'vendor'=>$vendor]);
            echo ($pin['pin'].'<br>');
        }

    }

    public function proceedOnline()
    {
        $Tranx = new \App\Models\Tranx();
       $incoming = $this->request->getPost();
    //    $amt = 510000;
       $payData = $this->Pay($incoming['email'], $incoming['name']);
       if($payData == "Please Check back later"){
        echo "Please Check back later";
       }else{
       $payment = $payData['payment']; //stdClass
       $user = $payData['user']; //Array
    //    dd($payData);
        // $ = json_decode($payment['response']);
        // $payRef = $payment['ref'];
        $data = [
            'email' => $incoming['email'],
            'status' => 'Intialize',
            'ref' => $payment->trackingReference,
            'url' => $payment->expire_date
        ];
        $Tranx->insert($data);
        echo view('new/header');
        echo view('new/transferPage', ['payment'=>$payment, 'user'=>$user]);
        echo view('new/footer');
        // return redirect()->to($payData->data->checkout_url);
    }
    }

    private function Pay($email, $name)
    {
         $client = \Config\Services::curlrequest();
 
         $response = $client->request('POST', 'https://api.payvessel.com/api/external/request/customerReservedAccount/', 
             [
                 'headers' => [
                     'api-key' => $_ENV['PVKEY'],
                     'api-secret'     => 'Bearer '.$_ENV['PVSECRET'],
                     'Content-Type'      => 'application/json',
                 ],
                 'json' => [
                     'email' => $email,
                     'name' => $name,
                     'phoneNumber' => '08012345678',
                     'bankcode' => ['120001'],
                     'account_type' => 'DYNAMIC',
                     'businessid' => 'B259B99E0B0F41EE874B9549C40697F8',
                 ],
                 'http_errors' => false
             ]
             );
         $status = $response->getStatusCode();
         if($status < 400){
             $data = [
             'payment' => json_decode($response->getBody())->banks,
             'user' => ['email'=>$email,'name'=>$name]
         ];
         // dd($data);
         return $data;
        } else{
            return "Please Check back later";
        }
    }

    private function sampHook() {

    }

    public function webhook()
    {
        $Alerts = new \App\Models\Alerts();
        $Tranx = new \App\Models\Tranx();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF exemption

            $payload = file_get_contents('php://input');
            $payvessel_signature = $_SERVER['HTTP_PAYVESSEL_HTTP_SIGNATURE'];
            //this line maybe be differ depends on your server
            //$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR']; 
            $ip_address = $_SERVER['REMOTE_ADDR']; 
            $secret = $_ENV['PVSECRET'];
            $hashkey = hash_hmac('sha512', $payload, $secret);
            $ipAddress = ["3.255.23.38", "162.246.254.36"];
            
            
            if ($payvessel_signature == $hashkey && in_array($ip_address, $ipAddress)) {
                $data = json_decode($payload, true);
                $amount = floatval($data['order']['amount']);
                $settlementAmt = floatval($data['order']['settlement_amount']);
                $fee = floatval($data['order']['fee']);
                $ref = $data['transaction']['reference'];
                $stat = $data['order']['description'];
                $settlementAmount = $settlementAmt;

                $incoming = ['data'=>$data, 'amount'=>$amount,'settlementAmt'=>$settlementAmt,'fee'=>$fee,'ref'=>$ref,'stat'=>$stat];

                $id = $Alerts->insert(['message'=>json_encode($incoming), 'linked'=>0]);
                
                $tranx = $Tranx->where('ref',$ref)->find()[0];
                $Tranx->update($tranx['id'], ['status'=>$stat]);
                echo json_encode(["message" => "success"]);
                http_response_code(200);
                // if($dt->stat == 'success'){
                //     $Pins = new \App\Models\Pins();
                //     $pins = $Pins->where('vendor','new')->find()[0];
                //     $Pins->update($pins['id'], ['vendor'=>'online']);
                //     $data = [
                //             'to' => $tranx['email'],
                //             'type' => 'link',
                //             'subject' => 'PMC Pin Purchase Successful',
                //             'message' => ['p1' => 'Al hamdulillah! Your pin purchase was successful.', 'p2'=>'Your Pin is '.$pins['pin'].'', 'p3' => 'Do continue your registeration by visiting https://camp.phfogun.org/register.', 'link'=>'https://camp.phfogun.org/register/'.$pins['pin'].'', 'linktext'=>'Click here to continue your registeration'],
                //         ];
                //         if ($this->mailer($data)) {
                //             $Tranx->update($tranx['id'], ['status'=>$pins['pin']]);
                //         }
                // }

                // Check if reference already exists in your payment transaction table
                // if (!paymentgateway::where('reference', $reference)->exists()) {
                //     // Fund user wallet here
                //     echo json_encode(["message" => "success"]);
                //     http_response_code(200);
                // } else {
                //     echo json_encode(["message" => "transaction already exist"]);
                //     http_response_code(200);
                // }
            } else {
                echo json_encode(["message" => "Permission denied, invalid hash or ip address."]);
                http_response_code(400);
            }
        } else {
            // Handle other HTTP methods if needed
            echo json_encode(["message" => "Method not allowed"]);
            http_response_code(405);
        }

        // $incoming = json_encode($this->request->getVar());
        
    }

    public function webhk()
    {
        $data = [
                    'to' => 'fawazpro27@gmail.com',
                    'type' => 'link',
                    'subject' => 'PMC Pin Purchase Successful',
                    'message' => ['p1' => 'Al hamdulillah! Your pin purchase was successful.', 'p2'=>'Your Pin is 56789', 'p3' => 'Do continue your registeration by visiting https://camp.phfogun.org/register.', 'link'=>'https://camp.phfogun.org/register/', 'linktext'=>'Click here to continue your registeration'],
                ];
               var_dump ($this->mailer($data));
    }

    private function genPayLink($email,$amt)
    {
        $ref = uniqid('phf22_', true);
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.collect.africa/payments/initialize",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\"email\":\"".$email."\",\"amount\":".$amt.",\"reference\":\"".$ref."\"}",
          CURLOPT_HTTPHEADER => [
            "Authorization: Bearer ".$_ENV['paySK']."",
            "accept: application/json",
            "content-type: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return ['response'=>$response,'ref' => $ref];
        }
    }


    public function mailer(array $data)
    {
        $email = \Config\Services::email();
        $email->setFrom('quiz@phfogun.org.ng', 'PHF Camp');
        $email->setTo($data['to']);
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject($data['subject']);
        $email->setMessage($this->message($data['type'], $data['message']));

        if ($email->send()) {
            return 1;
        } else {
            return 0;
        }
        // $this->msg($data['response']);

        echo $email->printDebugger(['headers', 'subject', 'body']);
    }


    public function message($type, $data)
    {
        // $data params
        //  p1 -- Paragraph 1
        //  p2 -- Paragraph 2
        //  p3 -- Paragraph 3
        //  link -- href link
        //  linktext -- Display Text

        if ($type == 'link') {
            $output = "
            <!doctype html>
            <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>PHF Camp</title>
                <style>
                    @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;
                    }

                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                        font-size: 16px !important;
                    }

                    table[class=body] .wrapper,
                    table[class=body] .article {
                        padding: 10px !important;
                    }

                    table[class=body] .content {
                        padding: 0 !important;
                    }

                    table[class=body] .container {
                        padding: 0 !important;
                        width: 100% !important;
                    }

                    table[class=body] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }

                    table[class=body] .btn table {
                        width: 100% !important;
                    }

                    table[class=body] .btn a {
                        width: 100% !important;
                    }

                    table[class=body] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;
                    }
                    }
                    @media all {
                    .ExternalClass {
                        width: 100%;
                    }

                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }

                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }

                    #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                    }

                    .btn-primary table td:hover {
                        background-color: #34495e !important;
                    }

                    .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important;
                    }
                    }
                </style>
            </head>
            <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;' width='100%' bgcolor='#f6f6f6'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi there,</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p1'] . "</p>
                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; width: 100%;' width='100%'>
                                    <tbody>
                                        <tr>
                                        <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;'>
                                            <tbody>
                                                <tr>
                                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #3498db;' valign='top' align='center' bgcolor='#3498db'> <a href='" . $data['link'] . "' target='_blank' style='border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #3498db; border-color: #3498db; color: #ffffff;'>" . $data['linktext'] . "</a> </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p2'] . "</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p3'] . "</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- END CENTERED WHITE CONTAINER -->

                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #999999; font-size: 12px; text-align: center;'>Pure Heart Islamic Foundation, Ogun State</span>

                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>

                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->

                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
            </html>
        ";
        } else if ($type == 'text') {
            // Just one p1
            $output = "
            <!doctype html>
            <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>PHF Camp</title>
                <style>
                    @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;
                    }

                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                        font-size: 16px !important;
                    }

                    table[class=body] .wrapper,
                    table[class=body] .article {
                        padding: 10px !important;
                    }

                    table[class=body] .content {
                        padding: 0 !important;
                    }

                    table[class=body] .container {
                        padding: 0 !important;
                        width: 100% !important;
                    }

                    table[class=body] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }

                    table[class=body] .btn table {
                        width: 100% !important;
                    }

                    table[class=body] .btn a {
                        width: 100% !important;
                    }

                    table[class=body] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;
                    }
                    }
                    @media all {
                    .ExternalClass {
                        width: 100%;
                    }

                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }

                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }

                    #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                    }

                    .btn-primary table td:hover {
                        background-color: #34495e !important;
                    }

                    .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important;
                    }
                    }
                </style>
            </head>
            <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;'>" . substr($data['p1'], 0, 70) . "</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;' width='100%' bgcolor='#f6f6f6'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi there,</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p1'] . "</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- END CENTERED WHITE CONTAINER -->

                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #999999; font-size: 12px; text-align: center;'>Pure Heart Islamic Foundation, Ogun State</span>

                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>

                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->

                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
            </html>
        ";
        }
        return $output;
    }
	//--------------------------------------------------------------------

}
//
//
