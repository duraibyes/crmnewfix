<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user_name;
    public $customer_name;
    public $login_url;
    public $password;

    public function __construct($user_name, $customer_name, $login_url, $password)
    {
        $this->user_name = $user_name;
        $this->customer_name = $customer_name;
        $this->login_url = $login_url;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Welcome to Phoenix CRM - Complete Your Registration!')
                    ->view('emails.welcome', [
                        'customer_name' => $this->customer_name,
                        'login_url' => $this->login_url,
                        'user_name' => $this->user_name,
                        'password' => $this->password,
                    ]);
    }
}
