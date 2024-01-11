<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStartRow;
use CommonHelper;
use App\Models\Lead;
use App\Models\LeadType;
use App\Models\LeadSource;


class ImportCustomer implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $ins_array = [
            'first_name' => $row[0],
            'last_name' => $row[1],
            'email' => $row[2],
            'mobile_no' => $row[3],
            'address' => $row[4] ?? '',
            'status' => 1,
            'added_by' => Auth::id(),
        ];
        if( (isset( $row[2] ) && !empty($row[2]) ) || ((isset( $row[3] ) && !empty($row[3]))) ) {
            $customer_info = Customer::updateOrCreate($ins_array, ['email' => $row[2], 'mobile_no' => $row[3] ]);
            if( $customer_info ) {

                $assigned_to = CommonHelper::getLeadAssigner();
                $lea['assigned_to'] = $assigned_to;
    
                $lea['customer_id'] = $customer_info->id;
                $lea['status'] = 1;
                $lea['lead_no'] = CommonHelper::generateLeadNo();
                $lea['added_by'] = 1;
                $lea['mobile_no'] = $row[3] ?? '';
                $lea['email'] = $row[2] ?? '';
                $lea['city'] = $row[4] ?? '';
                $lea['lead_subject'] = $row[5] ?? 'Excel Import';
                $lead_type = $row[6] ?? '';
                $lead_source = $row[7] ?? '';
                if ($lead_type) {
                    $leadTypeInfo = LeadType::where('type', $lead_type)->where('company_id', auth()->user()->company_id)->first();
                    if ( $leadTypeInfo ) {
                        $lead_type_id = $leadTypeInfo->id;
                    } else {
                        $tins['status'] = 1;
                        $tins['type'] = $lead_type;
                        $tins['added_by'] = Auth::id();
                        $lead_type_id = LeadType::create($tins)->id;
                    }
                }
                if ($lead_source) {
                    // \DB::enableQueryLog();
                    $leadSourceInfo = LeadSource::where('source', $lead_source)->where('company_id', auth()->user()->company_id)->first();
                    // dd( \DB::getQueryLog());
                    // dd( $leadSourceInfo );
                    if ($leadSourceInfo) {
                        $lead_source_id = $leadSourceInfo->id;
                    } else {
                        $tins['status'] = 1;
                        $tins['source'] = $lead_type;
                        $tins['added_by'] = Auth::id();
                        $lead_source_id = LeadSource::create($tins)->id;
                    }
                }
                $lea['lead_type_id'] = $lead_type_id ?? null;
                $lea['lead_source_id'] = $lead_source_id ?? null;
                //CHECK LEAD IS ALREADY EXIST
                $lead_details = Lead::where(['customer_id' => $customer_info->id])->first();
                if (!$lead_details) {
                    $lead_id = Lead::create($lea)->id;
                    //insert in notification
                    CommonHelper::send_lead_notification($lead_id, $assigned_to, '', '', auth()->user()->company->site_code ?? '' );
                }
            }

        }
        return $customer_info;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
