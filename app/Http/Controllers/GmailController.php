<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Gmail;

class GmailController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->authenticate($request->input('code'));
        $accessToken = $client->getAccessToken();
        session(['gmail_access_token' => $accessToken]);
        return redirect()->route('home');
    }

    public function sendEmail($to, $subject, $message)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setAccessToken(session('gmail_access_token'));

        $service = new Google_Service_Gmail($client);
        $mimeMessage = (new \Swift_Message($subject))
            ->setTo($to)
            ->setBody($message, 'text/html');

        $message = new \Google_Service_Gmail_Message();
        $message->setRaw(base64_encode($mimeMessage->toString()));

        $service->users_messages->send('me', $message);
    }
}

