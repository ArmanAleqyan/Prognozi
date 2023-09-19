<?php $lang =  session()->get('locale');
if ($lang == 'ru') {
    $lang = '';
} ?>
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
@extends('layouts.default')
@section('title')
{{__("{makros_4}")}}
@endsection
@section('alternate')

    @if(Route::currentRouteName() == 'home')
        @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{$lang}}"
              href="{{url($lang.'/')}}" />
    @endforeach
    <link rel="alternate" hreflang="x-default"
          href="{{url('/')}}" />
    @endif
    @if(Route::currentRouteName() == 'completed')
        @foreach($langs as $lang)
            <link rel="alternate" hreflang="{{$lang}}"
                  href="{{url($lang.'/completed')}}" />
        @endforeach
        <link rel="alternate" hreflang="x-default"
              href="{{url('completed/')}}" />
    @endif






    @endsection
@section('description')
{{__("{makros_5}")}}
{{__('{makros_6}')}}
@endsection

@if(Route::currentRouteName() == 'home')
{{--    home--}}
    <style>
        .bet {
            grid-template-columns: 200px 180px 1fr max-content !important
        }
    </style>
    @else
{{--    complated--}}
    <style>
        .bet {
            grid-template-columns: 200px 180px 1fr max-content max-content
        }
    </style>
    @endif

@extends('layouts.leftbar')
@section('content')
<div class="rightbar">

    <h1 class="h1-title">{{__('{makros_6}')}}</h1>
    <ul class="list-filter">
        <li class="active all_filter">{{__('{makros_7}')}}</li>
        <?php $currentRoute = Route::current()->getName(); ?>
        @if($currentRoute == 'home')
        <?php $star_count = \App\Models\Prognoz::where('star', 0)->where('status', '!=', 'Завершен')->count(); ?>
        @else
        <?php $star_count = \App\Models\Prognoz::where('star', 0)->where('status',  'Завершен')->count(); ?>
        @endif
        @if($star_count > 0)
        <li class="star_filter">
            <img src="{{asset('public/images/cup.svg')}}" alt="country-icon">
            {{__('{makros_8}')}}
        </li>
        @endif

        @foreach($all_country as $country)
        @if($currentRoute == 'home')
        <?php $get_country = \App\Models\Prognoz::where('country_id', $country->id)->where('status', '!=', 'Завершен')->count(); ?>
        @else
        <?php $get_country = \App\Models\Prognoz::where('country_id', $country->id)->where('status', 'Завершен')->count(); ?>
        @endif
        @if($get_country > 0)
        <li data_id="{{$country->id}}" class="country_filter">
            <?php $get_country = \App\Models\CountryTranslate::where('country_id' , $country->id)->where('lang', session()->get('locale'))->first()  ?>
            <img src="{{asset('uploads/'.$country->photo)}}" alt="country-icon">
                @if($get_country == null)
            {{$country->name}}
                    @else
            {{$get_country->name}}
            @endif
        </li>
        @endif
        @endforeach
        <input type="hidden" name="route" value="{{Route::currentRouteName()}}">

    </ul>
    @if(Route::currentRouteName() == 'completed')
    <div class="all-bets-info">
        <img src="{{asset('public/images/info-icon.svg')}}" alt="info-icon">

        <?php
            $get_old = \App\Models\Prognoz::where('status', 'Завершен')->get('id')->pluck('id')->toarray();
        $get_all_attr = \App\Models\PrognozAttr::where('title', '!=', '  ')->wherein('prognoz_id',$get_old)->where('kf', '!=', null)->count();
        $get_all_attr_true = \App\Models\PrognozAttr::where('title', '!=', '  ')->wherein('prognoz_id',$get_old)->where('kf', '!=', null)->where('status', 1)->count();
        $get_all_attr_star_true = \App\Models\PrognozAttr::where('title', '!=', '  ')->wherein('prognoz_id',$get_old)->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
        $get_all_attr_star = \App\Models\PrognozAttr::where('title', '!=', '  ')->wherein('prognoz_id',$get_old)->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

        ?>

        <div class="summ">Всего: {{$get_all_attr_true}}/{{$get_all_attr}}</div>
        <div class="best">Лучшие: {{$get_all_attr_star_true}}/{{$get_all_attr_star}}</div>
    </div>
