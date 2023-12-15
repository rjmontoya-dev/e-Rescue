<?php
namespace App\Services;

use App\Mail\Notifications\NewAccountMail;
use Illuminate\Support\Facades\Mail;

class SendMailService{
    public static function newAccountMail($user){
        Mail::to($user['email'])->queue(new NewAccountMail($user));
    }
}
