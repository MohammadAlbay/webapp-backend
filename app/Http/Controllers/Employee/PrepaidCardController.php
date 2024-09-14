<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PrepaidCard;
use Exception;
use Illuminate\Http\Request;


class PrepaidCardController extends Controller
{

    public function generate(Request $request, int $quantity, float $balance)
    {
        $cards = [];

        for($i = 0; $i < $quantity;) {
            try {
                $number = random_int(1000, 9999)*(random_int(19999999,99999999))+random_int(199999, 999999);
                PrepaidCard::create([
                    "serial" => $number,
                    "money" => $balance,
                    "state" => "Active"
                ]);

                $cards[''.count($cards).''] = [
                    'serial' => $number,
                    'price' => $balance
                ];
                //array_push($cards, $number);
                $i += 1;
            } catch(Exception $e) {
                if($i > 0)
                    $i -= 1;
            }
        }

        return Controller::whichReturn($request,
        "Successfuly created",
        Controller::jsonMessage($cards, 0));


    }

    public function deactivate(Request $request, $id) {
        // to add permission check here
        $card = PrepaidCard::find($id);

        if($card == null) return redirect('/employee')->withError(['UnknowCard', 'Unable to locate card']);

        $card->state = "Cancled";
        $card->save();

        return redirect("/employee");
    }
}
