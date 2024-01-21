<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CommonHelper;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMailJob;
use App\Mail\TestEmail;
use App\Mail\WelcomeEmail;
use App\Models\EmailTemplates;
use DB;

class MailController extends Controller
{
    public function sendMailOld()
    {
        try {
            //Set mail configuration
            CommonHelper::setMailMainConfig();

            $data   = EmailTemplates::where('email_type', 'new_registration')->first();
            $extract = array(
                'name' => 'Duriaraj',
                'password' => 20301020,
                'mentorship_link' => 'link',
                'telegram_bot' => 'telegram_bot',
                'testimonial_link' => 'testimonial_link',
                'youtube_learning_link' => 'youtube_learning_link',
                'company_name' => 'Duraibytes',
                'company_phone_no' => '9888900000',
                'company_url' => 'company_url',
            );

            $templateMessage = $data->content;
            $templateMessage = str_replace("{", "", addslashes($templateMessage));
            $templateMessage = str_replace("}", "", $templateMessage);
            extract($extract);
            eval("\$templateMessage = \"$templateMessage\";");

            $body = [
                'content' => $templateMessage
            ];

            $media_url = storage_path('app/public/invoice/INV_2022_0011.pdf');

            Mail::send('emails.test', $body, function ($message) {
                $message->to('duraibytes@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
                $message->from('durairajnet@gmail.com', 'Durai bytes');
                // $message->attach($media_url);
            });
            echo 'Test email sent successfully';
            // return redirect()->back()->with('success', 'Test email sent successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function sendMail()
    {
        try {
            //Set mail configuration
            CommonHelper::setMailMainConfig();

            $body = [
                'login_url' => 'https://crm.phoenixtech.app/PX-ALG202308/devlogin',
                'customer_name' => 'Durai raj',
                'user_name' => 'test@yopmail.com',
                'password' => '12345678',
            ];

            Mail::send('emails.welcome', $body, function ($message) {
                $message->to('duraibytes@gmail.com', 'Durairaj')->subject('Welcome to Phoenix CRM - Complete Your Registration!');
                $message->from('phoenixtechnologies2022@gmail.com', 'PhoenixTech HelpDesk');
                // $message->attach($media_url);
            });

            // $send_mail = new WelcomeEmail($body['user_name'], $body['customer_name'], $body['login_url'], $body['password']);
            // return $send_mail->render();
            echo 'Test email sent successfully';
            // return redirect()->back()->with('success', 'Test email sent successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function sendWhatsapp()
    {
        sendWhatsappApi('9551706025', 'template', 'welcome', 'email');
    }
}

// $data   = EmailTemplates::where('email_type', 'new_registration')->first();
// CommonHelper::setMailConfig();

// $templateMessage = $data->content;
// $templateMessage = str_replace("{", "", addslashes($templateMessage));
// $templateMessage = str_replace("}", "", $templateMessage);
// extract($extract);
// eval("\$templateMessage = \"$templateMessage\";");

// $body = [
//     'content' => $templateMessage
// ];

// $send_mail = new TestEmail($body, $data->title ?? '');
// // return $send_mail->render();
// Mail::to($request->email ?? 'duraibytes@gmail.com')->send($send_mail);