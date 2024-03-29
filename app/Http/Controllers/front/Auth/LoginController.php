<?php

namespace App\Http\Controllers\front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LandingPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public $companyCode;

    public function __construct(Request $request)
    {
        $this->companyCode = $request->segment(1) ?? '';
    }

    public function index(Request $request) {
        
        $result = LandingPages::where('is_default_landing_page', 1)->first();
        if (!$result) {
            $result   = LandingPages::latest()->first();
        }
        $globalLogin = $result ? false : true;
        $not_home = 'auth';
        return view('front.auth.login', compact('result', 'not_home', 'globalLogin'));

    }

    public function validate_login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $customer_info = Customer::where(['email' => $email, 'status' => 1 ])->first();
        
        if( isset( $customer_info ) && !empty( $customer_info ) ) {

            if( !Hash::check($password, $customer_info->password) ) {
                return response()->json(['message' => 'Invalid Email address or Password', 'status' => 0]);
            }
            Session::put('client', $customer_info);
          
            return response()->json(['message' => 'Login success', 'status' => 1, 'url' => route('profile', $this->companyCode)]);
        } else {
            return response()->json(['message' => 'Invalid Email address or Password', 'status' => 0]);
        }
    }

    public function validate_send_otp(Request $request)
    {
        $mobile_number = $request->mobile_number;
        $customer_info = Customer::where(['mobile_no' => $mobile_number, 'status' => 1 ])->first();

        if ( isset( $customer_info ) && !empty($customer_info)) {
            $otp  = rand(111111, 999999);
            $params = array('otp' => $otp);
            sendSMS($mobile_number, 'otp_login', $params);

            $customer_info->otp = $otp;
            $customer_info->otp_created_at = date('Y-m-d H:i:s');
            $customer_info->update();

            return response()->json(['message' => 'OTP has been sent to given mobile number successfully', 'status' => 0, 'otp' => $otp ]);
        } else {
            return response()->json(['message' => 'Mobile number is not registered', 'status' => 1]);
        }
    }

    public function verity_otp_login(Request $request)
    {
        $mobile_number = $request->mobile_number;
        $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4.$request->otp5.$request->otp6;
        $customer_info = Customer::where(['mobile_no' => $mobile_number, 'status' => 1, 'otp' => $otp ])->first();

        if ( isset( $customer_info ) && !empty($customer_info)) {

            //find now is expired 
            $startTime = date( 'Y-m-d H:i:s', strtotime($customer_info->otp_created_at) );
            $now = date('Y-m-d H:i:s');

            $to_time = strtotime($now);
            $from_time = strtotime($startTime);
            $diff_minutes = round(abs($to_time - $from_time) / 60,2);
            if( $diff_minutes > 30 ) {
                $message = 'OTP expired';
                $status = 1;
            } else {
                //do login action
                $message = 'Login success';
                $status = 0;

                Session::put('client', $customer_info);
            }
            $customer_info->otp = null;
            $customer_info->otp_created_at = null;
            $customer_info->update();
            
            return response()->json(['message' => $message, 'status' => $status ]);
        } else {
            return response()->json(['message' => 'Invalid OTP', 'status' => 1]);
        }
    }

    public function logout(Request $request) {
        session()->forget('client');
        return redirect()->route('customer-login', $this->companyCode);
    }
}
