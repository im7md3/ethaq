<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ConsultingExport;
use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

class ConsultingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read_consulting')->only('index');
        $this->middleware('can:delete_consulting')->only('destroy');
        $this->middleware('can:view_consulting')->only('show');
    }

    public function index()
    {
        $allConsulting = Consulting::get();
        $consulting = Consulting::with(['department', 'client', 'vendor'])->where(function ($q) {
            if (request('status')) {
                $q->where('status', request('status'));
            }
            if (request('vendor_id')) {
                $q->where('vendor_id', request('vendor_id'));
            }
            if (request('client_id')) {
                $q->where('client_id', request('client_id'));
            }
            if (request('invoices')) {
                $q->whereRelation('invoices','status','unpaid');
            }
            
            if(request('search')){
                $q->where('id',request('search'))->orWhereRelation('client','name','LIKE',"%".request('search')."%")->orWhereRelation('vendor','name','LIKE',"%".request('search')."%");
            }
        })->latest('id')->paginate(10);
        $not_paid=Consulting::whereRelation('invoices','status','unpaid')->count();
        return view('admin.consulting.index', compact('consulting', 'allConsulting','not_paid'));
    }

    public function create(){
        $vendors = User::AllVendors()->ActiveLicense()->where('consulting_price','>',0)->with(['occupation', 'license'])->get();
        $clients=User::clients()->get();
        $departments = Department::Consultings()->get();
        return view('admin.consulting.create',compact('vendors','clients','departments'));
    }

    public function store(Request $request){
        $data=$request->validate([
            'client_id'=>'required',
            'vendor_id'=>'required',
            'department_id'=>'required',
            'details'=>'required',
            'status'=>'required',
        ]);
        Consulting::create($data);
        return redirect()->route('admin.consulting.index')->with('success','تم الإضافة بنجاح');
    }
    public function show(Consulting $consulting)
    {
        $con = $consulting->load(['department', 'client', 'vendor', 'messages']);
        return view('admin.consulting.show', compact('con'));
    }

    public function destroy(Consulting $consulting)
    {
        $consulting->delete();
        return back()->with('success', 'تم حذف الاستشارة بنجاح');
    }

    public function exports()
    {
        $consultings = Consulting::with(['department', 'client', 'vendor'])->where(function ($q) {
            if (request('status')) {
                $q->where('status', request('status'));
            }
            if (request('vendor_id')) {
                $q->where('vendor_id', request('vendor_id'));
            }
            if (request('client_id')) {
                $q->where('client_id', request('client_id'));
            }
        })->latest('id')->get();

        return Excel::download(new ConsultingExport($consultings), 'consultings' . time() . '.xlsx');
    }

    public function clients(){
        $users=User::clients()->withCount('consultingClient')->where(function($q){
            if(request('search')){
                $q->where('name','LIKE',"%".request('search')."%")->orWhere('phone',request('search'));
            }
        })->paginate(10);
        return view('admin.consulting.clients',compact('users'));
    }
}
