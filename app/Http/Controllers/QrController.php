<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index(Request $request, Account $account)
    {

        $rules = [
            'amount' => '',
            'coin' => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules);
        $amount = 'null';
        if($request->amount != null) {
            $amount = $request->amount;
        }
        $str = '';
        $str = $str.$account->id.'-'.$account->number.'-'.$amount.'-'.$request->coin.'-'.$request->description;
        $f = base64_encode(QrCode::format('svg')->size(200)->generate($str));
        
        $file_name = 'Qr/image_' . time() . '.svg'; //generating unique file name;

        Storage::disk('public')->put($file_name, base64_decode($f));
        return $this->successResponse(url('storage/'.$file_name));
    }
}
