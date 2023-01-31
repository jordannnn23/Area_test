<?php

namespace App\Http\Controllers;

use Google\Service\YouTube;
use Google_Client;
use Illuminate\Http\Request;
use pubsubhubbub\publisher\Publisher;


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

        // TODO: For this request to work, you must replace
        //       "YOUR_CLIENT_SECRET_FILE.json" with a pointer to your
        //       client_secret.json file. For more information, see
        //       https://cloud.google.com/iam/docs/creating-managing-service-account-keys
        $client->setAuthConfig('youtube-credentials.json');
        $client->setDeveloperKey(env('API_YOUTUBE_KEY'));
        $client->setAccessType('offline');

        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        // printf("Open this link in your browser:\n%s\n", $authUrl);
        // print('Enter verification code: ');
        return redirect($authUrl);
        //     $stdin = fopen('php://stdin', 'r');
        //     $authCode = trim(fgets($stdin));

        //     // Exchange authorization code for an access token.
        //     //if ($authCode) {
        //    //     dd("ok");
        //         $accessToken = $client->fetchAccessTokenWithAuthCode("4%2F0AWtgzh702uX4Ojd81cy9xjMq9nmWRJw6P6ng3E0MRltZ4_ZCpfXJOAo4NCbXxDbV1qQYbQ");
        //         $client->setAccessToken($accessToken);

        //     //}
        //     // Define service object for making API requests.
        //     $service = new YouTube($client);
        //     $response = $service->channels->listChannels('');
        //     dd($response);
        //     // print_r($response);
        // return view('youtube.accueil');
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

        // $stdin = fopen('php://stdin', 'r');
        // $authCode = trim(fgets($stdin));
        $authcode = $_GET['code'];

        $accessToken = $client->fetchAccessTokenWithAuthCode($authcode);
        $client->setAccessToken($accessToken);

        $service = new YouTube($client);
        $response = $service->channels->listChannels('snippet, id', ['mine' => true]);
        // $response2 = $service->activities->listActivities('snippet, id', ['mine' => true]);
        dd($response);

        // dd($response['items'][0]['snippet']['description']);

        // dd($authcode);
    }

    public function get_notification(Request $request)
    {
        // specify which hub you want to use. In this case we'll use the demo hub on app engine.
        $hub_url = "http://pubsubhubbub.appspot.com/";

        // create a new pubsubhubbub publisher
        $p = new Publisher($hub_url);

        // specify the feed that has been updated
        $topic_url = "http://www.onlineaspect.com";

        // notify the hub that the specified topic_url (ATOM feed) has been updated
        // alternatively, publish_update() also accepts an array of topic urls
        if ($p->publish_update($topic_url)) {
            echo "$topic_url was successfully published to $hub_url";
        } else {
            echo "Ooops...";
            print_r($p->last_response());
        }
    }
}
