<?php

namespace App\Http\Controllers;

use Google\Service\YouTube;
use Google_Client;
use Illuminate\Http\Request;
use pubsubhubbub\publisher\Publisher;
use App\Models\User;
// use pubsubhubbub\subscriber\Subscriber;
use App\Http\Controllers\Subscriber;
use App\Models\Youtube_infos;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Exception;
use PicoFeed\Reader\Reader;
use PicoFeed\PicoFeedException;

class YoutubeController extends Controller
{
    //
    public function index()
    {
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

    public function send_mail2($data, $email) {
        try {
            Mail::to($email)
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
        $client->setApprovalPrompt('force');

        $authcode = $_GET['code'];

        if ($client->isAccessTokenExpired()) {
            $accessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            // file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
        else
            $accessToken = $client->fetchAccessTokenWithAuthCode($authcode);

        $client->setAccessToken($accessToken);
        $service = new YouTube($client);
        $response = $service->channels->listChannels('snippet, id, statistics', ['mine' => true]);
        $find_youtube = Youtube_infos::where('user_id', Auth::id())->first();
        $find_user = User::where('_id', Auth::id())->first();

        if (!$find_youtube) {
            $youtube_infos = Youtube_infos::create([
                'user_id' => Auth::id(),
                'channel_id' => $response['items'][0]['id'],
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
            $find_youtube->channel_id = $response['items'][0]['id'];

            $find_youtube->update();
        }
    }


    public function get_notification(Request $request)
    {
        
        $user_id = Auth::id();
        if(isset($_GET['hub_challenge'])) {
            $value = $_GET['hub_challenge'];
            return response($value);
            // echo $value;
        }

        // $data = [
        //     'subject' => 'New Followers',
        //     'body' => 'You have a new followers on youtube',
        //     // 'mail' => Auth::user()->email
        // ];
        // $this->send_mail($data);
        // else
        //     echo 'HIIIII';
        // // else
            // return response()->json('ok');

        //$this->send_mail($data);
        //dd($request);

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

    public function action (Request $request, $user_id) {
        $find_user = User::where('_id', $user_id)->first();
        $find_youtube = Youtube_infos::where('user_id', $user_id)->first();
        $message = "You have a new update on your youtube video.\n Go check the video https://youtube.com/channel/".$find_youtube->channel_id;
        $data = [
            'subject' => 'Video Update',
            'body' => $request
        ];
        $this->send_mail2($data, $find_user->email);
        if(isset($_GET['hub_challenge'])) {
            $value = $_GET['hub_challenge'];
            return response($value);
            // echo $value;
        }
    }

    public function register($user_id) {

        $find_user = User::where('_id', $user_id)->first();

        $find_youtube = Youtube_infos::where('user_id', $user_id)->first();
        $hub_url      = "http://pubsubhubbub.appspot.com";
        $callback_url = env('BACKEND_URL')."youtube/callback/".$find_user->id;

        $s = new Subscriber($hub_url, $callback_url);

        $feed = "https://www.youtube.com/xml/feeds/videos.xml?channel_id=".$find_youtube->channel_id;

        $s->subscribe($feed);

        $p = new Publisher($hub_url);
        $topic_url = "https://www.youtube.com/xml/feeds/videos.xml?channel_id=".$find_user->id;
        $p->publish_update($topic_url);
    }

    public function unregister($user_id) {

        $find_user = User::where('_id', $user_id)->first();

        $find_youtube = Youtube_infos::where('user_id', $user_id)->first();
        $hub_url      = "http://pubsubhubbub.appspot.com";
        $callback_url = env('BACKEND_URL')."youtube/callback/".$find_user->id;

        $s = new Subscriber($hub_url, $callback_url);

        $feed = "https://www.youtube.com/xml/feeds/videos.xml?channel_id=".$find_youtube->channel_id;

        $s->unsubscribe($feed);

        // $p = new Publisher($hub_url);
        // $topic_url = "https://www.youtube.com/xml/feeds/videos.xml?channel_id=".$find_user->id;
        // $p->publish_update($topic_url);
    }
}
