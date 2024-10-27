<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\CustomerReport;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissions;
use App\Models\TechnicainReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ManageReports extends Controller {
    public function warnTechnicain(Request $request) {
        $reportID = $request->input('report');
        $report = CustomerReport::find($reportID);
        
        if(!$report) {
            return Controller::jsonMessage('البلاغ غير مسجل بالنظام', 1);
        }
        $technicain = $report->technicain();

        Mail::to($technicain->email)->send(new \App\Mail\WarnTechnicainMail($technicain));
        return Controller::jsonMessage("تم ارسال تحذير للفني", 0);
    }
    public function warnCustomer(Request $request) {
        $reportID = $request->input('report');
        $report = TechnicainReport::find($reportID);
        
        if(!$report) {
            return Controller::jsonMessage('البلاغ غير مسجل بالنظام', 1);
        }
        $customer = $report->customer();

        Mail::to($customer->email)->send(new \App\Mail\WarnCustomerMail($customer));
        return Controller::jsonMessage("تم ارسال تحذير للزبون", 0);
    }

    public function restrictTechnicainAccess(Request $request) {
        $reportID = $request->input('report');
        $report = CustomerReport::find($reportID);

        if(!$report) {
            return Controller::jsonMessage('البلاغ غير مسجل بالنظام', 1);
        }

        $technicain = $report->technicain();
        $technicain->state = "Bloced";
        $technicain->save();

        return Controller::jsonMessage("تم تقييد الوصول لحساب الفني", 0);
    }

    public function restrictCustomerAccess(Request $request) {
        $reportID = $request->input('report');
        $report = TechnicainReport::find($reportID);

        if(!$report) {
            return Controller::jsonMessage('البلاغ غير مسجل بالنظام', 1);
        }

        $customer = $report->customer();
        $customer->state = "Bloced";
        $customer->save();

        return Controller::jsonMessage("تم تقييد الوصول لحساب الزبون", 0);
    }

    public function markDoneCustomer(Request $request) {
        $reportID = $request->input('report');
        $report = CustomerReport::find($reportID);

        if(!$report) {
            return Controller::jsonMessage('البلاغ غير مسجل بالنظام', 1);
        }

        $report->state = "Done";
        $report->save();
        return Controller::jsonMessage("تم تعيين البلاغ كـ مكتمل", 0);
    }
    public function markDoneTechnicain(Request $request) {
        $reportID = $request->input('report');
        $report = TechnicainReport::find($reportID);

        if(!$report) {
            return Controller::jsonMessage('البلاغ غير مسجل بالنظام', 1);
        }

        $report->state = "Done";
        $report->save();
        return Controller::jsonMessage("تم تعيين البلاغ كـ مكتمل", 0);
    }


    // search for reports for whole month
    public function searchCustomersReport(Request $request) {
        $search = $request->input('search');

        if($search == "") return "";

        $date = Carbon::parse($search);
        $reports = CustomerReport::whereRaw('YEAR(created_at) = ?', [$date->year])
                    ->whereRaw('MONTH(created_at) = ?', [$date->month])
                    ->get();

        return view('employee.dashboard.customer-reports-searchview', compact('reports'))->render();
    }

    // search for reports for whole month
    public function searchTechnicainReport(Request $request) {
        $search = $request->input('search');

        if($search == "") return "";

        $date = Carbon::parse($search);
        $reports = TechnicainReport::whereRaw('YEAR(created_at) = ?', [$date->year])
                    ->whereRaw('MONTH(created_at) = ?', [$date->month])
                    ->get();

        return view('employee.dashboard.technicain-reports-searchview', compact('reports'))->render();
    }
}