@endif
    <div class="content-bets">
        @foreach($get as $data)

        <div class="bet favorite">
            <div class="title">


                @if($data->star == 0)
                <img class="cup" src="{{asset('public/images/cup.svg')}}" alt="cup.svg">
                @else

                <img src="{{asset('uploads/'.$data->country_name->photo)}}" alt="">
                @endif
                <div class="title__country-name__wrapper">
                    @if(session()->get('locale') == 'ru')
                    <p style="    text-transform: uppercase;">{{$data->country_name->name??$data->country}}</p> {{$data->liga}} - {{$data->title}}
                    @else
                        <?php $get_prognoz = \App\Models\PrognozTranslate::where('prognoz_id', $data->id)->where('lang', session()->get('locale'))->first() ?>
                        <?php $new_country = \App\Models\CountryTranslate::where('country_id' , $data->country_name->id)->where('lang', session()->get('locale'))->first() ?>
                            @if($get_prognoz  == null)
                                <p style="    text-transform: uppercase;">@if($new_country == null){{$data->country_name->name??$data->country}}@else{{$new_country->name}}@endif</p> {{$data->liga}} - {{$data->title}}
                            @else


                                <p style="    text-transform: uppercase;">@if($new_country == null){{$data->country_name->name??$data->country}}@else{{$new_country->name}}@endif</p> {{$get_prognoz->liga}} - {{$get_prognoz->title}}
                            @endif
                    @endif

                </div>

                <?php $datetime = "{$data->start_date} {$data->start_time}";
                $date = \Carbon\Carbon::parse($datetime) ?>

            </div>
            <!--                --><?php
                                    //
                                    //                $date_valid = \Carbon\Carbon::parse($data->start_carbon);
                                    //                $current_time = \Carbon\Carbon::now();
                                    //                $diff = $date_valid->diffInMinutes($current_time);
                                    //
                                    //                if ($data->status  == 'Начался') {
                                    //                    $string = __("{makros_12}");
                                    //                } elseif ($diff > 90 && \Carbon\Carbon::now() > $data->start_carbon) {
                                    //                    $string = __('{makros_11}');
                                    //                } else {
                                    //                    $string = __('{makros_9}') ;
                                    //                }
                                    //                
                                    ?>

            <?php if ($data->status == 'Начался') {
                $string = __('{makros_12}');
            } elseif ($data->status == 'Завершен') {
                $string = __('{makros_11}');
            } else {
                $string = __('{makros_9}');
            } ?>

            <div class="time-left"><img src="../../public/public/images/time-icon.svg" alt=""> @if($string == __('{makros_12}') || $string == __('{makros_11}')) <span @if($string==__('{makros_11}') ) style="color: #ba6161 ;" @endif>{{$string}}</span> @else @endif <span>@if($string == __('{makros_12}') || $string == __('{makros_11}') ) @else {{\Carbon\Carbon::parse($data->start_carbon)->diffforhumans()}} @endif</span></div>

            <div class="teams">

                <div class="team-1">
                    <img class="team-1-logo" src="{{asset('uploads/'.$data->team_one_logo)}}" alt="team-1">
                    @if(session()->get('locale') == 'ru')
                    <div class="team-1-name" style="display: flex; justify-content: center;">{{$data->team_one}}</div>
                    @if(isset($data->team_one_two))
                    <div class="team-1-name__alternate" style="display: flex; justify-content: center; font-size: 10px">({{$data->team_one_two}})</div>
                    @endif
                    @else
                    @if(isset($data->team_one_two))
                    <div class="team-1-name__alternate" style="display: flex; justify-content: center;">{{$data->team_one_two}}</div>
                    @endif

                    @endif
                </div>

                <div class="team-2">
                    <img class="team-2-logo" src="{{asset('uploads/'.$data->team_two_logo)}}" alt="team-1">
                    @if(session()->get('locale') == 'ru')
                    <div class="team-2-name" style="text-align: center">
                        {{$data->team_two}}
                    </div>
                    @if(isset($data->team_two_two))
                    <div class="team-2-name__alternate" style="text-align: center ; font-size:10px; ;">
                        ({{$data->team_two_two}})
                    </div>
                    @endif
                    @else
                    <div class="team-2-name__alternate" style="text-align: center ; ">
                        {{$data->team_two_two}}
                    </div>
                    @endif

                </div>
            </div>
            @if($data->url != null && $data->url != ' ')
            <?php $url = $data->url ?>
            @else
            <?php $url = $data->title ?>
            @endif
            @if($data->status == 'Завершен')
            @if($data->show_analize == 1)
            <div class="count-wrapper">
                <?php
                $get_all_attr = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', ' ')->where('kf', '!=', null)->count();
                $get_all_attr_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', ' ')->where('kf', '!=', null)->where('status', 1)->count();
                $get_all_attr_star_true = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', ' ')->where('kf', '!=', null)->where('super', 0)->where('status', 1)->count();
                $get_all_attr_star = \App\Models\PrognozAttr::where('prognoz_id', $data->id)->where('title', '!=', ' ')->where('kf', '!=', null)->where('super', 0)->where('super', 0)->count();

                ?>


                <div class="count-all">
                    <div class="count-all__title">Всего:</div>
                    <div class="count-all__num">{{$get_all_attr_true}}/{{$get_all_attr}}</div>
                </div>


                <div class="count-event">
                    <div class="count-event__title">Лучшая:</div>
                    <div class="count-event__num">{{$get_all_attr_star_true}}/{{$get_all_attr_star}}</div>
                </div>
            </div>
            @endif
            @endif

            <a href="{{route('bet', [$url , $data->id])}}"><button type="button" class="main-btn">{{__("{makros_19}")}}</button></a>
        </div>

        {{-- @endif--}}
        @endforeach




    </div>
    @if($get->nextPageUrl() != null)
    <div class="pagination_div" style="display: flex; justify-content: center;">
        <p class="pagination" style="cursor: pointer; color: #e2e8f0" data_url="{{$get->nextPageUrl()}}">{{__('{makros_20}')}}</p>
    </div>
    @endif

    <div class="seo-text">
        {{__('{makros_21}')}}
    </div>
    @endsection
