<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminLoginController;
use \App\Http\Controllers\Admin\PrognozController;
use \App\Http\Controllers\Admin\CountryController;
use \App\Http\Controllers\Admin\LigaController;
use \App\Http\Controllers\Admin\CommandController;
use \App\Http\Controllers\ParseTimzone;
use \App\Http\Controllers\TranslateController;
use \App\Http\Controllers\IndexingController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});
//$timezone = \Illuminate\Support\Facades\Cookie::get('timezone');
$timezone = session()->get('timezone');
Config::set('app.timezone',$timezone??'Europe/Moscow');



$localiseGroup = [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect',]
];

Route::group($localiseGroup, function() {
    Route::get("/", [HomeController::class, 'home'])->name('home');
    Route::get('/filtered_data', [HomeController::class, 'filtered_data'])->name('filtered_data');
    Route::get('generate', [HomeController::class, 'generate'])->name('generate');
    Route::get('/completed', [HomeController::class, 'completed'])->name('completed');
    Route::get('bet/{url?}/{id?}', [HomeController::class, 'bet'])->name('bet');

});
Route::get('set_locale/{lang}', [ParseTimzone::class, 'set_locale'])->name('set_locale');
//Route::get('translate_prognoz', [TranslateController::class, 'translate_prognoz'])->name('translate_prognoz');
//Route::get('translate_atribute', [TranslateController::class, 'translate_atribute'])->name('translate_atribute');
//Route::get('translate_atribute_test', [TranslateController::class, 'translate_atribute_test'])->name('translate_atribute_test');
//Route::get('translate_atribute_testv2', [TranslateController::class, 'translate_atribute_testv2'])->name('translate_atribute_testv2');
//Route::get('translate_country', [TranslateController::class, 'translate_country'])->name('translate_country');


Route::get('indexing', [IndexingController::class, 'indexing'])->name('indexing');



Route::get('set_timzone/{utc}', [ParseTimzone::class, 'set_timzone'])->name('set_timzone');







Route::prefix('admin')->group(function () {

    Route::middleware(['NoAuthUser'])->group(function () {

        Route::get('/login',[AdminLoginController::class,'login'])->name('login');
        Route::post('/logined',[AdminLoginController::class,'logined'])->name('logined');
    });

    Route::middleware(['AuthUser'])->group(function () {

        Route::get('all_commands', [CommandController::class, 'all_commands'])->name('all_commands');
        Route::get('create_command', [CommandController::class, 'create_command'])->name('create_command');
        Route::get('delete_command/command_id={id}', [CommandController::class, 'delete_command'])->name('delete_command');
        Route::get('single_page_command/command_id={id}', [CommandController::class, 'single_page_command'])->name('single_page_command');
        Route::get('delete_liga_for_command/liga_id={id}', [CommandController::class, 'delete_liga_for_command'])->name('delete_liga_for_command');
        Route::post('create_command_post', [CommandController::class, 'create_command_post'])->name('create_command_post');
        Route::post('update_command', [CommandController::class, 'update_command'])->name('update_command');
        Route::post('get_commands', [CommandController::class, 'get_commands'])->name('get_commands');

        
        Route::get('all_liga', [LigaController::class, 'all_liga'])->name('all_liga');
        Route::get('create_liga', [LigaController::class, 'create_liga'])->name('create_liga');
        Route::get('delete_liga/liga_id={id}', [LigaController::class, 'delete_liga'])->name('delete_liga');
        Route::get('single_page_liga/liga_id={id}', [LigaController::class, 'single_page_liga'])->name('single_page_liga');
        Route::post('create_liga_post', [LigaController::class, 'create_liga_post'])->name('create_liga_post');
        Route::post('update_liga', [LigaController::class, 'update_liga'])->name('update_liga');

    Route::get('HomePage', [AdminLoginController::class,'HomePage'])->name('HomePage');
    Route::get('logoutAdmin', [AdminLoginController::class,'logoutAdmin'])->name('logoutAdmin');


    Route::get('settingView', [AdminLoginController::class, 'settingView'])->name('settingView');
    Route::post('updatePassword', [AdminLoginController::class, 'updatePassword'])->name('updatePassword');


    Route::get('new_prognoz', [PrognozController::class, 'new_prognoz'])->name('new_prognoz');
    Route::get('show_analize/progniz_id={id}', [PrognozController::class, 'show_analize'])->name('show_analize');
    Route::get('status_attr/attr_id={id}', [PrognozController::class, 'status_attr'])->name('status_attr');
    Route::get('single_page_prognoz/prognoz_id={id}', [PrognozController::class, 'single_page_prognoz'])->name('single_page_prognoz');
    Route::get('single_page_prognoz_attr/attr={id}', [PrognozController::class, 'single_page_prognoz_attr'])->name('single_page_prognoz_attr');
    Route::get('old_prognoz', [PrognozController::class, 'old_prognoz'])->name('old_prognoz');
    Route::get('create_prognoz', [PrognozController::class, 'create_prognoz'])->name('create_prognoz');
    Route::post('create_prognoz_post', [PrognozController::class, 'create_prognoz_post'])->name('create_prognoz_post');
    Route::post('update_prognoz', [PrognozController::class, 'update_prognoz'])->name('update_prognoz');
    Route::post('update_attr', [PrognozController::class, 'update_attr'])->name('update_attr');
    Route::get('delete_prognoz/{id}', [PrognozController::class, 'delete_prognoz'])->name('delete_prognoz');
    Route::get('delete_attr/{id}', [PrognozController::class, 'delete_attr'])->name('delete_attr');

    Route::get('all_country', [CountryController::class, 'all_country'])->name('all_country');
    Route::get('create_country_page', [CountryController::class, 'create_country_page'])->name('create_country_page');
    Route::post('create_country', [CountryController::class, 'create_country'])->name('create_country');
    Route::post('update_country', [CountryController::class, 'update_country'])->name('update_country');
    Route::get('single_page_country/country_id={id}', [CountryController::class, 'single_page_country'])->name('single_page_country');
    Route::get('delete_country/country_id={id}', [CountryController::class, 'delete_country'])->name('delete_country');
    });
    Route::get('parse', [CountryController::class, 'parse'])->name('parse');
    Route::get('fetchWebsiteHTML', [CountryController::class, 'fetchWebsiteHTML'])->name('fetchWebsiteHTML');
});
