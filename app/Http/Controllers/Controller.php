<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Info(title="Librarie API", version="0.1")
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @return void
     */
    public function sendContactMail(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
            'email' => 'required|email'
        ]);

        $message = $validatedData['message'];
        $email = $validatedData['email'];

        Mail::to('inkpaper2023@hotmail.com')->send(new ContactMail($message, $email));
    }
}
