<?php

namespace App\Http\Controllers\front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Support\Facades\DB;

class GlobalLoginController extends Controller
{

    public function globalLogin(Request $request) {
        if( auth()->user() ) {
            $companyCode = auth()->user()->company->site_code;
            return redirect()->route('dashboard', $companyCode);
        }
        return view('front.auth.global_login');
    }

    public function verifyGlobalLogin(Request $request) {

        $username = $request->email;
        $password = $request->password;
        $customer_info = User::where(['email' => $username, 'status' => 1 ])->first();

        $credentials = $request->only('email', 'password');
        // dd( $credentials );
        if( isset( $customer_info ) && !empty( $customer_info ) ) {
            if( !Hash::check($password, $customer_info->password) ) {
                return response()->json(['message' => 'Invalid Email address or Password', 'status' => 0]);
            }
            if (Auth::attempt($credentials)) {
                $company_subscriptions = DB::table('company_subscriptions')->where('company_id', $customer_info->company_id)->first();
                $today = date('Y-m-d');
                $companyCode = $customer_info->company->site_code;

                $end_date = date('Y-m-d', strtotime($company_subscriptions->endAt ?? $today));
                
                if( isset($company_subscriptions) && $today > $end_date  ){
                    Auth::logout();
                    return response()->json(['message' => 'Subscription has expired, Please contact Administrator', 'status' => 0]);
                    
                } else {

                    $noti_count = DB::table('notifications')->where('user_id', Auth::id())->count();
                    $request->session()->put('notification_count', $noti_count);
                    return response()->json(['message' => 'Login success', 'status' => 1, 'url' => route('dashboard', ['companyCode' => $companyCode] )]);

                }
            }
          
        } else {
            return response()->json(['message' => 'Invalid Email address or Password', 'status' => 0]);
        }
    }
    
}
