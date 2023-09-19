<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prognoz;
use App\Models\PrognozTranslate;
use App\Models\PrognozAttr;
use App\Models\AttrTranslate;
use GuzzleHttp\Client;
use App\Models\County;
use App\Models\CountryTranslate;
class TranslateController extends Controller
{


    public function translate_country(){
        $get = County::where('translate', 0)->get();
        $langs = [
            'English' => 'en',
            'Български' => 'bg',
            'Magyar' => 'hu',
            'Ελληνικά' => 'el',
            'Dansk' => 'da',
            'Bahasa Indonesia' => 'id',
            'Español' => 'es',
            'Italiano' => 'it',
            'Latviešu' => 'lv',
            'Lietuvių' => 'lt',
            'Deutsch' => 'de',
            'Polski' => 'pl',
            'Português' => 'pt',
            'Română' => 'ro',
            'Slovenčina' => 'sk',
            'Slovenščina' => 'sl',
            'Türkçe' => 'tr',
            'Українська' => 'uk',
            'Suomi' => 'fi',
            'Français' => 'fr',
            'Čeština' => 'cs',
            'Svenska' => 'sv',
            'Eesti' => 'et',
            'हिन्दी' => 'hi',

        ];

        $client = new Client();
        foreach ($langs as $lang) {
            foreach ($get as $country) {
                $response = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $country->name,
                        'language_iso' => 'ru',
                        'language_next' =>$lang
                    ],
                ]);

                $body = $response->getBody();
                $countrys = json_decode($body);


                CountryTranslate::updateOrCreate(['country_id' =>$country->id, 'lang' => $lang ],[
                    'country_id' =>$country->id,
                    'lang' => $lang,
                    'name' => $countrys->result

                ]);


                $country->update([
                   'translate' => 1
                ]);

            }
        }



        return true;
    }



        public function translate_prognoz(){

           $langs = [
                'English' => 'en',
                'Български' => 'bg',
                'Magyar' => 'hu',
                'Ελληνικά' => 'el',
                'Dansk' => 'da',
                'Bahasa Indonesia' => 'id',
                'Español' => 'es',
                'Italiano' => 'it',
                'Latviešu' => 'lv',
                'Lietuvių' => 'lt',
                'Deutsch' => 'de',
//            'Nederlands' => 'nl',
//            'Norsk (Bokmål)' => 'no',
                'Polski' => 'pl',
                'Português' => 'pt',
                'Română' => 'ro',
                'Slovenčina' => 'sk',
                'Slovenščina' => 'sl',
                'Türkçe' => 'tr',
                'Українська' => 'uk',
                'Suomi' => 'fi',
                'Français' => 'fr',
                'Čeština' => 'cs',
                'Svenska' => 'sv',
                'Eesti' => 'et',
                'हिन्दी' => 'hi',

            ];

            $get = Prognoz::where('translate', 0)->limit(3)->get();


            $client = new Client();
            foreach ($langs as $lang){
                foreach ($get as $item) {
                    $response = $client->post('https://atomcpa.ru/translate.php', [
                        'form_params' => [
                            'text' => $item['title'],
                            'language_iso' => 'ru', // Replace with the ISO code for the source language
                            'language_next' =>$lang, // Replace with the ISO code for the target language
                        ],
                    ]);

                    $body = $response->getBody();
                    $title = json_decode($body);


                    $response_liga = $client->post('https://atomcpa.ru/translate.php', [
                        'form_params' => [
                            'text' => $item['liga'],
                            'language_iso' => 'ru', // Replace with the ISO code for the source language
                            'language_next' =>$lang, // Replace with the ISO code for the target language
                        ],
                    ]);

                    $body_liga = $response_liga->getBody();
                    $liga = json_decode($body_liga);



//                    dd($liga);
//
//                    PrognozTranslate::updateorCreate(['prognoz_id' => $item->id, 'lang' => $lang],[
//                        'title' => $title->result,
//                        'liga' => $liga->result,
//                        'lang' => $lang,
//                        'prognoz_id' => $item->id,
//                    ]);
                }


            }
//            $get = Prognoz::where('translate', 0)->limit(3)->update([
//               'translate' => 1
//            ]);




            return true;
        }






    public function translate_atribute_test(){
        $langs = [
            'English' => 'en',
            'Български' => 'bg',
            'Magyar' => 'hu',
            'Ελληνικά' => 'el',
            'Dansk' => 'da',
            'Bahasa Indonesia' => 'id',
            'Español' => 'es',
            'Italiano' => 'it',
            'Latviešu' => 'lv',
            'Lietuvių' => 'lt',
            'Deutsch' => 'de',
            'Polski' => 'pl',
            'Português' => 'pt',
            'Română' => 'ro',
            'Slovenčina' => 'sk',
            'Slovenščina' => 'sl',
            'Türkçe' => 'tr',
            'Українська' => 'uk',
            'Suomi' => 'fi',
            'Français' => 'fr',
            'Čeština' => 'cs',
            'Svenska' => 'sv',
            'Eesti' => 'et',
            'हिन्दी' => 'hi',
        ];

        $get = PrognozAttr::where('translete', 0)->orderby('id', 'Desc')->limit(1)->get();
        $client = new Client();

        foreach ($langs as $lang){
            foreach ($get as $item) {


                if ($item->attr != null && $item->title != null && $item->kf != null){
            if ($item->attr != null){
                $item->attr = preg_replace('/\r\n|\r|\n/', '', $item->attr);


                $tags = [];
                $text_with_tags = preg_replace_callback('/<[^>]*>/', function ($match) use (&$tags) {
                    $tags[] = $match[0];
                    return ' 111 ';
                }, $item->attr);


                $makross_text = "Text Text tex $tags text text ";


                $response_attr = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $text_with_tags,
                        'language_iso' => 'ru',
                        'language_next' => $lang,
                    ],
                ]);

                $body_attr = $response_attr->getBody();
                $translated_text = json_decode($body_attr);


                $translated_text->result = preg_replace_callback('/111/', function ($match) use (&$tags) {
                    return array_shift($tags);
                }, $translated_text->result);


                $cleaned_translated_text = str_replace('. ', '․', $translated_text->result);


            }




                $response_title = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $item['title'],
                        'language_iso' => 'ru', // Замените на ISO код исходного языка
                        'language_next' => $lang, // Замените на ISO код целевого языка
                    ],
                ]);

                $body_title = $response_title->getBody();
                $title = json_decode($body_title);

                AttrTranslate::updateOrCreate(['attr_id' => $item->id, 'lang' => $lang],[
                    'attr' => $cleaned_translated_text ?? null,
                    'attr_id' => $item->id,
                    'lang' => $lang,
                    'title' => $title->result ?? null
                ]);

                PrognozAttr::where('id', $item->id)->update([
                    'translete' => 1
                ]);
            }
        }
        }

        return true;
    }



}
