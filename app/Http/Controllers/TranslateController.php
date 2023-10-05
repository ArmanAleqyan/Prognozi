<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prognoz;
use App\Models\PrognozTranslate;
use App\Models\PrognozAttr;
use App\Models\AttrTranslate;
use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\Translation\TranslatorInterface;
use Illuminate\Contracts\Translation\Translator;
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

            $get = Prognoz::where('translate', 0)->limit(10)->get();


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




                    PrognozTranslate::updateorCreate(['prognoz_id' => $item->id, 'lang' => $lang],[
                        'title' => $title->result,
                        'liga' => $liga->result,
                        'lang' => $lang,
                        'prognoz_id' => $item->id,
                    ]);

                    $item->update([
                    'translate' => 1
                    ]);
                }


            }





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

//        $get = PrognozAttr::wherein('translete', [1,0])->orderby('id', 'desc')->limit(10)->get();
        $get = PrognozAttr::wherein('translete', [0,1])->orderby('id', 'desc')->limit(10)->get();
        $client = new Client();

        foreach ($langs as $lang){
            foreach ($get as $item) {



            if ($item->attr != null){
                $item->attr = preg_replace('/\r\n|\r|\n/', '', $item->attr);



                $tags = [];
                $text_with_tags = preg_replace_callback('/<[^>]*>/', function ($match) use (&$tags) {
                    $tags[] = $match[0];
                    return '000 '; // Заменяем тег на специальную метку
                }, $item->attr);





                $response_attr = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $text_with_tags,
                        'language_iso' => 'ru',   // Замените на ISO-код исходного языка
                        'language_next' => $lang, // Замените на ISO-код целевого языка
                    ],
                ]);

                $body_attr = $response_attr->getBody();
                $translated_text = json_decode($body_attr);


                $translated_text->result = preg_replace_callback('/000/', function ($match) use (&$tags) {
                    return array_shift($tags); // Восстанавливаем тег из массива
                }, $translated_text->result);



                $cleaned_translated_text = preg_replace_callback('/\.\s*(\d)/', function ($matches) {
                    // Проверяем, является ли совпадение после точки цифрой
                    if (is_numeric($matches[1])) {
                        // Если да, то заменяем точку на желаемый символ (например, ․)
                        return '․' . $matches[1];
                    } else {
                        // В противном случае оставляем как есть
                        return $matches[0];
                    }
                }, $translated_text->result);


            }


