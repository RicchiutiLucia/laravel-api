<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,
            [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
            ],
            [
                'name.required'=> 'Il nome è richiesto!',
                'email.required' => 'Email richiesta!',
                'email.email' => 'Email deve essere valida!',
                'message.required' => 'Il messaggio è richiesto!'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors()
                ]
            );
        }

        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        Mail::to('lucia.ricchiuti1995@gmail.com')->send(new NewContact($new_lead));

        return response()->json(
            [
                'success' => true
            ]
        );


    }
}
