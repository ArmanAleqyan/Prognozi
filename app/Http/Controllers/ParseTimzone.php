<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeZone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ParseTimzone extends Controller
{


    public function set_locale(Request $request,$lang){


        $old_lang  = session()->get('locale');

        session(['locale' => $lang]);

        if ($old_lang != 'ru'){
            App::setLocale($lang);
            app()->setLocale($lang);

            LaravelLocalization::setLocale($lang);
            $currentLocale = LaravelLocalization::getCurrentLocale();
            $newTranslation = $lang;
            $previousUrl = url()->previous();

            $urlParts = explode('/', $previousUrl);



            $urlParts[3] = $lang;
            $newUrl = implode('/', $urlParts);
        }else{
            App::setLocale($lang);
            app()->setLocale($lang);

            LaravelLocalization::setLocale($lang);
            $currentLocale = LaravelLocalization::getCurrentLocale();
            $newTranslation = $lang;
            $previousUrl = url()->previous();

            $urlParts = explode('/', $previousUrl);

       

            $urlParts[2] = $urlParts[2].'/'.$lang;
            $newUrl = implode('/', $urlParts);
        }



        return redirect($newUrl);
    }



    public function parse_time_zone(){




//        $timezones = [
//            "Africa/Abidjan" => "UTC+0",
//            "Africa/Accra" => "UTC+0",
//            "Africa/Addis_Ababa" => "UTC+3",
//            "Africa/Algiers" => "UTC+1",
//            "Africa/Asmara" => "UTC+3",
//            "Africa/Bamako" => "UTC+0",
//            "Africa/Bangui" => "UTC+1",
//            "Africa/Banjul" => "UTC+0",
//            "Africa/Bissau" => "UTC+0",
//            "Africa/Blantyre" => "UTC+2",
//            "Africa/Brazzaville" => "UTC+1",
//            "Africa/Bujumbura" => "UTC+2",
//            "Africa/Cairo" => "UTC+2",
//            "Africa/Casablanca" => "UTC+0",
//            "Africa/Ceuta" => "UTC+1",
//            "Africa/Conakry" => "UTC+0",
//            "Africa/Dakar" => "UTC+0",
//            "Africa/Dar_es_Salaam" => "UTC+3",
//            "Africa/Djibouti" => "UTC+3",
//            "Africa/Douala" => "UTC+1",
//            "Africa/El_Aaiun" => "UTC+0",
//            "Africa/Freetown" => "UTC+0",
//            "Africa/Gaborone" => "UTC+2",
//            "Africa/Harare" => "UTC+2",
//            "Africa/Johannesburg" => "UTC+2",
//            "Africa/Juba" => "UTC+3",
//            "Africa/Kampala" => "UTC+3",
//            "Africa/Khartoum" => "UTC+2",
//            "Africa/Kigali" => "UTC+2",
//            "Africa/Kinshasa" => "UTC+1",
//            "Africa/Lagos" => "UTC+1",
//            "Africa/Libreville" => "UTC+1",
//            "Africa/Lome" => "UTC+0",
//            "Africa/Luanda" => "UTC+1",
//            "Africa/Lubumbashi" => "UTC+2",
//            "Africa/Lusaka" => "UTC+2",
//            "Africa/Malabo" => "UTC+1",
//            "Africa/Maputo" => "UTC+2",
//            "Africa/Maseru" => "UTC+2",
//            "Africa/Mbabane" => "UTC+2",
//            "Africa/Mogadishu" => "UTC+3",
//            "Africa/Monrovia" => "UTC+0",
//            "Africa/Nairobi" => "UTC+3",
//            "Africa/Ndjamena" => "UTC+1",
//            "Africa/Niamey" => "UTC+1",
//            "Africa/Nouakchott" => "UTC+0",
//            "Africa/Ouagadougou" => "UTC+0",
//            "Africa/Porto-Novo" => "UTC+1",
//            "Africa/Sao_Tome" => "UTC+0",
//            "Africa/Tripoli" => "UTC+2",
//            "Africa/Tunis" => "UTC+1",
//            "Africa/Windhoek" => "UTC+2",
//            "America/Adak" => "UTC-10",
//            "America/Anchorage" => "UTC-8",
//            "America/Anguilla" => "UTC-4",
//            "America/Antigua" => "UTC-4",
//            "America/Araguaina" => "UTC-3",
//            "America/Argentina/Buenos_Aires" => "UTC-3",
//            "America/Argentina/Catamarca" => "UTC-3",
//            "America/Argentina/Cordoba" => "UTC-3",
//            "America/Argentina/Jujuy" => "UTC-3",
//            "America/Argentina/La_Rioja" => "UTC-3",
//            "America/Argentina/Mendoza" => "UTC-3",
//            "America/Argentina/Rio_Gallegos" => "UTC-3",
//            "America/Argentina/Salta" => "UTC-3",
//            "America/Argentina/San_Juan" => "UTC-3",
//            "America/Argentina/San_Luis" => "UTC-3",
//            "America/Argentina/Tucuman" => "UTC-3",
//            "America/Argentina/Ushuaia" => "UTC-3",
//            "America/Aruba" => "UTC-4",
//            "America/Asuncion" => "UTC-4",
//            "America/Atikokan" => "UTC-5",
//            "America/Bahia" => "UTC-3",
//            "America/Bahia_Banderas" => "UTC-6",
//            "America/Barbados" => "UTC-4",
//            "America/Belem" => "UTC-3",
//            "America/Belize" => "UTC-6",
//            "America/Blanc-Sablon" => "UTC-4",
//            "America/Boa_Vista" => "UTC-4",
//            "America/Bogota" => "UTC-5",
//            "America/Boise" => "UTC-6",
//            "America/Cambridge_Bay" => "UTC-7",
//            "America/Campo_Grande" => "UTC-4",
//            "America/Cancun" => "UTC-5",
//            "America/Caracas" => "UTC-4",
//            "America/Cayenne" => "UTC-3",
//            "America/Cayman" => "UTC-5",
//            "America/Chicago" => "UTC-5",
//            "America/Chihuahua" => "UTC-7",
//            "America/Ciudad_Juarez" => "UTC-7",
//            "America/Costa_Rica" => "UTC-6",
//            "America/Creston" => "UTC-7",
//            "America/Cuiaba" => "UTC-4",
//            "America/Curacao" => "UTC-4",
//            "America/Danmarkshavn" => "UTC+0",
//            "America/Dawson" => "UTC-8",
//            "America/Dawson_Creek" => "UTC-7",
//            "America/Denver" => "UTC-6",
//            "America/Detroit" => "UTC-5",
//            "America/Dominica" => "UTC-4",
//            "America/Edmonton" => "UTC-7",
//            "America/Eirunepe" => "UTC-5",
//            "America/El_Salvador" => "UTC-6",
//            "America/Fort_Nelson" => "UTC-7",
//            "America/Fortaleza" => "UTC-3",
//            "America/Glace_Bay" => "UTC-4",
//            "America/Goose_Bay" => "UTC-4",
//            "America/Grand_Turk" => "UTC-5",
//            "America/Grenada" => "UTC-4",
//            "America/Guadeloupe" => "UTC-4",
//            "America/Guatemala" => "UTC-6",
//            "America/Guayaquil" => "UTC-5",
//            "America/Guyana" => "UTC-4",
//            "America/Halifax" => "UTC-4",
//            "America/Havana" => "UTC-5",
//            "America/Hermosillo" => "UTC-7",
//            "America/Indiana/Indianapolis" => "UTC-5",
//            "America/Indiana/Knox" => "UTC-6",
//            "America/Indiana/Marengo" => "UTC-5",
//            "America/Indiana/Petersburg" => "UTC-5",
//            "America/Indiana/Tell_City" => "UTC-6",
//            "America/Indiana/Vevay" => "UTC-5",
//            "America/Indiana/Vincennes" => "UTC-5",
//            "America/Indiana/Winamac" => "UTC-5",
//            "America/Inuvik" => "UTC-7",
//            "America/Iqaluit" => "UTC-5",
//            "America/Jamaica" => "UTC-5",
//            "America/Juneau" => "UTC-9",
//            "America/Kentucky/Louisville" => "UTC-5",
//            "America/Kentucky/Monticello" => "UTC-5",
//            "America/Kralendijk" => "UTC-4",
//            "America/La_Paz" => "UTC-4",
//            "America/Lima" => "UTC-5",
//            "America/Los_Angeles" => "UTC-8",
//            "America/Lower_Princes" => "UTC-4",
//            "America/Maceio" => "UTC-3",
//            "America/Managua" => "UTC-6",
//            "America/Manaus" => "UTC-4",
//            "America/Marigot" => "UTC-4",
//            "America/Martinique" => "UTC-4",
//            "America/Matamoros" => "UTC-6",
//            "America/Mazatlan" => "UTC-7",
//            "America/Menominee" => "UTC-6",
//            "America/Merida" => "UTC-6",
//            "America/Metlakatla" => "UTC-9",
//            "America/Mexico_City" => "UTC-6",
//            "America/Miquelon" => "UTC-3",
//            "America/Moncton" => "UTC-4",
//            "America/Monterrey" => "UTC-6",
//            "America/Montevideo" => "UTC-3",
//            "America/Montserrat" => "UTC-4",
//            "America/Nassau" => "UTC-5",
//            "America/New_York" => "UTC-5",
//            "America/Nome" => "UTC-9",
//            "America/Noronha" => "UTC-2",
//            "America/North_Dakota/Beulah" => "UTC-6",
//            "America/North_Dakota/Center" => "UTC-6",
//            "America/North_Dakota/New_Salem" => "UTC-6",
//            "America/Nuuk" => "UTC-3",
//            "America/Ojinaga" => "UTC-7",
//            "America/Panama" => "UTC-5",
//            "America/Paramaribo" => "UTC-3",
//            "America/Phoenix" => "UTC-7",
//            "America/Port-au-Prince" => "UTC-5",
//            "America/Port_of_Spain" => "UTC-4",
//            "America/Porto_Velho" => "UTC-4",
//            "America/Puerto_Rico" => "UTC-4",
//            "America/Punta_Arenas" => "UTC-3",
//            "America/Rankin_Inlet" => "UTC-6",
//            "America/Recife" => "UTC-3",
//            "America/Regina" => "UTC-6",
//            "America/Resolute" => "UTC-6",
//            "America/Rio_Branco" => "UTC-5",
//            "America/Santarem" => "UTC-3",
//            "America/Santiago" => "UTC-3",
//            "America/Santo_Domingo" => "UTC-4",
//            "America/Sao_Paulo" => "UTC-3",
//            "America/Scoresbysund" => "UTC-1",
//            "America/Sitka" => "UTC-9",
//            "America/St_Barthelemy" => "UTC-4",
//            "America/St_Johns" => "UTC-3.5",
//            "America/St_Kitts" => "UTC-4",
//            "America/St_Lucia" => "UTC-4",
//            "America/St_Thomas" => "UTC-4",
//            "America/St_Vincent" => "UTC-4",
//            "America/Swift_Current" => "UTC-6",
//            "America/Tegucigalpa" => "UTC-6",
//            "America/Thule" => "UTC-4",
//            "America/Tijuana" => "UTC-8",
//            "America/Toronto" => "UTC-5",
//            "America/Tortola" => "UTC-4",
//            "America/Vancouver" => "UTC-8",
//            "America/Whitehorse" => "UTC-8",
//            "America/Winnipeg" => "UTC-6",
//            "America/Yakutat" => "UTC-9",
//            "Antarctica/Casey" => "UTC+11",
//            "Antarctica/Davis" => "UTC+7",
//            "Antarctica/DumontDUrville" => "UTC+10",
//            "Antarctica/Macquarie" => "UTC+11",
//            "Antarctica/Mawson" => "UTC+5",
//            "Antarctica/McMurdo" => "UTC+13",
//            "Antarctica/Palmer" => "UTC-3",
//            "Antarctica/Rothera" => "UTC-3",
//            "Antarctica/Syowa" => "UTC+3",
//            "Antarctica/Troll" => "UTC+0",
//            "Antarctica/Vostok" => "UTC+6",
//            "Arctic/Longyearbyen" => "UTC+1",
//            "Asia/Aden" => "UTC+3",
//            "Asia/Almaty" => "UTC+6",
//            "Asia/Amman" => "UTC+2",
//            "Asia/Anadyr" => "UTC+12",
//            "Asia/Aqtau" => "UTC+5",
//            "Asia/Aqtobe" => "UTC+5",
//            "Asia/Ashgabat" => "UTC+5",
//            "Asia/Atyrau" => "UTC+5",
//            "Asia/Baghdad" => "UTC+3",
//            "Asia/Bahrain" => "UTC+3",
//            "Asia/Baku" => "UTC+4",
//            "Asia/Bangkok" => "UTC+7",
//            "Asia/Barnaul" => "UTC+7",
//            "Asia/Beirut" => "UTC+2",
//            "Asia/Bishkek" => "UTC+6",
//            "Asia/Brunei" => "UTC+8",
//            "Asia/Chita" => "UTC+9",
//            "Asia/Choibalsan" => "UTC+8",
//            "Asia/Colombo" => "UTC+5.5",
//            "Asia/Damascus" => "UTC+2",
//            "Asia/Dhaka" => "UTC+6",
//            "Asia/Dili" => "UTC+9",
//            "Asia/Dubai" => "UTC+4",
//            "Asia/Dushanbe" => "UTC+5",
//            "Asia/Famagusta" => "UTC+2",
//            "Asia/Gaza" => "UTC+2",
//            "Asia/Hebron" => "UTC+2",
//            "Asia/Ho_Chi_Minh" => "UTC+7",
//            "Asia/Hong_Kong" => "UTC+8",
//            "Asia/Hovd" => "UTC+7",
//            "Asia/Irkutsk" => "UTC+8",
//            "Asia/Jakarta" => "UTC+7",
//            "Asia/Jayapura" => "UTC+9",
//            "Asia/Jerusalem" => "UTC+2",
//            "Asia/Kabul" => "UTC+4.5",
//            "Asia/Kamchatka" => "UTC+12",
//            "Asia/Karachi" => "UTC+5",
//            "Asia/Kathmandu" => "UTC+5.75",
//            "Asia/Khandyga" => "UTC+9",
//            "Asia/Kolkata" => "UTC+5.5",
//            "Asia/Krasnoyarsk" => "UTC+7",
//            "Asia/Kuala_Lumpur" => "UTC+8",
//            "Asia/Kuching" => "UTC+8",
//            "Asia/Kuwait" => "UTC+3",
//            "Asia/Macau" => "UTC+8",
//            "Asia/Magadan" => "UTC+11",
//            "Asia/Makassar" => "UTC+8",
//            "Asia/Manila" => "UTC+8",
//            "Asia/Muscat" => "UTC+4",
//            "Asia/Nicosia" => "UTC+2",
//            "Asia/Novokuznetsk" => "UTC+7",
//            "Asia/Novosibirsk" => "UTC+7",
//            "Asia/Omsk" => "UTC+7",
//            "Asia/Oral" => "UTC+5",
//            "Asia/Phnom_Penh" => "UTC+7",
//            "Asia/Pontianak" => "UTC+7",
//            "Asia/Pyongyang" => "UTC+9",
//            "Asia/Qatar" => "UTC+3",
//            "Asia/Qostanay" => "UTC+6",
//            "Asia/Qyzylorda" => "UTC+6",
//            "Asia/Riyadh" => "UTC+3",
//            "Asia/Sakhalin" => "UTC+11",
//            "Asia/Samarkand" => "UTC+5",
//            "Asia/Seoul" => "UTC+9",
//            "Asia/Shanghai" => "UTC+8",
//            "Asia/Singapore" => "UTC+8",
//            "Asia/Srednekolymsk" => "UTC+11",
//            "Asia/Taipei" => "UTC+8",
//            "Asia/Tashkent" => "UTC+5",
//            "Asia/Tbilisi" => "UTC+4",
//            "Asia/Tehran" => "UTC+3.5",
//            "Asia/Thimphu" => "UTC+6",
//            "Asia/Tokyo" => "UTC+9",
//            "Asia/Tomsk" => "UTC+7",
//            "Asia/Ulaanbaatar" => "UTC+8",
//            "Asia/Urumqi" => "UTC+6",
//            "Asia/Ust-Nera" => "UTC+10",
//            "Asia/Vientiane" => "UTC+7",
//            "Asia/Vladivostok" => "UTC+10",
//            "Asia/Yakutsk" => "UTC+9",
//            "Asia/Yangon" => "UTC+6.5",
//            "Asia/Yekaterinburg" => "UTC+5",
//            "Asia/Yerevan" => "UTC+4",
//            "Atlantic/Azores" => "UTC-1",
//            "Atlantic/Bermuda" => "UTC-4",
//            "Atlantic/Canary" => "UTC+0",
//            "Atlantic/Cape_Verde" => "UTC-1",
//            "Atlantic/Faroe" => "UTC+0",
//            "Atlantic/Madeira" => "UTC+0",
//            "Atlantic/Reykjavik" => "UTC+0",
//            "Atlantic/South_Georgia" => "UTC-2",
//            "Atlantic/St_Helena" => "UTC+0",
//            "Atlantic/Stanley" => "UTC-3",
//            "Australia/Adelaide" => "UTC+10.5",
//            "Australia/Brisbane" => "UTC+10",
//            "Australia/Broken_Hill" => "UTC+10.5",
//            "Australia/Currie" => "UTC+11",
//            "Australia/Darwin" => "UTC+9.5",
//            "Australia/Eucla" => "UTC+8.75",
//            "Australia/Hobart" => "UTC+11",
//            "Australia/Lindeman" => "UTC+10",
//            "Australia/Lord_Howe" => "UTC+11",
//            "Australia/Melbourne" => "UTC+11",
//            "Australia/Perth" => "UTC+8",
//            "Australia/Sydney" => "UTC+11",
//            "Canada/Atlantic" => "UTC-4",
//            "Canada/Central" => "UTC-6",
//            "Canada/Eastern" => "UTC-5",
//            "Canada/Mountain" => "UTC-7",
//            "Canada/Newfoundland" => "UTC-3.5",
//            "Canada/Pacific" => "UTC-8",
//            "Europe/Amsterdam" => "UTC+1",
//            "Europe/Andorra" => "UTC+1",
//            "Europe/Astrakhan" => "UTC+4",
//            "Europe/Athens" => "UTC+2",
//            "Europe/Belgrade" => "UTC+1",
//            "Europe/Berlin" => "UTC+1",
//            "Europe/Bratislava" => "UTC+1",
//            "Europe/Brussels" => "UTC+1",
//            "Europe/Bucharest" => "UTC+2",
//            "Europe/Budapest" => "UTC+1",
//            "Europe/Busingen" => "UTC+1",
//            "Europe/Chisinau" => "UTC+2",
//            "Europe/Copenhagen" => "UTC+1",
//            "Europe/Dublin" => "UTC+0",
//            "Europe/Gibraltar" => "UTC+1",
//            "Europe/Guernsey" => "UTC+0",
//            "Europe/Helsinki" => "UTC+2",
//            "Europe/Isle_of_Man" => "UTC+0",
//            "Europe/Istanbul" => "UTC+3",
//            "Europe/Jersey" => "UTC+0",
//            "Europe/Kaliningrad" => "UTC+2",
//            "Europe/Kiev" => "UTC+2",
//            "Europe/Kirov" => "UTC+3",
//            "Europe/Lisbon" => "UTC+0",
//            "Europe/Ljubljana" => "UTC+1",
//            "Europe/London" => "UTC+0",
//            "Europe/Luxembourg" => "UTC+1",
//            "Europe/Madrid" => "UTC+1",
//            "Europe/Malta" => "UTC+1",
//            "Europe/Mariehamn" => "UTC+2",
//            "Europe/Minsk" => "UTC+3",
//            "Europe/Monaco" => "UTC+1",
//            "Europe/Moscow" => "UTC+3",
//            "Europe/Oslo" => "UTC+1",
//            "Europe/Paris" => "UTC+1",
//            "Europe/Podgorica" => "UTC+1",
//            "Europe/Prague" => "UTC+1",
//            "Europe/Riga" => "UTC+2",
//            "Europe/Rome" => "UTC+1",
//            "Europe/Samara" => "UTC+4",
//            "Europe/San_Marino" => "UTC+1",
//            "Europe/Sarajevo" => "UTC+1",
//            "Europe/Saratov" => "UTC+4",
//            "Europe/Simferopol" => "UTC+3",
//            "Europe/Skopje" => "UTC+1",
//            "Europe/Sofia" => "UTC+2",
//            "Europe/Stockholm" => "UTC+1",
//            "Europe/Tallinn" => "UTC+2",
//            "Europe/Tirane" => "UTC+1",
//            "Europe/Ulyanovsk" => "UTC+4",
//            "Europe/Uzhgorod" => "UTC+2",
//            "Europe/Vaduz" => "UTC+1",
//            "Europe/Vatican" => "UTC+1",
//            "Europe/Vienna" => "UTC+1",
//            "Europe/Vilnius" => "UTC+2",
//            "Europe/Volgograd" => "UTC+4",
//            "Europe/Warsaw" => "UTC+1",
//            "Europe/Zagreb" => "UTC+1",
//            "Europe/Zaporozhye" => "UTC+2",
//            "Europe/Zurich" => "UTC+1",
//            "Indian/Antananarivo" => "UTC+3",
//            "Indian/Chagos" => "UTC+6",
//            "Indian/Christmas" => "UTC+7",
//            "Indian/Cocos" => "UTC+6.5",
//            "Indian/Comoro" => "UTC+3",
//            "Indian/Kerguelen" => "UTC+5",
//            "Indian/Mahe" => "UTC+4",
//            "Indian/Maldives" => "UTC+5",
//            "Indian/Mauritius" => "UTC+4",
//            "Indian/Mayotte" => "UTC+3",
//            "Indian/Reunion" => "UTC+4",
//            "Pacific/Apia" => "UTC+13",
//            "Pacific/Auckland" => "UTC+13",
//            "Pacific/Bougainville" => "UTC+11",
//            "Pacific/Chatham" => "UTC+13.75",
//            "Pacific/Chuuk" => "UTC+10",
//            "Pacific/Easter" => "UTC-6",
//            "Pacific/Efate" => "UTC+11",
//            "Pacific/Enderbury" => "UTC+13",
//            "Pacific/Fakaofo" => "UTC+13",
//            "Pacific/Fiji" => "UTC+12",
//            "Pacific/Funafuti" => "UTC+12",
//            "Pacific/Galapagos" => "UTC-6",
//            "Pacific/Gambier" => "UTC-9",
//            "Pacific/Guadalcanal" => "UTC+11",
//            "Pacific/Guam" => "UTC+10",
//            "Pacific/Honolulu" => "UTC-10",
//            "Pacific/Kiritimati" => "UTC+14",
//            "Pacific/Kosrae" => "UTC+11",
//            "Pacific/Kwajalein" => "UTC+12",
//            "Pacific/Majuro" => "UTC+12",
//            "Pacific/Marquesas" => "UTC-9.5",
//            "Pacific/Midway" => "UTC-11",
//            "Pacific/Nauru" => "UTC+12",
//            "Pacific/Niue" => "UTC-11",
//            "Pacific/Norfolk" => "UTC+11",
//            "Pacific/Noumea" => "UTC+11",
//            "Pacific/Pago_Pago" => "UTC-11",
//            "Pacific/Palau" => "UTC+9",
//            "Pacific/Pitcairn" => "UTC-8",
//            "Pacific/Pohnpei" => "UTC+11",
//            "Pacific/Port_Moresby" => "UTC+10",
//            "Pacific/Rarotonga" => "UTC-10",
//            "Pacific/Saipan" => "UTC+10",
//            "Pacific/Tahiti" => "UTC-10",
//            "Pacific/Tarawa" => "UTC+12",
//            "Pacific/Tongatapu" => "UTC+13",
//            "Pacific/Wake" => "UTC+12",
//            "Pacific/Wallis" => "UTC+12",
//        ];
//
////        Это полный список временных зон и их UTC-смещений. Вы можете использовать этот список для добавления записей в базу данных через Laravel.
//
//
//
//
//
//
////        dd($timezones);
//        foreach ($timezones as  $key => $tz) {
//            TimeZone::create([
//               'zone' => $key,
//                'utc' => $tz
//            ]);
//        }

        return redirect()->back();

    }



    public function set_timzone($utc){

        $get = TimeZone::where('utc', $utc)->first();

        if ($get == null){
            $zone = 'Europe/Moscow';
        }else{
            $zone  = $get->zone;
        }
        Cookie::queue('timezone', $zone);

        \Illuminate\Support\Facades\Session::put('timezone', $zone);
        session(['timezone' => $zone]);
        $message = session()->get('timezone');


        return redirect()->back();
    }
}
