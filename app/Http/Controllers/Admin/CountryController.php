<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\County;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\DomCrawler\Crawler;
class CountryController extends Controller
{


    ///////////////   Tenc tetev banera tali

    public function fetchWebsiteHTML()
    {
        // Initialize the Guzzle HTTP client
        $client = new Client();

        // Specify the URL of the website you want to scrape
        $url = 'https://www.flashscore.mobi/'; // Замените на фактический URL

        try {
            // Make an HTTP GET request to the website
            $response = $client->get($url);

            // Get the HTML content from the response
            $htmlContent = $response->getBody()->getContents();

            // Initialize the DomCrawler
            $crawler = new Crawler($htmlContent);

            // Find all h4 elements, which contain the team names
            $teamNameElements = $crawler->filter('h4');

            // Find all a elements with class "fin", which contain the scores
            $scoreElements = $crawler->filter('a.fin');

            // Find all span elements that contain the hours
            $hourElements = $crawler->filter('span');

            // Find all a elements with class "fin" and extract their href attributes
            $matchLinks = $crawler->filter('a.fin')->extract(['href']);

            // Initialize arrays to store team names, scores, hours, and match links
            $teamNames = [];
            $scores = [];
            $hours = [];
            $links = [];

            // Iterate over the team name elements and scores elements
            for ($i = 0; $i < $teamNameElements->count(); $i++) {
                $teamNames[] = $teamNameElements->eq($i)->text();
                $scores[] = $scoreElements->eq($i)->text();
            }

            // Iterate over the hour elements
            $hourElements->each(function (Crawler $element) use (&$hours) {
                $hours[] = $element->text();
            });

            // Iterate over the match links
            foreach ($matchLinks as $link) {
                $links[] = 'https://www.flashscore.mobi' . $link;
            }

            // Now $teamNames, $scores, $hours, and $links contain the respective data
            for ($i = 0; $i < count($teamNames); $i++) {
                echo "Time: " . $hours[$i] . ", Team Name: " . $teamNames[$i] . ", Score: " . $scores[$i] . ", Link: " . $links[$i] . "<br/>";
            }

        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during the request
            return response('Error fetching website content: ' . $e->getMessage(), 500);
        }

    }


    public function parse()
    {
        $headers = ["x-fsign" => "SW9D1eZo"];
        $feed = 'f_1_-1_4_en_1';
        $url = "https://local-global.flashscore.ninja/2/x/feed/f_1_0_4_en_1";
        $response = Http::withHeaders($headers)->get($url);
        $data = explode('¬', $response->body());

        $dataList = [array()];

        foreach ($data as $item) {
            $parts = explode('÷', $item);
            $key = $parts[0];
            $value = end($parts);

            if (strpos($key, '~') !== false) {
                $dataList[] = [$key => $value];
            } else {
                end($dataList);
                $dataList[key($dataList)][$key] = $value;
            }
        }


        return response()->json([
            $dataList
        ]);
        foreach ($dataList as $game) {

            if (strpos(key($game), 'AA') !== false) {
                $date = \DateTime::createFromFormat('U', $game['AD']);
                $team1 = $game['AE'];
                $team2 = $game['AF'];
                $score = "{$game['AG']} : {$game['AH']}";


            }
        }

    }



    public function all_country(){
        $get = County::orderby('id', 'desc')->get();
        return view('admin.Country.all', compact('get'));
    }

    public function create_country_page(){

        return view('admin.Country.create');
    }

    public function create_country(Request $request){
        if (isset($request->photo)){
            $tiem = time();
            $photo =  $request->photo;
            $fileName = $tiem++.'.'.$photo->getClientOriginalExtension();
            $filePath = $photo->move('uploads', $fileName);
        }else{
            $fileName = null;
        }



        County::create([
           'name' => $request->name,
           'photo' => $fileName
        ]);


        return redirect()->back()->with('created','created');
    }


    public function single_page_country($id){
        $get = County::where('id', $id)->first();

        if ($get == null){
            return redirect()->back();
        }
        return view('admin.Country.single', compact('get'));
    }


    public function update_country(Request $request){
        $get = County::where('id', $request->country_id)->first();

        if ($get == null){
            return redirect()->back();
        }


        if (isset($request->photo)){
            $tiem = time();
            $photo =  $request->photo;
            $fileName = $tiem++.'.'.$photo->getClientOriginalExtension();
            $filePath = $photo->move('uploads', $fileName);
        }else{
            $fileName = $get->photo;
        }



        $get->update([
            'name' => $request->name,
            'photo' => $fileName
        ]);

        return redirect()->back()->with('created', 'created');

    }

    public function delete_country($id){
        County::where('id', $id)->delete();


        return redirect()->back()->with('deleted','deleted');
    }
}
