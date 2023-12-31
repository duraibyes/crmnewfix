<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\CompanySettings;
use App\Models\LandingPages;
use Illuminate\Support\Facades\View;
use DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        //its just a dummy data object.
        
        $company_info = DB::table('company_settings')->where('site_code', request()->segment(1))->first();
        if( isset( $company_info ) && !empty( $company_info ) ) {
            $company_subscriptions = DB::table('company_subscriptions')->where('company_id', $company_info->id)->first();
            $meta_data = DB::table('landing_pages')
                            ->select('landing_page_meta_details.*')
                            ->join('landing_page_meta_details', 'landing_page_meta_details.page_id', '=', 'landing_pages.id')
                            ->where('is_default_landing_page', 1)->get();
            View::share('cm_favicon', $company_info->site_favicon ?? '');
            View::share('cm_logo', $company_info->site_logo ?? '');
            View::share('copyrights', $company_info->copyrights ?? '');
            View::share('site_name', $company_info->site_name ?? '');
            View::share('meta_data', $meta_data ?? '');
            View::share('expiry_date', $company_subscriptions->endAt ?? '');
            View::share('expiry_remainder_days', $company_subscriptions->expiry_remainder_days ?? '30');
        }
        
    }
}
