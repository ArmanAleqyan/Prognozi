@extends('layouts.default')
@extends('layouts.leftbar')
@section('title')
Прогноз на матч: {{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif - {{$get->team_two}} @if(isset($get->team_two_two))({{$get->team_two_two}})@endif, {{ $end_date}}
@endsection


    @section('alternate')
        <?php $langs = [
//    'Русский' => 'ru',
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

        ] ?>

        <?php
        if ($get->url != null && $get->url != ' '){
            $url = $get->url.'/'.$get->id;
        }else{
            $url = $get->title.'/'.$get->id;
        }
        ?>

        @foreach($langs as $lang)
            <link rel="alternate" hreflang="{{$lang}}"
                  href="{{url("$lang/bet/{$url}")}}" />
        @endforeach

        <link rel="alternate" hreflang="x-default"
              href="{{url("/bet/{$url}")}}" />
    @endsection

@section('description')
Прогноз на матч: {{$get->team_one}}@if(isset($get->team_one_two)) ({{$get->team_one_two}})@endif - {{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif, {{ $end_date}}. Прогноз на футбольный матч создан искусственным интеллектом с использованием умного анализа статистики.
@endsection
@section('content')
<?php

$date_valid = \Carbon\Carbon::parse($get->start_carbon);
$current_time = \Carbon\Carbon::now();
$add_90_minutes = \Carbon\Carbon::now()->addMinutes(105);
$diff = $current_time->diffInMinutes($date_valid);


if ($diff >= 0 && $diff <= 105  && $date_valid->isPast()) {
    $string = __('{makros_12}');
} elseif ($diff > 105 &&   \Carbon\Carbon::now() > $get->start_carbon) {
    $string = __('{makros_11}');
} else {
    $string = __("{makros_9}");
}
?>

<div class="rightbar">
    @if(session()->get('locale') == 'ru')
    <h1 class="h1-title">Прогноз на матч: {{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif - {{$get->team_two}} @if(isset($get->team_two_two))({{$get->team_two_two}})@endif</h1>
    @else
        <h1 class="h1-title">Прогноз на матч: @if(isset($get->team_one_two)){{$get->team_one_two}}@endif - @if(isset($get->team_two_two)){{$get->team_two_two}}@endif</h1>

        @endif

    <ul class="breadcrumbs">
        {{-- <li class="link"><a href="#">Главная</a></li>--}}
        @if($string == 'Завершен')
        <li class="link"><a href="{{route('completed')}}">{{__('{makros_23}')}}</a></li>
        @else
        <li class="link"><a href="{{route('home')}}">{{__("{makros_22}")}}</a></li>
        @endif
        @if(session()->get('locale') == 'ru')
        <li class="link" style="    color: #fff;  text-decoration: none;">{{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif - {{$get->team_two}} @if(isset($get->team_two_two))({{$get->team_two_two}})@endif</li>
            @else
            <li class="link" style="    color: #fff;  text-decoration: none;">@if(isset($get->team_one_two)){{$get->team_one_two}}@endif - @if(isset($get->team_two_two)){{$get->team_two_two}}@endif</li>

        @endif
    </ul>

    <div class="content">

        <div class="content__header">
            @if($get->star == 0)
            <img class="cup-icon" src="{{asset('public/images/cup.svg')}}" alt="cup.svg">
            @endif
            <img class="discipline-icon" src="{{asset('public/images/football.svg')}}" alt="football-icon">
            <div class="content__header__title">
                <div class="discipline-title">{{__('{makros_24}')}}</div>
                @if(session()->get('locale') == 'ru')
                <div class="match-descr">{{$get->country_name->name??$get->country}}: {{$get->liga}} - {{$get->title}}</div>
                    @else
                    <?php $get_prognoz = \App\Models\PrognozTranslate::where('prognoz_id', $get->id)->where('lang', session()->get('locale'))->first() ?>
                @if($get_prognoz  == null)
                    <div class="match-descr">{{$get->country_name->name??$get->country}}: {{$get->liga}} - {{$get->title}}</div>
                @else
                    <?php $new_country = \App\Models\CountryTranslate::where('country_id' , $get->country_name->id)->where('lang', session()->get('locale'))->first() ?>
                            <div class="match-descr">@if($new_country == null){{$get->country_name->name??$get->country}}@else{{$new_country->name}}@endif: {{$get_prognoz->liga}} - {{$get_prognoz->title}}</div>
                    @endif

                @endif
            </div>
        </div>
        <?php $lang_command =   session()->get('locale'); ?>
        <div class="match">
            @if($lang_command == 'ru')
            <div class="team-1-wrapper">
                <div class="team-1-logo">
                    <img src="{{asset('uploads/'.$get->team_one_logo)}}" alt="{{$get->team_one}}@if(isset($get->team_one_two)) ({{$get->team_one_two}})@endif" title="{{$get->team_one}}@if(isset($get->team_one_two)) ({{$get->team_one_two}})@endif">
                </div>
                <div class="team-1-name">{{$get->team_one}}</div>
                @if(isset($get->team_one_two))
                <div class="team-1-name" style="font-size: 11px">({{$get->team_one_two}})</div>
                @endif
            </div>
            @else
            <div class="team-1-wrapper">
                <div class="team-1-logo">
                    <img src="{{asset('uploads/'.$get->team_one_logo)}}" alt="{{$get->team_one}}@if(isset($get->team_one_two)) ({{$get->team_one_two}})@endif" title="{{$get->team_one}}@if(isset($get->team_one_two)) ({{$get->team_one_two}})@endif">
                </div>
                <div class="team-1-name">{{$get->team_one_two}}</div>
                @if(isset($get->team_one_two))
                <div class="team-1-name" style="font-size: 11px"></div>
                @endif
            </div>
            @endif

            <a class="go-bet-link" href="#">
                {{__('{makros_25}')}}
            </a>

            @if($lang_command == 'ru')
            <div class="team-2-wrapper">
                <div class="team-2-logo">
                    <img src="{{asset('uploads/'.$get->team_two_logo)}}" alt="{{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif" title="{{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif">
                </div>
                <div class="team-2-name">{{$get->team_two}}</div>
                @if(isset($get->team_two_two))
                <div class="team-2-name" style="font-size: 11px">({{$get->team_two_two}})</div>
                @endif
            </div>
            @else

            <div class="team-2-wrapper">
                <div class="team-2-logo">
                    <img src="{{asset('uploads/'.$get->team_two_logo)}}" alt="{{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif" title="{{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif">
                </div>
                <div class="team-2-name">{{$get->team_two_two}}</div>
                @if(isset($get->team_two_two))
                <div class="team-2-name" style="font-size: 11px"></div>
                @endif
            </div>
            @endif


        </div>

        <div class="match-info">
            <div class="start-time">
                <?php $old = \App\Models\TimeZone::where('zone', session()->get('timezone'))->first(); ?>
                <?php $originalTime = \Carbon\Carbon::parse($get->start_carbon)->format('H:i'); // Ваше исходное время
                $originalTimeZone = new DateTimeZone('Europe/Moscow'); // Ваша исходная временная зона


                // Создаем объект DateTime с исходным временем и временной зоной
                $dateTime = new DateTime($originalTime, $originalTimeZone);
                $newTimeZone = new DateTimeZone($old->zone ?? 'Europe/Moscow');



                $dateTime->setTimezone($newTimeZone);
                $formattedTime = $dateTime->format('H:i');
                ?>


                <div class="date">{{ $end_date_two}} </div>
                <?php $time = $get->start_carbon; // Example time valued

                //                $formattedTime = date("H:i", strtotime($time));
                ?>
                <?php $datetime = "{$get->start_date} {$get->start_time}";
                $date = \Carbon\Carbon::parse($datetime) ?>
                <div class="time">{{$formattedTime}}</div>{{$old->utc??'UTC+3'}}


            </div>

            <div class="time-left">
                <img src="../../public/public/images/time-icon.svg" alt="">
                @if($string == 'Начался' || $string == 'Завершен' ) <span @if($string=='Завершен' ) style="color: #ba6161 ;" @endif>{{$string}}</span> @else {{$string}} @endif <span>@if($string == 'Начался' || $string == 'Завершен' ) @else {{\Carbon\Carbon::parse($get->start_carbon)->diffforhumans()}} @endif</span>
            </div>
            @if($get->show_analize == 1)
            <?php
            $get_all_attr = \App\Models\PrognozAttr::where('prognoz_id', $get->id)->where('title', '!=', '  ')->where('kf', '!=', null)->count();
            $get_all_attr_true = \App\Models\PrognozAttr::where('prognoz_id', $get->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('status', 1)->count();
            $get_all_attr_star_true = \App\Models\PrognozAttr::where('prognoz_id', $get->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
            $get_all_attr_star = \App\Models\PrognozAttr::where('prognoz_id', $get->id)->where('title', '!=', '  ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

            ?>
{{--            <div class="count-wrapper-match">--}}
{{--                <div class="count-all">--}}
{{--                    <div class="count-all__title">Всего:</div>--}}
{{--                    <div class="count-all__num">{{$get_all_attr_true}}/{{$get_all_attr}}</div>--}}
{{--                </div>--}}

{{--                <div class="count-event">--}}
{{--                    <div class="count-event__title">Лучшая:</div>--}}
{{--                    <div class="count-event__num">{{$get_all_attr_star_true}}/{{$get_all_attr_star}}</div>--}}
{{--                </div>--}}
{{--            </div>--}}
            @endif
        </div>
        @if($get->show_analize == 1)
        <div class="all-bets-info">
            <img src="{{asset('public/images/info-icon.svg')}}" alt="info-icon">
            <div class="summ">Всего: {{$get_all_attr_true}}/{{$get_all_attr}}</div>
            <div class="best">Лучшие: {{$get_all_attr_star_true}}/{{$get_all_attr_star}}</div>
        </div>
        @endif

        <div class="all-bets">
            @foreach($get->attr->groupBy('group_id') as $atributes)

            <div class="bet @if($atributes[0]->super == 0 && $atributes[0]->super != null) favorite-bet @endif">

                <div class="pre-info">
                    @if($atributes[0]->super == 0 && $atributes[0]->super != null)
                    <div class="favorite">
                        <div>
                            <!-- 🔥 -->
                            <!-- <img src="/public/public/images/crown.svg" alt="crown.svg"> -->

                            {{-- Лучшая ставка--}}
                            {{__('{makros_38}')}}
                        </div>

                    </div>
                    @endif
                </div>

                <div class="row-1  @if($atributes[0]->super == 0 && $atributes[0]->super != null) favorite-bet @endif">

                    <div>
                        @foreach($atributes as $atribute)
                        @if($atribute->title != null && $atribute->title != ' ' && $atribute->kf != null && $atribute->kf != ' ' )
                        <div class="bet__variant favorite">
    
                            <table id="favorite-table" class="favorite-table">
                                    <tr>
                                        @if($get->show_analize == 1)
                                        <td rowspan="0" width="10px" style="background: @if($atribute->status == 1) #6DDA6B; @else #FF3030 @endif " ></td>
                                        @endif
                                        @if($atribute->title != null && $atribute->title != ' ')
                                        <th>{{__("{makros_39}")}}</th>
                                        @endif
                                        @if($atribute->kf != null && $atribute->kf != ' ')
                                        <th> {{__('{makros_41}')}}</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if($atribute->title != null && $atribute->title != ' ')
                                            <?php $get_attr_trans = \App\Models\AttrTranslate::where('lang', session()->get('locale'))->where('attr_id', $atribute->id)->first(); ?>
                                                            @if($get_attr_trans == null)
                                            <td><a class="variant" href="#">{{$atribute->title}}</a></td>
                                                                @else
                                                    <td><a class="variant" href="#"> {{str_replace('“', ' ',  str_replace('„', ' ',$get_attr_trans->title) ) }}</a></td>
                                                                @endif
                                        @endif
                                        @if($atribute->kf != null && $atribute->kf != ' ')
                                        <td><a class="ratio" href="#">{{$atribute->kf}}</a></td>
                                        @endif
                                    </tr>
                            </table>
    
                            <!-- 
                            @if($atribute->title != null && $atribute->title != ' ')
                            {{-- Ставка:--}}
                            {{__("{makros_39}")}}
                            <a class="variant" href="#">{{$atribute->title}}</a>
                            @endif
                            @if($atribute->kf != null && $atribute->kf != ' ')
                            {{-- КФ:--}}
                            {{__('{makros_41}')}}
                            <a class="ratio" href="#">{{$atribute->kf}}</a>
                            @endif -->
    
    
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <img class="arrow" src="{{asset('public/images/arrow.svg')}}" alt="arrow">
                </div>

                <div class="bet__text-generation">
                    @foreach($atributes as $atribute)
                    @if($atribute->attr != null || $atribute->attr != ' ')

                        <?php $get_attr_trans = \App\Models\AttrTranslate::where('lang', session()->get('locale'))->where('attr_id', $atribute->id)->first(); ?>

                        @if($get_attr_trans == null)
                            {!! $atribute->attr !!}
                            @else

                            

                            {!!str_replace('“', ' ',  str_replace('„', ' ',$get_attr_trans->attr) )  !!}
                            @endif
                    @endif

                    @endforeach
                </div>
            </div>
            @endforeach

        </div>

        <div class="seo-text">
            Ищете точный бесплатный прогноз на футбольный матч {{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif - {{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif, который состоится {{ $end_date}}? На данной странице вы точно найдете самый актуальный бесплатный прогноз на футбольный матч {{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif - {{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif. Ставка на футбольный матч - это всегда риск, но с нашим бесплатным прогнозом от ИИ на матч {{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif и {{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif ваши шансы на успех значительно увеличиваются. Бесплатный прогноз ставки на футбольный матч между командами {{$get->team_one}} @if(isset($get->team_one_two))({{$get->team_one_two}})@endif и {{$get->team_two}}@if(isset($get->team_two_two)) ({{$get->team_two_two}})@endif, который пройдет {{$end_date}}. Футбол {{$get->country->name??$get->country}} прогноз. Бесплатный прогноз на матчи {{$newCity}}.
        </div>
    </div>
</div>
@endsection
