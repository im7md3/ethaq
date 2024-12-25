<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class SettingsController extends Controller
{
    /* ********************** General *************************** */

    public function general()
    {
        return view('admin.settings.general');
    }
    public function updateGeneral(Request $request)
    {
        $rules = request()->validate([
            'website_name' => 'required|string',
            'link' => 'required|string',
            'website_active' => 'required|boolean',
            'activate_email' => 'required|boolean',
            'website_inactive_message' => 'required|string',
            'tax_number' => 'required|string',
            'address' => 'required|string',
            'building_number' => 'required|string',
            'street' => 'required|string',
            'phone' => 'required|string',
            'activate_taxes' => 'required|boolean',
            'logo_file' => 'nullable|image',
            'fav_icon_file' => 'nullable|image',
            'iban' => 'required',
            'UI_phone' => 'required',
            'tamara_active' => 'required',
            'tamam_active' => 'required',
        ]);
        if (request()->hasFile('logo_file')) {
            delete_file(setting('logo'));
            $rules['logo'] = store_file(request()->logo_file, 'images');
        }
        if (request()->hasFile('fav_icon_file')) {
            delete_file(setting('fav_icon'));
            $rules['fav_icon'] = store_file(request()->fav_icon_file, 'images');
        }
        $rules = Arr::except($rules, ['fav_icon_file', 'logo_file']);
        setting($rules)->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** Membership *************************** */
    public function memberships()
    {
        return view('admin.settings.memberships');
    }
    public function updateMemberships(Request $request)
    {
        $rules = [
            'register_by_nafath' => 'required|boolean',
            'register_new_client_individual' => 'required|boolean',
            'register_new_client_company' => 'required|boolean',
            'register_new_vendor_individual' => 'required|boolean',
            'register_new_vendor_company' => 'required|boolean',
            'edit_documents' => 'required|boolean',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** Orders *************************** */
    public function orders()
    {
        return view('admin.settings.orders');
    }
    public function updateOrders(Request $request)
    {
        $rules = [
            'orders' => 'required',
            'contract_tax' => 'required',
            'judger_cost' => 'required',
            'judger_cost_tax' => 'required',
            'admin_ratio_of_contract' => 'required',
            'admin_ratio_of_judger' => 'required',
            'cancellation_terms' => 'sometimes',
            'delivery_order_terms' => 'sometimes',
            'lowest_offer_amount' => 'required',
            'refund_ratio' => 'required',
            'terms_of_refund' => 'sometimes',
            'order_status_sms' => 'sometimes|boolean',
            'objection_duration' => 'nullable'
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** sms *************************** */
    public function sms()
    {
        $enableSMS = setting('enableSMS') ? setting('enableSMS') : [];
        return view('admin.settings.sms', compact('enableSMS'));
    }
    public function updateSMS(Request $request)
    {
        $rules = [
            'phone_verification_status' => 'required|boolean',
            'code_display_status' => 'required|boolean',
            'enableSMS' => 'nullable',
        ];
        request()->merge([
            'enableSMS' => request('enableSMS') ? request('enableSMS') : ''
        ]);
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** socialMedia *************************** */
    public function socialMedia()
    {
        return view('admin.settings.socialMedia');
    }
    public function updateSocialMedia(Request $request)
    {
        $rules = [
            'facebook' => 'required',
            'instagram' => 'required',
            'snapchat' => 'required',
            'twitter' => 'required',
            'linkedin' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** Consulting *************************** */
    public function consulting()
    {
        return view('admin.settings.consulting');
    }
    public function updateConsulting(Request $request)
    {
        $rules = [
            'consulting' => 'required|boolean',
            'terms_of_consulting' => 'required',
            'minimum_amount_for_consultation' => 'required',
            'tax_for_consultation' => 'required',
            'admin_ratio_from_consultation' => 'required',
            'consultation_time' => 'required',
            // 'number_free_consultations_for_vendor' => 'required',
            'free_consulting' => 'required',
            'pay_later_max' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** politics *************************** */
    public function politics()
    {
        return view('admin.settings.politics');
    }
    public function updatePolitics(Request $request)
    {
        $rules = [
            'politics' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** politics *************************** */
    public function arbitrationRegulations()
    {
        return view('admin.settings.arbitration-regulations');
    }
    public function updateArbitrationRegulations(Request $request)
    {
        $rules = [
            'arbitration_regulations' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** politics *************************** */
    public function invoices()
    {
        return view('admin.settings.invoices');
    }
    public function updateInvoices(Request $request)
    {
        $rules = [
            'invoices_terms' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }

    /* ********************** Gold *************************** */
    public function gold()
    {
        return view('admin.settings.gold');
    }
    public function updateGold(Request $request)
    {
        $rules = [
            'gold' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
    /* ********************** specialServices *************************** */
    public function specialServices()
    {
        return view('admin.settings.specialServices');
    }
    public function updateSpecialServices(Request $request)
    {
        $rules = [
            'specialServices' => 'required',
        ];
        setting(request()->validate($rules))->save();
        return back()->with('success', trans('Saved.'));
    }
}