//                dd($cleaned_translated_text);

                $response_title = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $item['title'],
                        'language_iso' => 'ru', // Замените на ISO код исходного языка
                        'language_next' => $lang, // Замените на ISO код целевого языка
                    ],
                ]);

                $body_title = $response_title->getBody();
                $title = json_decode($body_title);

                $response_sobitie = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $item['sobitie'],
                        'language_iso' => 'ru', // Замените на ISO код исходного языка
                        'language_next' => $lang, // Замените на ISO код целевого языка
                    ],
                ]);
                $body_sobitie = $response_sobitie->getBody();
                $body_sobitie = json_decode($body_sobitie);

                $response_risk = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $item['risk'],
                        'language_iso' => 'ru', // Замените на ISO код исходного языка
                        'language_next' => $lang, // Замените на ISO код целевого языка
                    ],
                ]);

                $body_risk = $response_risk->getBody();
                $body_risk = json_decode($body_risk);

                AttrTranslate::updateOrCreate(['attr_id' => $item->id, 'lang' => $lang],[
                    'attr' => $cleaned_translated_text ?? null,
                    'attr_id' => $item->id,
                    'lang' => $lang,
                    'title' => $title->result ?? null,
                    'sobitie' => $body_sobitie??null,
                    'risk' => $body_risk??null,
                ]);

                PrognozAttr::where('id', $item->id)->update([
                    'translete' => 2
                ]);
            }
        }


        return true;
    }

    public function translate_atribute_testv2(Translator $translator){

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

//        $get = PrognozAttr::wherein('translete', [1,0])->orderby('id', 'desc')->limit(10)->get();
        $get = PrognozAttr::wherein('translete', [0,1,2])->orderby('id', 'desc')->limit(10)->get();
        $client = new Client();

        foreach ($langs as $lang){
            foreach ($get as $item) {

                if ($item->attr != null){

//                    dump($item->attr);
                    $item->attr = preg_replace('/\r\n|\r|\n/', '', $item->attr);

                    $text_with_tags = preg_replace_callback('/\s*<[^>]*>\s*|&nbsp;/', function ($match) use (&$tags) {
                        if ($match[0] === '&nbsp;') {
                            $tags[] = $match[0];
                            return '[' . (count($tags) - 1) . ']'; // Заменяем символ &nbsp; на специальную метку
                        } else {
                            $tags[] = $match[0];
                            return '[' . (count($tags) - 1) . ']'; // Заменяем тег на специальную метку
                        }
                    }, $item->attr);



                    $fragments = preg_split('/\s*(\[\d+\])\s*/', $text_with_tags, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);






                    $translated_fragments = [];
                    foreach ($fragments as $fragment) {
                        if (preg_match('/^\[?\d+\]?$/', $fragment)) {
                            continue;
                        }

                        $response_fragment = $client->post('https://atomcpa.ru/translate.php', [
                            'form_params' => [
                                'text' => $fragment,
                                'language_iso' => 'ru',   // Замените на ISO-код исходного языка
                                'language_next' => $lang, // Замените на ISO-код целевого языка
                            ],
                        ]);

                        $body_fragment = $response_fragment->getBody();
                        $translated_text = json_decode($body_fragment);
                        $translated_text->result = str_ireplace('Pobeda', 'Win', $translated_text->result);

                        $translated_fragments[] = $translated_text->result;
                    }


                    $combined_text = '';
                    foreach ($fragments as $fragment) {
                        if (preg_match('/^\[?\d+\]?$/', $fragment)) {
                            // Это индекс, добавьте его к объединенному тексту
                            $combined_text .= $fragment;
                        } else {
                            // Это переведенный текст, добавьте его к объединенному тексту
                            $combined_text .= array_shift($translated_fragments);
                        }
                    }




                    $combined_text_end = preg_replace_callback('/\[(\d+)\]/', function ($match) use (&$tags) {
                        $index = (int)$match[1];
                        if (isset($tags[$index])) {
                            return $tags[$index]; // Восстанавливаем тег по индексу
                        }
                        return ''; // Если индекс не найден, возвращаем пустую строку
                    },    $combined_text);

//                    $cleaned_translated_text = preg_replace('/yu\d+sch/', '', $combined_text_end);
//                    $cleaned_translated_text = str_replace('[', '', $combined_text_end);
//                    $cleaned_translated_text = str_replace(']', '', $combined_text_end);
//                    $cleaned_translated_text = str_replace(' )', ')', $combined_text_end);
//                    $cleaned_translated_text = str_replace(' (', '(', $combined_text_end);
//
//                    $cleaned_translated_text = str_replace(' " ', '" ', $combined_text_end);
//                    $cleaned_translated_text = str_replace(' :', ':', $combined_text_end);
//                    $cleaned_translated_text = str_replace(': ', ':', $combined_text_end);

                    $cleaned_translated_text = str_replace('&nbsp;', ' ', $combined_text_end);


                    $translatedText = $cleaned_translated_text;

                    // Выполните проверку и исправление текста
                    $correctedText = $translator->get($translatedText);
                    $correctedText = preg_replace('/yu\d+sch/', '', $correctedText);
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


                $response_sobitie = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $item['sobitie'],
                        'language_iso' => 'ru', // Замените на ISO код исходного языка
                        'language_next' => $lang, // Замените на ISO код целевого языка
                    ],
                ]);
                $body_sobitie = $response_sobitie->getBody();
                $body_sobitie = json_decode($body_sobitie);
                $item['sobitie'];

                $response_risk = $client->post('https://atomcpa.ru/translate.php', [
                    'form_params' => [
                        'text' => $item['risk'],
                        'language_iso' => 'ru', // Замените на ISO код исходного языка
                        'language_next' => $lang, // Замените на ISO код целевого языка
                    ],
                ]);

                $body_risk = $response_risk->getBody();
                $body_risk = json_decode($body_risk);

                AttrTranslate::updateOrCreate(['attr_id' => $item->id, 'lang' => $lang],[
                    'attr' => $cleaned_translated_text ?? null,
                    'attr_id' => $item->id,
                    'lang' => $lang,
                    'title' => $title->result ?? null,
                    'sobitie' => $body_sobitie->result??null,
                    'risk' => $body_risk->result??null,
                ]);

                PrognozAttr::where('id', $item->id)->update([
                    'translete' => 3
                ]);
            }
        }


        return true;
    }

}
