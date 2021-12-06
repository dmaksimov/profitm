<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FacebookAppointment;
use App\Models\FacebookCampaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class FbAppointmentController extends Controller
{
    public function create(Request $request,$id, $customerId = null)
    {
        $customers = Customer::select(['id','name'])->orderBy('name')->get();
        if($request->isMethod('post'))
        {
            if($customerId || @$request->customer_id)
            {
                $data = $request->all();
                $customerId = $request->customer_id;
                $facebook_campaign_id = Customer::find($customerId)->facebook_campaign_id;
                $validator = $request->validate([
                    'end_time' => ['required'],
                    'start_time' => ['required', function($attr,$value,$fail) use ($request) {
                        $start_time = $this->getFormat($request->date,$request->start_time);
                        $end_time = $this->getFormat($request->date,$request->end_time);
                        $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $end_time);
                        $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $start_time);
                        $result = $date1->gt($date2);
                        if(!$result)
                        {
                            $fail('Please select end time greater than start time');
                        }
                        $start = FacebookAppointment::where('status','!=',2)->where('facebook_campaign_id',$request->facebook_campaign_id)->whereBetween('start_time',[$start_time, $end_time])->get()->isEmpty();
                        $end = FacebookAppointment::where('status','!=',2)->where('facebook_campaign_id',$request->facebook_campaign_id)->whereBetween('end_time',[$start_time, $end_time])->get()->isEmpty();
                        if(!($end && $start))
                        {
                            $fail('There is appointment booked for this start and end time , please change anyother time');
                        }
                    }],
                    'date' => ['required']
                ]);
                $data['start_time'] = $this->getFormat($request->date,$request->start_time);
                $data['end_time'] = $this->getFormat($request->date,$request->end_time);
                $data['customer_id'] = $customerId;
                $data['facebook_campaign_id'] = $facebook_campaign_id;
                Customer::find($customerId)->update(['status' => 2]);
                $model = FacebookAppointment::create($data);
                return $model;
            } else {
                $validator = $request->validate([
                    "customer_id" => request()->cid ? "": ['required'],
                    'end_time' => ['required'],
                    'start_time' => ['required', function($attr,$value,$fail) use ($request) {
                        $start_time = $this->getFormat($request->date,$request->start_time);
                        $end_time = $this->getFormat($request->date,$request->end_time);
                        $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $end_time);
                        $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $start_time);
                        $result = $date1->gt($date2);
                        if(!$result)
                        {
                            $fail('Please select end time greater than start time');
                        }
                        $start = FacebookAppointment::where('status','!=',2)->where('facebook_campaign_id',$request->facebook_campaign_id)->whereBetween('start_time',[$start_time, $end_time])->get()->isEmpty();
                        $end = FacebookAppointment::where('status','!=',2)->where('facebook_campaign_id',$request->facebook_campaign_id)->whereBetween('end_time',[$start_time, $end_time])->get()->isEmpty();
                        if(!($end && $start))
                        {
                            $fail('There is appointment booked for this start and end time , please change anyother time');
                        }
                    }],
                    'date' => ['required']
                ]);
                if(@$validator->errors)
                {
                    $errors = $validator->errors;
                    return response()->json($errors, 422);
                } else {
                    $data = $request->all();
                    $data['facebook_campaign_id'] = Customer::find($request->cid)->facebook_campaign_id;
                    $data['start_time'] = $this->getFormat($request->date,$request->start_time);
                    $data['end_time'] = $this->getFormat($request->date,$request->end_time);
                    $data['customer_id'] = $request->cid;
                    Customer::find($request->cid)->update(['status' => 2]);
                    $model = FacebookAppointment::create($data);
                    return $model;
                }
            }
           
        }
        return view('fb_appointments.create',compact('id' ,'customerId','customers'));
    }

    public function index($id)
    {
        $model = FacebookCampaign::find($id);
        return view('fb_appointments.index',compact('id','model'));
    }

    public function fetchAppointments($id)
    {
        $data['appointments'] = FacebookAppointment::with(['customer'])->where('facebook_campaign_id',$id)->get();
        $data['events'] = [];
        foreach($data['appointments'] as $key => $appointment)
        {
            @$data['events'][$key]['end'] = $appointment->end_time;
            @$data['events'][$key]['start'] = $appointment->start_time;
            @$data['events'][$key]['title'] = $appointment->customer->name;
        }
        return $data;
    }

    public function getFormat($date,$value)
    {
        $time = Carbon::parse($date);
        $hour = explode(':', $value)[0];
        $min = explode(':', $value)[1];
        $time->setHour($hour);
        $time->setMinute($min);
        return $time->format('Y-m-d H:i:s');
    }

    public function update(Request $request)
    {
        $model = FacebookAppointment::find($request->id)->update(['status' => $request->status]);
        return FacebookAppointment::find($request->id)->toJson();
    }
}
