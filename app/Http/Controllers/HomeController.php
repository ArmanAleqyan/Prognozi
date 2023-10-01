<?php

namespace App\Http\Controllers;

use App\Models\Prognoz;
use App\Models\PrognozAttr;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Laravelium\Sitemap\SitemapServiceProvider;
use Laravelium\Sitemap\Sitemap;
use Laravelium\Sitemap\Tags\Url;
use App\Models\County;
class HomeController extends Controller
{



    public function filtered_data(Request $request){
        $get = Prognoz::query();
        $gets = Prognoz::query();
        $get->with('country_name');

        App::setLocale(session()->get('locale')??'ru');

        if ($request->route == 'home'){
            $get->orderby('start_carbon', 'asc')
                ->whereBetween(
                    DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'),
                    [Carbon::now(), DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)')]
                );


            $vsego_header = '';
            $vsego_header_text =      '';
            $luchshaya_header   =       '';
            $luchshaya_header_text = '';
        }

        if ($request->type == 'country_filter'){
            $get->where('country_id', $request->country_id);
            $gets->where('country_id', $request->country_id);


        }
        if ($request->type == 'stars'){
            $get->where('star', 0);
            $gets->where('star', 0);
        }



        if ($request->route == 'completed'){
                    $get->orderby('start_carbon', 'desc')
                        ->where(DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'), '<', Carbon::now());


            $getss = $gets->where('status' , 'Завершен')->get('id')->pluck('id')->toarray();

            $get_all_attr = \App\Models\PrognozAttr::wherein('prognoz_id', $getss)->where('title', '!=', '  ')->where('kf', '!=', null)->count();
            $get_all_attr_true = \App\Models\PrognozAttr::wherein('prognoz_id', $getss)->where('title', '!=', '  ' )->where('kf', '!=', null)->where('status', 1)->count();
            $get_all_attr_star_true = \App\Models\PrognozAttr::wherein('prognoz_id', $getss)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
            $get_all_attr_star = \App\Models\PrognozAttr::wherein('prognoz_id', $getss)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

            $datas['get_all_attr'] = $get_all_attr;
            $datas['get_all_attr_true'] = $get_all_attr_true;
            $datas['get_all_attr_star_true'] = $get_all_attr_star_true;
            $datas['get_all_attr_star'] = $get_all_attr_star;

            $vsego_header = $datas['get_all_attr_true'].'/'.$datas['get_all_attr'];
            $vsego_header_text =      __('{makros_44}');
            $luchshaya_header   =       $datas['get_all_attr_star_true'].'/'.$datas['get_all_attr_star'];
            $luchshaya_header_text = __('{makros_44}');
        }




        $gets = $get->simplepaginate(10)->withQueryString();

        foreach ($gets as $data ){

            $date_valid = \Carbon\Carbon::parse($data->start_carbon);
            $current_time = \Carbon\Carbon::now();
            $diff = $date_valid->diffInMinutes($current_time);

            if ($diff > 0 && $diff <= 90) {
                $string = "Начался";
            } elseif ($diff > 90 && \Carbon\Carbon::now() > $data->start_carbon) {
                $string = "Завершен";
            } else {
                $string = "Начало";
            }
            if ($data->status == 'Начался'){
                $string = __('{makros_12}');
            }elseif ($data->status == 'Завершен'){
                $string = __('{makros_11}');
            }else{
                $string = ' ';
            }


            if ($data->status == 'Завершен'){
                $data['style'] =  'color: #ba6161;font-size: 14px;';
                if ($data->show_analize == 0){
                    $data['analize_div'] = 'display:none';
                }else{
                    $get_all_attr = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->count();
                    $get_all_attr_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ' )->where('kf', '!=', null)->where('status', 1)->count();
                    $get_all_attr_star_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
                    $get_all_attr_star = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

                    $data['get_all_attr'] = $get_all_attr;
                    $data['get_all_attr_true'] = $get_all_attr_true;
                    $data['get_all_attr_star_true'] = $get_all_attr_star_true;
                    $data['get_all_attr_star'] = $get_all_attr_star;
                }



            }else{
                $data['style']  = ' ';
                $data['analize_div'] = 'display:none';
            }


            $data['string'] = $string;

            if ($data->status == 'Начало'){
                $data['diforhumans']  =  Carbon::parse($data->start_carbon)->diffforhumans();
            }else{
                $data['diforhumans']  = ' ';
            }

            if ($data->star == 0){
                $star_url = asset('public/images/cup.svg');
            }else{
                $star_url = asset('uploads/'.$data->country_name->photo);

            }
            $data['star_url'] = $star_url;

            if ($data->url != null && $data->url != ' '){
                $url = $data->url;
            }else{
                $url = $data->title;
            }
            $lang =   session()->get('locale');

            if ($lang == 'ru'){

            }else{
                $data['team_one'] = $data['team_one_two'];
                $data['team_two'] = $data['team_two_two'];
                $data['team_two_two'] = null;
                $data['team_two_two_div'] = 'display:none';
                $data['team_one_two_div'] = 'display:none';
                $data['team_one_two'] = null;

                $data->country_name->name = \App\Models\CountryTranslate::where('country_id' , $data->country_name->id)->where('lang', session()->get('locale'))->first()->name??$data->country_name->name;
                $data->liga = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->liga??$data->liga;
                $data->title = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->title??$data->title;


            }


            $data['single_page'] = route('bet',[$url , $data->id]);
            $data['button_text'] = __('{makros_19}');
            $data['vsego'] = __('{makros_44}');
            $data['lucshaya'] = __('{makros_45}');
        }

        return response()->json([
           'status' => true,
           'data' => $gets,
            'next_page_url' =>$gets->nextPageUrl(),
            'vsego_header' =>$vsego_header,
            'vsego_header_text' =>$vsego_header_text,
            'luchshaya_header' =>$luchshaya_header,
            'luchshaya_header_text' =>$luchshaya_header_text,
        ],200);

    }



    public function home(Request $request){
        App::setLocale(session()->get('locale')??'ru');





        config(['app.timezone' => session()->get('timezone')]);


        Carbon::now(session()->get('timezone'));

        if (isset($request->page)){

            $get = Prognoz::query()
                ->orderby('start_carbon', 'asc')
                ->whereBetween(
                    DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'),
                    [Carbon::now(), DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)')]
                )->with('country_name')
                ->simplepaginate(10);


            foreach ($get as $data ){

                $date_valid = \Carbon\Carbon::parse($data->start_carbon);
                $current_time = \Carbon\Carbon::now();
                $diff = $date_valid->diffInMinutes($current_time);

                if ($diff > 0 && $diff <= 90) {
                    $string = "Начался";
                } elseif ($diff > 90 && \Carbon\Carbon::now() > $data->start_carbon) {
                    $string = "Завершен";
                } else {
                    $string = " ";
                }


                if ($data->status == 'Завершен'){
                    $data['style'] =  'color: #ba6161;font-size: 14px;';
                    if ($data->show_analize == 0){
                        $data['analize_div'] = 'display:none';
                    }else{
                        $get_all_attr = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->count();
                        $get_all_attr_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ' )->where('kf', '!=', null)->where('status', 1)->count();
                        $get_all_attr_star_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
                        $get_all_attr_star = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

                        $data['get_all_attr'] = $get_all_attr;
                        $data['get_all_attr_true'] = $get_all_attr_true;
                        $data['get_all_attr_star_true'] = $get_all_attr_star_true;
                        $data['get_all_attr_star'] = $get_all_attr_star;

                    }
                }else{
                    $data['style']  = ' ';
                    $data['analize_div'] = 'display:none';
                }


                if ($data->status == 'Начался'){
                    $string = __('{makros_12}');
                }elseif ($data->status == 'Завершен'){
                    $string = __('{makros_11}');
                }else{
                    $string = ' ';
                }


                $data['string'] = $string;

                if ($data->status == 'Начало'){

                    $data['diforhumans']  =  Carbon::parse($data->start_carbon)->diffforhumans();
                }else{
                    $data['diforhumans']  = ' ';
                }

                if ($data->star == 0){
                    $star_url = asset('public/images/cup.svg');
                }else{
                    $star_url = asset('uploads/'.$data->country_name->photo);

                }
                $data['star_url'] = $star_url;

                if ($data->url != null && $data->url != ' '){
                    $url = $data->url;
                }else{
                    $url = $data->title;
                }
                $lang =   session()->get('locale');

                if ($lang == 'ru'){

                }else{
                    $data['team_one'] = $data['team_one_two'];
                    $data['team_two'] = $data['team_two_two'];
                    $data['team_two_two'] = null;
                    $data['team_two_two_div'] = 'display:none';
                    $data['team_one_two_div'] = 'display:none';
                    $data['team_one_two'] = null;
                    $data->country_name->name = \App\Models\CountryTranslate::where('country_id' , $data->country_name->id)->where('lang', session()->get('locale'))->first()->name??$data->country_name->name;
                    $data->liga = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->liga??$data->liga;
                    $data->title = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->title??$data->title;

                }
                $data['single_page'] = route('bet',[$url , $data->id]);
                $data['button_text'] = __('{makros_19}');
                $data['vsego'] = __('{makros_44}');
                $data['lucshaya'] = __('{makros_45}');
            }



            return response()->json([
               'status' => true,
               'data' => $get,
                'next_page_url' =>$get->nextPageUrl()
            ]);
        }
        $all_country = County::orderby('id', 'asc')->get();

        $get = Prognoz::query()
            ->orderby('start_carbon', 'asc')
            ->whereBetween(
                DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'),
                [Carbon::now(), DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)')]
            )
            ->simplepaginate(10);


        return view('index',compact('get' ,'all_country'));
    }

        public function completed(Request $request){
            App::setLocale(session()->get('locale')??'ru');



            if (isset($request->page)){
                $all_country = County::orderby('id', 'desc')->get();
                $get = Prognoz::orderby('start_carbon', 'desc')->with('country_name')
                    ->where(DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'), '<', Carbon::now())
                    ->simplepaginate(10);


                foreach ($get as $data ){

                    $date_valid = \Carbon\Carbon::parse($data->start_carbon);
                    $current_time = \Carbon\Carbon::now();
                    $diff = $date_valid->diffInMinutes($current_time);

                    if ($diff > 0 && $diff <= 90) {
                        $string = "Начался";
                    } elseif ($diff > 90 && \Carbon\Carbon::now() > $data->start_carbon) {
                        $string = "Завершен";
                    } else {
                        $string = "Начало";
                    }


                    if ($data->status == 'Завершен'){
                        $data['style'] =  'color: #ba6161;font-size: 14px;';
                        if ($data->show_analize == 0){
                            $data['analize_div'] = 'display:none';
                        }else{
                            $get_all_attr = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->count();
                            $get_all_attr_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ' )->where('kf', '!=', null)->where('status', 1)->count();
                            $get_all_attr_star_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
                            $get_all_attr_star = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

                            $data['get_all_attr'] = $get_all_attr;
                            $data['get_all_attr_true'] = $get_all_attr_true;
                            $data['get_all_attr_star_true'] = $get_all_attr_star_true;
                            $data['get_all_attr_star'] = $get_all_attr_star;

                            $data->country_name->name = \App\Models\CountryTranslate::where('country_id' , $data->country_name->id)->where('lang', session()->get('locale'))->first()->name??$data->country_name->name;
                            $data->liga = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->liga??$data->liga;
                            $data->title = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->title??$data->title;

                        }



                    }else{
                        $data['style']  = ' ';
                        $data['analize_div'] = 'display:none';
                    }

                    if ($data->status == 'Начался'){
                        $string = __('{makros_12}');
                    }elseif ($data->status == 'Завершен'){
                        $string = __('{makros_11}');
                    }else{
                        $string = __('{makros_9}');
                    }

                    $data['string'] = $string;

                    if ($data->status == 'Начало'){

                        $data['diforhumans']  =  Carbon::parse($data->start_carbon)->diffforhumans();
                    }else{
                        $data['diforhumans']  = ' ';
                    }

                    if ($data->star == 0){
                        $star_url = asset('public/images/cup.svg');
                    }else{
                        $star_url = asset('uploads/'.$data->country_name->photo);

                    }
                    $data['star_url'] = $star_url;

                    if ($data->url != null && $data->url != ' '){
                        $url = $data->url;
                    }else{
                        $url = $data->title;
                    }

                    $lang =   session()->get('locale');

                    if ($lang == 'ru'){

                    }else{
                        $data['team_one'] = $data['team_one_two'];
                        $data['team_two'] = $data['team_two_two'];
                        $data['team_two_two'] = null;
                        $data['team_two_two_div'] = 'display:none';
                        $data['team_one_two_div'] = 'display:none';
                        $data['team_one_two'] = null;
                    }
                    $data['single_page'] = route('bet',[$url , $data->id]);
                    $data['button_text'] = __('{makros_19}');
                    $data['vsego'] = __('{makros_44}');
                    $data['lucshaya'] = __('{makros_45}');
                }

                return response()->json([
                    'status' => true,
                    'data' => $get,
                    'next_page_url' =>$get->nextPageUrl()
                ]);
            }


            $all_country = County::orderby('id', 'desc')->get();
            $get = Prognoz::orderby('start_carbon', 'desc')
                ->where(DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'), '<', Carbon::now())
                ->simplepaginate(10);


            return view('index',compact('get', 'all_country'));
        }
    public function bet(Request $request,$url, $id){
        App::setLocale(session()->get('locale')??'ru');
        $get = Prognoz::where('url', $url)->where('id', $id)
                    ->orwhere('title', $url)->where('id', $id)->first();


        if ($get == null){
            return redirect()->back();
        }


        $data = Carbon::parse($get->start_carbon)->tz( session()->get('timezone')??'Europe/Moscow');
        $mounth = $data->monthName;
        $day = $data->day;
        $year = $data->year;


        if ($mounth == 'август'){
          $mounth =  __("{makros_33}") ;
        }
        if ($mounth == 'январь'){
          $mounth =  __('{makros_26}');
        }
        if ($mounth == 'февраль'){
          $mounth =  __('{makros_27}') ;
        }
        if ($mounth == 'март'){
          $mounth =  __('{makros_28}');
        }
        if ($mounth == 'апрель'){
          $mounth =  __('{makros_29}');
        }
        if ($mounth == 'май'){
          $mounth =  __('{makros_30}');
        }
        if ($mounth == 'июнь'){
          $mounth =  __('{makros_31}');
        }
        if ($mounth == 'июль'){
          $mounth =  __('{makros_32}') ;
        }
        if ($mounth == 'сентябрь'){
          $mounth =  __('{makros_34}');
        }
        if ($mounth == 'октябрь'){
          $mounth =  __('{makros_35}');
        }
        if ($mounth == 'ноябрь'){
          $mounth =  __('{makros_36}');
        }
        if ($mounth == 'декабрь'){
          $mounth =  __('{makros_37}');
        }



        if (session()->get('locale') == 'ru' || session()->get('locale') == null){
            $end_date = $day.' '.$mounth. ' '.$year.' '.'года?';
        }else{
            $end_date = $day.' '.$mounth. ' '.$year.'.';
        }
//        $end_date = $day.' '.$mounth. ' '.$year.' '.'года';

        $end_date_two = $day.' '.$mounth. ' '.$year;


        $originalString = $get->country->name??$get->country;

// Убеждаемся, что строка не пустая и содержит хотя бы один символ
        if (mb_strlen($originalString, 'UTF-8') > 0) {
            $replacementChar = 'и'; // Новый символ

            // Получаем первый символ строки
            $firstChar = mb_substr($originalString, 0, 1, 'UTF-8');

            // Получаем всю строку, кроме первого символа, и добавляем новый символ
            $newCity = $firstChar . mb_substr($originalString, 1, -1, 'UTF-8') . $replacementChar;
        } else {
            // Обработка пустой строки
            $newCity = '';
        }
        if (isset($request->page)){
            $all_country = County::orderby('id', 'desc')->get();

            if ($get->star == 0){
                if ($get->status ==   'Завершен'){
                    $gets =  Prognoz::orderby('star', 'asc')->
                    orderby('start_carbon', 'asc')
                        ->orderby('star', 'asc')->with('country_name')
                        ->where('status' , 'Завершен')
                        ->where('id' , '!=', $get->id)
                        ->where('country_id', $get->country_id)
                        ->where('status' , 'Завершен')

                        ->orWhere(function ($query) use ($get) {
                            $query->where('star', $get->star) ->orderby('star', 'asc')->
                            orderby('start_carbon', 'asc')
                                ->orderby('star', 'asc')
                                ->where('status' , '!=', 'Завершен')
                                ->where('id' , '!=', $get->id)
//                    ->where('country_id', $get->country_id)
                                ->where('status' , '!=', 'Завершен');
                        })
                        ->with('country_name')
                        ->simplepaginate(5);
                } else{
                    $gets =  Prognoz::orderby('star', 'asc')->
                    orderby('start_carbon', 'asc')
                        ->orderby('star', 'asc')
                        ->where('status' , '!=', 'Завершен')
                        ->where('id' , '!=', $get->id)
                        ->where('country_id', $get->country_id)
                        ->where('status' , '!=', 'Завершен')
                        ->orWhere(function ($query) use ($get) {
                            $query->where('star', $get->star)  ->orderby('star', 'asc')->
                            orderby('start_carbon', 'asc')
                                ->orderby('star', 'asc')
                                ->where('status' , '!=', 'Завершен')
                                ->where('id' , '!=', $get->id)
//                    ->where('country_id', $get->country_id)
                                ->where('status' , '!=', 'Завершен');
                        })
                        ->with('country_name')
                        ->simplepaginate(5);
                }
            }else{
                if ($get->status ==   'Завершен'){
                    $gets =  Prognoz::orderby('star', 'asc')->
                    orderby('start_carbon', 'asc')
                        ->orderby('star', 'asc')->with('country_name')
                        ->where('status' , 'Завершен')
                        ->where('id' , '!=', $get->id)
                        ->where('country_id', $get->country_id)
                        ->where('status' , 'Завершен')
                        ->with('country_name')
                        ->simplepaginate(5);
                } else{
                    $gets =  Prognoz::orderby('star', 'asc')->
                    orderby('start_carbon', 'asc')
                        ->orderby('star', 'asc')
                        ->where('status' , '!=', 'Завершен')
                        ->where('id' , '!=', $get->id)
                        ->where('country_id', $get->country_id)
                        ->where('status' , '!=', 'Завершен')
                        ->with('country_name')
                        ->simplepaginate(5);
                }
            }

            foreach ($gets as $data ){

                $date_valid = \Carbon\Carbon::parse($data->start_carbon);
                $current_time = \Carbon\Carbon::now();
                $diff = $date_valid->diffInMinutes($current_time);

                if ($diff > 0 && $diff <= 90) {
                    $string = "Начался";
                } elseif ($diff > 90 && \Carbon\Carbon::now() > $data->start_carbon) {
                    $string = "Завершен";
                } else {
                    $string = "Начало";
                }


                if ($data->status == 'Завершен'){
                    $data['style'] =  'color: #ba6161;font-size: 14px;';
                    if ($data->show_analize == 0){
                        $data['analize_div'] = 'display:none';
                    }else{
                        $get_all_attr = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->count();
                        $get_all_attr_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ' )->where('kf', '!=', null)->where('status', 1)->count();
                        $get_all_attr_star_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
                        $get_all_attr_star = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

                        $data['get_all_attr'] = $get_all_attr;
                        $data['get_all_attr_true'] = $get_all_attr_true;
                        $data['get_all_attr_star_true'] = $get_all_attr_star_true;
                        $data['get_all_attr_star'] = $get_all_attr_star;

                        $data->country_name->name = \App\Models\CountryTranslate::where('country_id' , $data->country_name->id)->where('lang', session()->get('locale'))->first()->name??$data->country_name->name;
                        $data->liga = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->liga??$data->liga;
                        $data->title = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->title??$data->title;


                    }



                }else{
                    $data['style']  = ' ';
                    $data['analize_div'] = 'display:none';
                }

                if ($data->status == 'Начался'){
                    $string = '';
                }elseif ($data->status == 'Завершен'){
                    $string = __('{makros_11}');
                }else{
                    $string = '';
                }

                $data['string'] = $string;

                if ($data->status == 'Начало'){

                    $data['diforhumans']  =  Carbon::parse($data->start_carbon)->diffforhumans();
                }else{
                    $data['diforhumans']  = ' ';
                }

                if ($data->star == 0){
                    $star_url = asset('public/images/cup.svg');
                }else{
                    $star_url = asset('uploads/'.$data->country_name->photo);

                }
                $data['star_url'] = $star_url;

                if ($data->url != null && $data->url != ' '){
                    $url = $data->url;
                }else{
                    $url = $data->title;
                }

                $lang =   session()->get('locale');

                if ($lang == 'ru'){

                }else{
                    $data['team_one'] = $data['team_one_two'];
                    $data['team_two'] = $data['team_two_two'];
                    $data['team_two_two'] = null;
                    $data['team_two_two_div'] = 'display:none';
                    $data['team_one_two_div'] = 'display:none';
                    $data['team_one_two'] = null;
                }
                $data['single_page'] = route('bet',[$url , $data->id]);
                $data['button_text'] = __('{makros_19}');
                $data['vsego'] = __('{makros_44}');
                $data['lucshaya'] = __('{makros_45}');
                $data->country_name->name = \App\Models\CountryTranslate::where('country_id' , $data->country_name->id)->where('lang', session()->get('locale'))->first()->name??$data->country_name->name;
                $data->liga = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->liga??$data->liga;
                $data->title = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first()->title??$data->title;


            }


            return response()->json([
                'status' => true,
                'data' => $gets,
                'next_page_url' =>$gets->nextPageUrl()
            ]);
        }


    if ($get->star == 0){
        if ($get->status ==   'Завершен'){
            $gets =  Prognoz::orderby('star', 'asc')->
            orderby('start_carbon', 'asc')
                ->orderby('star', 'asc')->with('country_name')
                ->where('status' , 'Завершен')
                ->where('id' , '!=', $get->id)
                ->where('country_id', $get->country_id)
                ->where('status' , 'Завершен')

                ->orWhere(function ($query) use ($get) {
                    $query->where('star', $get->star) ->orderby('star', 'asc')->
                    orderby('start_carbon', 'asc')
                        ->orderby('star', 'asc')
                        ->where('status' , '!=', 'Завершен')
                        ->where('id' , '!=', $get->id)
//                    ->where('country_id', $get->country_id)
                        ->where('status' , '!=', 'Завершен');
                })
                ->with('country_name')
                ->simplepaginate(5);
        } else{
            $gets =  Prognoz::orderby('star', 'asc')->
            orderby('start_carbon', 'asc')
                ->orderby('star', 'asc')
                ->where('status' , '!=', 'Завершен')
                ->where('id' , '!=', $get->id)
                ->where('country_id', $get->country_id)
                ->where('status' , '!=', 'Завершен')
                ->orWhere(function ($query) use ($get) {
                    $query->where('star', $get->star)  ->orderby('star', 'asc')->
                    orderby('start_carbon', 'asc')
                        ->orderby('star', 'asc')
                        ->where('status' , '!=', 'Завершен')
                        ->where('id' , '!=', $get->id)
//                    ->where('country_id', $get->country_id)
                        ->where('status' , '!=', 'Завершен');
                })
                ->with('country_name')
                ->simplepaginate(5);
        }
    }else{
        if ($get->status ==   'Завершен'){
            $gets =  Prognoz::orderby('star', 'asc')->
            orderby('start_carbon', 'asc')
                ->orderby('star', 'asc')->with('country_name')
                ->where('status' , 'Завершен')
                ->where('id' , '!=', $get->id)
                ->where('country_id', $get->country_id)
                ->where('status' , 'Завершен')
                ->with('country_name')
                ->simplepaginate(5);
        } else{
            $gets =  Prognoz::orderby('star', 'asc')->
            orderby('start_carbon', 'asc')
                ->orderby('star', 'asc')
                ->where('status' , '!=', 'Завершен')
                ->where('id' , '!=', $get->id)
                ->where('country_id', $get->country_id)
                ->where('status' , '!=', 'Завершен')
                ->with('country_name')
                ->simplepaginate(5);
        }
    }







        return view('bet', compact('get', 'end_date', 'newCity','end_date_two', 'gets'));
    }














    public function generate()
    {

        $langs = [
            'Русский' => '',
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
//            'Suomi' => 'fi',
            'Français' => 'fr',
            'Čeština' => 'cs',
            'Svenska' => 'sv',
            'Eesti' => 'et',
            'हिन्दी' => 'hi',

        ];


        $sitemap = app('sitemap');
        foreach ($langs as $lang){
            $sitemap->add(url("$lang/"));
            $sitemap->add(url("$lang/completed"));

            $urls ='';
            $get_prognozs = Prognoz::all();
            foreach ($get_prognozs as $prognoz){
                if ($prognoz->url != null && $prognoz->url != ' '){
                    $url = $prognoz->url.'/'.$prognoz->id;
                }else{
                    $url = $prognoz->title.'/'.$prognoz->id;
                }
                $url_prognoz =  url("$lang/bet/{$url}");
                $sitemap->add($url_prognoz);
            }

        }






        $get_new =     Prognoz::orderby('start_carbon', 'asc')
            ->whereBetween(
                DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)'),
                [Carbon::now(), DB::raw('TIMESTAMPADD(MINUTE, 105, start_carbon)')]
            )->get();

        foreach ($langs as $lang) {
            foreach ($get_new as $prognoz) {

                if ($prognoz->url != null && $prognoz->url != ' ') {
                    $url = $prognoz->url . '/' . $prognoz->id;
                } else {
                    $url = $prognoz->title . '/' . $prognoz->id;
                }
               
                $url_prognoz = url("$lang/bet/{$url}");
                $sitemap->add($url_prognoz);
                $url_prognoz_text = url("$lang/bet/{$url}");
                $urls .= $url_prognoz_text . "\n";

            }
        }



        $file_path = public_path('urls.txt'); // Указываем путь к файлу в корне
        file_put_contents($file_path, $urls);

        $sitemap->store('xml', 'sitemap');

        return true;
    }

}
