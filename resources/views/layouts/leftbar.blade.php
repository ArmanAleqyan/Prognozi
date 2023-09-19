<?php $lang =  session()->get('locale'); if ($lang == 'ru'){$lang ='';} ?>

@section('leftbar')
<div class="leftbar">
    <div class="menu">
        <div class="logo">
            <a href="{{route("home")}}"><img src="{{asset('public/images/logo.svg')}}" alt="logo"></a>
        </div>
        <?php use Carbon\Carbon;
        $utcTime = Carbon::now()->timezoneAbbreviatedName;
        $old = \App\Models\TimeZone::where('zone', session()->get('timezone'))->first();
        $get_timzone = \App\Models\TimeZone::where('utc' , '!=', $old->utc??null)->distinct()->pluck('utc');   ?>
        <div class="utc">
           {{$old->utc??'UTC+3'}}
        </div>
        <div class="utc__list">
            @foreach($get_timzone as $tz)
            <div class="item"><a href="{{route('set_timzone',$tz)}}">{{$tz}}</a> </div>
                @endforeach
        </div>

        <?php $langs = [
            'Русский' => 'ru',
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

        ] ?>


        <div class="language">
            @foreach($langs as $key => $lang)
                @if(session()->get('locale') !=null  &&  $lang == session()->get('locale')  )
            <div class="language__title">
                <img src="{{asset('Flags/'.$lang.'.png')}}" alt="language-icon">
                {{$key}}
            </div>
                    @endif
            @endforeach
            @if(  session()->get('locale') == null)
                    <div class="language__title">
                        <img src="{{asset('Flags/'.'ru'.'.png')}}" alt="language-icon">
                        Русский
                    </div>
                @endif
            <ul class="language__list">
                @foreach($langs as $key => $lang)
                    <a href="{{route('set_locale', $lang)}}"><li>
                    <img src="{{asset('Flags/'.$lang.'.png')}}" alt="language-icon">
                    {{$key}}
                </li>
                    </a>
                @endforeach

            </ul>
        </div>

        <?php $currentRoute = Route::current()->getName(); ?>
        <nav class="navbar">
           {{__('{makros_1}')}}
{{--            Навигация:--}}
            <ul>
                <li @if($currentRoute =='home' ) class="active" @endif><a href="{{route("home")}}">{{__('{makros_2}')}}</a></li>
                <li  @if($currentRoute =='completed' ) class="active" @endif ><a href="{{route("completed")}}"> {{__('{makros_3}')}}</a></li>
            </ul>

        </nav>

        <div class="menu-button">
            <svg width="30" height="30" viewBox="0 0 50 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect id="rect1" x="0" y="0" width="50" height="3" rx="1.5" fill="#D9D9D9" />
                <rect id="rect2" x="0" y="12" width="50" height="3" rx="1.5" fill="#D9D9D9" />
                <rect id="rect3" x="0" y="24" width="50" height="3" rx="1.5" fill="#D9D9D9" />
            </svg>
        </div>

        <div class="navbar-mobile">
            <div class="utc-mobile">
                {{$old->utc??'UTC+3'}}
            </div>
            <div class="utc-mobile__list">
                @foreach($get_timzone as $tz)
                    <div class="item"><a href="{{route('set_timzone',$tz)}}">{{$tz}}</a> </div>
                @endforeach

            </div>
            <div class="language-mobile">
                @foreach($langs as $key => $lang)
                    @if(session()->get('locale') !=null  &&  $lang == session()->get('locale')  )
                        <div class="language-mobile__title">
                            <img src="{{asset('Flags/'.$lang.'.png')}}" alt="language-icon">
                            {{$key}}
                        </div>
                    @endif
                @endforeach

                <ul class="language-mobile__list">
                    @foreach($langs as $key => $lang)
                        <a href="{{route('set_locale', $lang)}}"><li>
                                <img src="{{asset('Flags/'.$lang.'.png')}}" alt="language-icon">
                                {{$key}}
                            </li>
                        </a>
                    @endforeach
                        @if(  session()->get('locale') == null)
                            <div class="language__title">
                                <img src="{{asset('Flags/'.'ru'.'.png')}}" alt="language-icon">
                                Русский
                            </div>
                        @endif
                </ul>
            </div>
            {{__('{makros_1}')}}
            <ul>
                <li  @if($currentRoute =='home' ) class="active" @endif><a href="{{route("home")}}"> {{__('{makros_2}')}}</a></li>
                <li  @if($currentRoute =='completed' ) class="active" @endif><a href="{{route("completed")}}">{{__('{makros_3}')}}</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection