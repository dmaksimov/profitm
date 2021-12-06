<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndustryTypeCollection;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\FacebookCampaign;
use App\Models\IndustryType;
use App\Models\Template;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IndustryTypeController extends Controller
{

     /**
     * @var Company
     */
    private $industryType;


    private $storage;

    private $user;

    private $url;

    public function __construct(IndustryType $industryType,  UrlGenerator $url)
    {
        $this->industryType = $industryType;
        $this->url = $url;
    }

    public function index()
    {
        return view('industry_type.index', [ 'q' => '' ]);

    }

    public function create()
    {
        return view('industry_type.create');

    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|unique:industry_types',
        ],[
            'title.unique' => "Industry Type Name is taken already",
        ]);
        $industryType = new $this->industryType([
            'title' => $request->input('title'),
            'status' => $request->status ? 1 : 0,
        ]);
        $industryType->save();

        return response()->json([
            'message' => 'Resource created.'
        ]);
        
    }

    public function edit($id)
    {

        $industryType = IndustryType::find($id);
        $viewData = [
            'title' => $industryType->title,
            'status' => $industryType->status,
        ];
        return view('industry_type.edit',compact('id','viewData'));

    }

    public function update(Request $request, $id)
    {
        $IndustryType = IndustryType::find($id);
        $data = $request->all();
        $IndustryType->update($data);
        return $IndustryType->toJson();
    }

    public function destroy($id)
    {
       $value = $id;
       if(FacebookCampaign::where('industry_type_id',$value)->get()->isNotEmpty() || Campaign::where('industry_type_id',$value)->get()->isNotEmpty() || Company::where('industry_type_id',$value)->get()->isNotEmpty())
       {
           return response()->json(['errors' => ["message" => 'Unable to delete because this industry already assigned to companies and industries']], 422);
       }
        $IndustryType = IndustryType::find($id)->delete();
        
        return response()->json(['company deleted']);
    }

    public function getForIndustryTypeDisplay(Request $request)
    {
        $industry_types = $this->industryType
            // ->searchByRequest($request)
            ->orderBy('title')
            ->paginate(15);
        return new IndustryTypeCollection($industry_types);
    }

    public function template(Request $request, $id)
    {
        $tablefields = Schema::getColumnListing("recipients");
        $unwantedFields  = ['id','campaign_id','recipient_list_id','unique_recipient_id','tags','carrier','carrier_type','subgroup','service','appointment','heat','interested','not_interested','wrong_number','car_sold','callback','email_valid','phone_valid','from_dealer_db','notes','last_responded_at','archived_at','created_at','updated_at','deleted_at','sent_to_crm','status','last_status_changed_at','outcome'];
        foreach($unwantedFields as $field)
        {
            if (($key = array_search($field, $tablefields)) !== false) {
                unset($tablefields[$key]);
            }
        }
        $data = [];
        $default = [];

        $defaultFields = array_slice(array_values($tablefields), 0, 9, true);
        $template = Template::where('industry_type_id',$id)->first();
        $savedFields = $template ? $template->fields : [];
        $selectedFields = array_unique(array_merge($defaultFields,$savedFields));
        foreach(array_values($selectedFields) as $key => $field){
            $default[$key]['name'] = $field; 
            $default[$key]['id'] = $field; 
        }

        foreach(array_values($tablefields) as $key => $field){
            $data[$key]['name'] = $field; 
            $data[$key]['id'] = $field; 
        }

        if($request->isMethod('post'))
        {
            $dbFields = collect($request->dbFields)->pluck('id')->toArray();
            $customFields = $request->fields;
            $fields = array_unique(array_merge($dbFields,$customFields));
            $request->validate([
                'fields' => function($attr,$value,$fail) use ($fields,$defaultFields){
                    $missed = array_diff($defaultFields,$fields);
                    if(count($missed) > 0)
                    {
                        $fail(implode(' ,',$missed)." fields are mandatory");
                    }
                }
            ]);
            Schema::table('recipients', function (Blueprint  $table) use ($fields){
                foreach($fields as $newField)
                {
                    if(! Schema::hasColumn('recipients',Str::slug($newField, '_')))
                    {
                        $table->string(Str::slug($newField, '_'))->nullable();
                    }
                }
            });
            if($template)
            {
                $template->forceDelete();
            }
            $template = new Template();
            $fields = array_map( 'strtolower', $fields);
            $slugs = [];
            foreach($fields as $field)
            {
                $slugs[] = Str::slug($field, '_');
            }
            Template::create(['industry_type_id' => $id,'fields' => $slugs]);
            return response()->json(['company deleted']);
        }
        return view('industry_type.template',compact('id','data','default'));
    }
}
