<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    use JodaResource;

    public $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    public function index()
    {
        $email_templates = EmailTemplate::latest()->paginate(10);
        return view('admin.email-template.index', compact('email_templates'));
    }

    public function query($query)
    {
        return $query->latest()->paginate(10);
    }

    public function afterStore()
    {
        return redirect()->route('admin.email_templates.index')->with('success', 'تم إضافة القالب بنجاح');
    }

    public function afterUpdate()
    {
        return redirect()->route('admin.email_templates.index')->with('success', 'تم تعديل القالب بنجاح');
    }

    public function afterDestroy()
    {
        return redirect()->route('admin.email_templates.index')->with('success', 'تم حذف القالب بنجاح');
    }
}
