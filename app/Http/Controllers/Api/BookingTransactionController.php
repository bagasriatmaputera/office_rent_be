<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransaction;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingTransactionResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class BookingTransactionController extends Controller
{
    public function bookingdetails(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'booking_trx_id' => 'required'
        ]);

        $data = BookingTransaction::where('phone_number', $request->phone_number)
            ->where('booking_trx', $request->booking_trx_id)
            ->with('office_space')
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return new ViewBookingTransactionResource($data);
    }
    public function store(StoreBookingTransaction $request)
    {
        $validateData = $request->validated();
        $officeSpace = OfficeSpace::find($validateData['office_space_id']);
        $validateData['is_paid'] = false;
        $validateData['booking_trx'] = BookingTransaction::generateUniqueTrxId();
        $validateData['duration'] = $officeSpace->duration;
        $validateData['ended_at'] = (new \DateTime($validateData['started_at']))
            ->modify("+{$officeSpace->duration} days")->format("Y-m-d");
        $bookingTransaction = BookingTransaction::create($validateData);

        // setting notifikasi dengan twilio
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $messageBody = "Hai {$bookingTransaction->name} pesanan anda akan segera kami proses apabila pembayaran sudah masuk di rekening kami";
        $messagewa = $twilio->messages->create(
            "whatsapp:+6285156432532", // to
            array(
                "from" => "whatsapp:+14155238886",
                "contentSid" => "HXb5b62575e6e4ff6129ad7c8efe1f983e",
                "body" => $messageBody
            )
        );
        $messagesms = $twilio->messages
            ->create(
                "+6285156432532", // to
                array(
                    "from" => "+18633343782",
                    "body" => $messageBody
                )
            );
        //membuat response untuk booking transaksi
        $bookingTransaction->load('office_space');
        return response()->json(new BookingTransactionResource($bookingTransaction));
    }
}
