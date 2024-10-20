<?php

namespace App\Http\Controllers;

use App\Models\CustomerReport;
use App\Models\Reservation;
use App\Models\TechnicainReport;
use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
    public function reportCustomer(Request $request) {
        $reservationID = $request->input("reservation");
        $reason = $request->input('reason');

        $reservation = Reservation::find($reservationID);
        if(!$reservation) {
            return response()->json(["State" => 1, "Message" => "الحجز المطلوب غير موجود"]);
        }

        $customerID = $reservation->customer()->id;
        $technicainID = $reservation->technicain()->id;

        TechnicainReport::create([
            "technicain_id" => $technicainID,
            "customer_id" => $customerID,
            "state" => "Pending",
            "description" => $reason
        ]);

        $msg = "اتكمل انشاء التقرير بنجاح";
        return response()->json(["State" => 0, "Message" => $msg]);
    }
    public function reportTechnicain(Request $request) {
        $reservationID = $request->input("reservation");
        $reason = $request->input('reason');

        $reservation = Reservation::find($reservationID);
        if(!$reservation) {
            return response()->json(["State" => 1, "Message" => "الحجز المطلوب غير موجود"]);
        }

        $customerID = $reservation->customer()->id;
        $technicainID = $reservation->technicain()->id;

        CustomerReport::create([
            "technicain_id" => $technicainID,
            "customer_id" => $customerID,
            "state" => "Pending",
            "description" => $reason
        ]);

        $msg = "اتكمل انشاء التقرير بنجاح";
        return response()->json(["State" => 0, "Message" => $msg]);
    }
}
