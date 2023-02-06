<?php

namespace App\Http\Controllers;

use Google\Service\YouTube;
use Google_Client;
use Illuminate\Http\Request;
use pubsubhubbub\publisher\Publisher;
use App\Models\Youtube_infos;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Exception;


class YoutubeController extends Controller
{
    //
    public function index()
    {
        // $client = new Google_Client();
        // $client->setDeveloperKey(env('API_YOUTUBE_KEY'));

        // $youtube = new YouTube($client);

        // $response = $youtube->search->listSearch('id, snippet', ['q' => 'Giannis Antetokounmpo',
        // 'order' => 'relevance', 'maxResults' => 10, 'type' => 'video']);

        $client = new Google_Client();
        $client->setApplicationName('API code samples');
        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.readonly',
        ]);

        $client->setAuthConfig('youtube-credentials.json');
        $client->setDeveloperKey(env('API_YOUTUBE_KEY'));
        $client->setAccessType('offline');

        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    public function send_mail($data) {
        try {
            Mail::to(Auth::user()->email)
                ->send(new MailNotify($data));
            return response()->json(['Bien']);
        } catch (Exception $th) {
            return response()->json(['Erreur']);
        }
    }
    public function getCode()
    {
        $client = new Google_Client();
        $client->setApplicationName('API code samples');
        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.readonly',
        ]);

        $client->setAuthConfig('youtube-credentials.json');
        $client->setDeveloperKey(env('API_YOUTUBE_KEY'));
        $client->setAccessType('offline');

        $authcode = $_GET['code'];

        $accessToken = $client->fetchAccessTokenWithAuthCode($authcode);
        $client->setAccessToken($accessToken);

        $service = new YouTube($client);
        $response = $service->channels->listChannels('snippet, id, statistics', ['mine' => true]);
        // $response2 = $service->activities->listActivities('snippet, id', ['mine' => true]);
        $find_youtube = Youtube_infos::where('user_id', Auth::id())->first();

        if (!$find_youtube) {
            $youtube_infos = Youtube_infos::create([
                'user_id' => Auth::id(),
                'followers' => $response['items'][0]['statistics']['subscriberCount'],
                'videos' => $response['items'][0]['statistics']['videoCount'],
                'views' => $response['items'][0]['statistics']['viewCount'],
                'description' => $response['items'][0]['snippet']['description']
            ]);
        }
        else {
            if($find_youtube->followers < $response['items'][0]['statistics']['subscriberCount']) {
                $data = [
                    'subject' => 'New Followers',
                    'body' => 'You have a new followers on youtube',
                    'mail' => Auth::user()->email
                ];
                $this->send_mail($data);
            }
            $find_youtube->followers = $response['items'][0]['statistics']['subscriberCount'];
            $find_youtube->videos = $response['items'][0]['statistics']['videoCount'];
            $find_youtube->views = $response['items'][0]['statistics']['viewCount'];
            $find_youtube->description = $response['items'][0]['snippet']['description'];

            $find_youtube->update();
        }


        dd($response);

    }


    public function get_notification(Request $request)
    {
        $data = [
            'subject' => 'New Followers',
            'body' => 'You have a new followers on youtube',
            'mail' => 'akohajordan@gmail.com'
        ];
        $this->send_mail($data);
        dd($request);

        // specify which hub you want to use. In this case we'll use the demo hub on app engine.
        // $hub_url = "http://pubsubhubbub.appspot.com/";

        // // create a new pubsubhubbub publisher
        // $p = new Publisher($hub_url);

        // // specify the feed that has been updated
        // $topic_url = "http://www.onlineaspect.com";

        // // notify the hub that the specified topic_url (ATOM feed) has been updated
        // // alternatively, publish_update() also accepts an array of topic urls
        // if ($p->publish_update($topic_url)) {
        //     echo "$topic_url was successfully published to $hub_url";
        // } else {
        //     echo "Ooops...";
        //     print_r($p->last_response());
        // }
    }
}
