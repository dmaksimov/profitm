<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FacebookCampaign;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index($id)
    {
        $model = FacebookCampaign::find($id);
        return view('customers.index',compact('id','model'));
    }

    public function edit($id)
    {
        return view('customers.edit',compact('id'));
    }

    public function fetchCustomers($id)
    {
        $customers = Customer::where('facebook_campaign_id',$id)->get();
        return $customers->toJson();
    }

    public function fetchCustomer($id)
    {
        $customer = Customer::find($id);
        return $customer->toJson();
    }

    public function create(Request $request ,$id)
    {
        if($request->isMethod("post"))
        {
            $data =  $request->all();
            $request->validate([
                'name' => 'required',
                'email' => ['required',function($attr,$value,$fail) use ($request,$id){
                    $valid = Customer::where('facebook_campaign_id',$id)->where('email',$value)->get()->isNotEmpty();
                    if($valid)
                    {
                        $fail('The email already exisits');
                    }
                }],
                'phone_no' => 'required',
            ]);
            $customer = Customer::create($data);
            return $customer->toJson();
        }
        return view('customers.create',compact('id'));
    }

    public function update(Request $request,$id)
    {
        $customer = Customer::find($id);
        $data = $request->all();
        $request->validate([
            'name' => 'required',
            'email' => ['required',function($attr,$value,$fail) use ($customer ,$request,$id){
                $valid = Customer::where('facebook_campaign_id',$customer->facebook_campaign_id)->where('email',$value)->where('id','!=',$id)->get()->isNotEmpty();
                if($valid)
                {
                    $fail('The email already exisits');
                }
            }],
            'phone_no' => 'required',
        ]);
        $customer->update($data);
        return $customer->toJson();
    }
}
