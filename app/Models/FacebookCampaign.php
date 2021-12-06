<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FacebookCampaign extends Model
{
    protected $fillable = [
        'facebook_campaign_id',
        'title',
        'updated_date',
        'start_date',
        'end_date',
        'response',
        'status',
        'dealer_id',
        'agency_id',
        'industry_type_id'
    ];

    public $casts = [
        'response' => 'array'
    ];

    public $appends = ['pieChartData','totalAppointments','pendingAppointments','finishedAppointments','newCustomers','openCustomers','closedCustomers','totalCustomers','csvData','agencyName','dealershipName'];

    public function facebookAppointments()
    {
        return $this->hasMany(FacebookAppointment::class,'facebook_campaign_id');
    }

    public function industryType()
    {
        return $this->belongsTo(IndustryType::class,'industry_type_id','id')->select(['id','title as name']);
    }


    public function agency()
    {
        return $this->hasOne(Company::class, 'id', 'agency_id')->withTrashed();
    }

    public function getAgencyNameAttribute()
    {
        return $this->agency ? $this->agency->name : '';
    }

    public function dealership()
    {
        return $this->hasOne(Company::class, 'id', 'dealer_id')->withTrashed();
    }

    public function getDealershipNameAttribute()
    {
        return $this->dealership ? $this->dealership->name : '';
    }

    public function getPieChartDataAttribute()
    {
        $appointments = FacebookAppointment::where('facebook_campaign_id',$this->id);
        $data[0][0][0] = 'Total appointments';
        $data[0][0][1] = $this->totalAppointments;
        $data[0][1][0] = 'Finished appointments';
        $data[0][1][1] = $this->finishedAppointments;
        $data[0][2][0] = 'Pending appointments';
        $data[0][2][1] = $this->pendingAppointments;
        return $data;
    }

    public function getTotalAppointmentsAttribute()
    {
        return $this->facebookAppointments->count();
    }

    public function getFinishedAppointmentsAttribute()
    {
        return $this->facebookAppointments->where('status',1)->count();
    }

    public function getPendingAppointmentsAttribute()
    {
        return $this->totalAppointments - $this->finishedAppointments -$this->customers->where('status',2)->count();
    }

    public function customers()
    {
        return $this->hasMany(Customer::class,'facebook_campaign_id');
    }

    public function getNewCustomersAttribute()
    {
        return $this->customers->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    }

    public function getOpenCustomersAttribute()
    {
        return $this->customers->where('status',1)->count();
    }

    public function getClosedCustomersAttribute()
    {
        return $this->customers->where('status',0)->count();
    }

    public function getTotalCustomersAttribute()
    {
        return $this->customers->count();
    }

    public function getCsvDataAttribute()
    {
        $data = [];
        $i = 1;
        $customers = $this->customers;
        foreach($customers as $customer)
        {
            $appointments = $customer->appointments;
            foreach($appointments as $appointment)
            {
                $data[$i]['S No.'] = $i;
                $data[$i]['Customer Name'] = $customer->name;
                $data[$i]['Customer Email'] = $customer->email;
                $data[$i]['Customer Phone No'] = $customer->phone_no;
                $data[$i]['Customer Created At'] = Carbon::parse($customer->created_at)->format('m-d-Y');
                $data[$i]['Customer Status'] = $customer->status ? "Open lead" : "Closed lead";
                $data[$i]['Appointment Date'] = Carbon::parse($appointment->date)->format('m-d-Y');
                $data[$i]['Appointment Start Time'] = Carbon::parse($appointment->start_time)->format('H : i : s');
                $data[$i]['Appointment End Time'] = Carbon::parse($appointment->end_time)->format('H : i : s');
                if($appointment->status == 0){
                   $status =  "New Appointment";
                } elseif($appointment->status == 1)
                {
                    $status =  "Finished Appointment";
                } else {
                    $status =  "Cancelled Appointment";
                }
                $data[$i]['Appointment Status'] = $status;
                $i++; 
            }
        }
        return (array) $data;
    }
}
