<!-- resources/views/emails/welcome.blade.php -->

@component('mail::message')
    Dear {{ $customer_name }},

    Thank you for choosing Phoenix Technologies CRM! We're thrilled to have you on board. To get started, please find your registration details below:

    Login URL: {{ $login_url }}
    Username: {{ $user_name }}
    Password: {{ $password }}

    Your account is activated, and you can log in to start exploring the features of CRM. Our user-friendly interface is designed to streamline your workflow and enhance your overall experience.

    Need Help?

    If you encounter any issues during the on-board process or have questions about using our CRM, our support team is here to help. Simply reply to this email or contact us at [phoenixtechnologies2022@gmail.com](mailto:phoenixtechnologies2022@gmail.com) for prompt assistance.

    Thank you for choosing our CRM. We look forward to being a valuable partner in your success!

    {{-- Add any additional components or buttons as needed --}}
@endcomponent
