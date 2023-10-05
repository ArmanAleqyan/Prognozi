<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prognoz;
use App\Models\PrognozAttr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\County;

class PrognozController extends Controller
{


    public function show_analize($id){
        $get = Prognoz::where('id', $id)->first();


        if ($get->show_analize == 0){
            $get->update([
               'show_analize' => 1
            ]);
        }else{
            $get->update([
                'show_analize' => 0
            ]);
        }


        return redirect()->back();

    }

    public function status_attr($id){

        $get =PrognozAttr::where('id', $id)->first();


        if ($get->status == 0){
            PrognozAttr::where('id', $id)->update([
                'status' => 1
            ]);

        }else{
            PrognozAttr::where('id', $id)->update([
                'status' => 0
            ]);

        }



        return redirect()->back();
    }

    public function delete_attr($id){
        if (auth()->user()->id != 1){
            return redirect()->back();
        }
       $get = PrognozAttr::where('id', $id)->first();


       $redirec_id = $get->prognoz_id;

       $get->delete();

       return redirect()->route('single_page_prognoz', $redirec_id);
    }

    public function update_attr(Request $request){
        $get = PrognozAttr::where('id', $request->attr_id)->first();




        if (isset($request->old_data)){
            foreach ($request->old_data as $key => $old_datum) {
                if ($old_datum['start_time'] != null && $old_datum['price'] != null){
                    PrognozAttr::where('id', $key)->update([
                        'kf' => $old_datum['price'],
                        'title' => $old_datum['start_time'],
                    ]) ;
                }else{
                    PrognozAttr::where('id', $key)->delete();
                }
            }
        }


        if ($get == null){
            return redirect()->back();
        }



        if (isset($request->data)){
            foreach ($request->data as  $datum) {

                PrognozAttr::create([
                    'prognoz_id' =>$get->prognoz_id,
                    'kf' => $datum['price'],
                    'group_id' => $request->group_id,
                    'title' => $datum['start_time'],
                ]);
            }
        }

        $get->update([
            'kf' => $request->kf,
            'attr' => $request->attr,
            'title' => $request->title,
            'super' => $request->super,
            'status' => $request->status,
            'sobitie' => $request->sobitie,
            'risk' => $request->risk,

        ]);

      return redirect()->back()->with('created','created');
    }

    public  function single_page_prognoz_attr($id){
        $get = PrognozAttr::where('id', $id)->first();


        if ($get == null){
            return redirect()->back();
        }



        return view('admin.prognoz.attr', compact('get'));
    }

    public function update_prognoz(Request $request){



        $get = Prognoz::where('id', $request->prognoz_id)->first();
        $get_url = Prognoz::where('url', $request->url)->where('id' ,'!=', $request->prognoz_id)->first();
        if ($get != null && $request->url != null  && $get_url != null){
            return response()->json([
                'status' => false,
                'message' => 'Таккая  Ссылка  уже  сушествует'
            ],422);
        }

        $tiem = time();
        if (isset($request->team_one_logo)){

            $one_photo =  $request->team_one_logo;
            $fileName_one_photo = $tiem++.'.'.$one_photo->getClientOriginalExtension();
            $filePath = $one_photo->move('uploads', $fileName_one_photo);
        }else{
            $fileName_one_photo = $get->team_one_logo;
        }

        if (isset($request->team_two_logo)){
            $two_photo =  $request->team_two_logo;
            $fileName_two = $tiem+.10.'.'.$two_photo->getClientOriginalExtension();
            $filePath_two = $two_photo->move('uploads', $fileName_two);
        }else{
            $fileName_two = $get->team_two_logo;
        }



        $get_liga = \App\Models\Liga::where('id', $request->liga_id)->first();
        $get->update([
            'country_id' => $request->country_id,
            'star' => $request->star,
            'title' => $request->name,
            'sport_type' => $request->sport_type,
            'country' => $request->country,
            'liga' => $get_liga->name,
            'liga_id' => $get_liga->id,
            'url' => $request->url,
            'team_one' => $request->team_one,
            'team_one_two' => $request->team_one_two,
            'team_two' => $request->team_two,
            'team_two_two' => $request->team_two_two,
            'team_one_logo' =>$fileName_one_photo,
            'team_two_logo' =>$fileName_two,
            'start_date' => Carbon::parse($request->date)->format('Y-m-d') ,
            'start_time' => Carbon::parse($request->time)->format('H:i'),
            'start_carbon' => Carbon::parse("$request->date $request->time"),

        ]);


            $get_attr_analize = PrognozAttr::where('prognoz_id', $request->prognoz_id)->where('group_id', 9999999999)->first();

            if ($get_attr_analize != null){
                PrognozAttr::where('prognoz_id', $request->prognoz_id)->where('group_id', 9999999999)->update([
                    'attr' => $request->analize
                ]);
            }else{
                PrognozAttr::create([
                    'prognoz_id' => $request->prognoz_id,
                    'attr' => $request->analize,
                    'group_id' => 9999999999
                ]);
            }





        $last_attr =  PrognozAttr::where('prognoz_id', $request->prognoz_id)->where('group_id', '!=', 9999999999)->orderby('id', 'desc')->first();

        if ($last_attr != null){
            $is = $last_attr->group_id +1;
        }else{
            $i = 100;
        }


        if ( isset($request->datas) ){

            $i = 100;
            foreach ($request->datas as $rty){
                $decode = json_decode($rty);
                if (isset($decode->start_time)  && isset($decode->description)){
                    if ($decode->id == null){
                        $id = $i++;
                    }else{
                        $id = $decode->id;
                    }

                    $get_prognoz_attr = PrognozAttr::where('prognoz_id', $request->prognoz_id)->where('group_id', $id)->first();
                    if ($get_prognoz_attr == null){
                        $text =  json_decode($decode->description);
                    }else{
                        $text = null;
                    }
                    PrognozAttr::create([
                        'prognoz_id' => $request->prognoz_id,
                        'title' => $decode->start_time,
                        'kf' => $decode->price,
                        'attr' => $text,
                        'group_id' =>$id,
                        'super' =>$decode->super,
                        'sobitie' => $decode->sobitie,
                        'risk' => $decode->risk,
                    ]);
                }

            }
        }


        return response()->json([
           'status' => true,
            'message' => 'created'
        ]);


    }

    public function single_page_prognoz($id){
        $get = Prognoz::where('id', $id)->first();
        if ($get == null){
            return redirect()->back();
        }
        $country = County::orderby('id', 'desc')->get();


        return view('admin.prognoz.single', compact('get','country'));
    }

    public function delete_prognoz($id){
        if (auth()->user()->id != 1){
            return redirect()->back();
        }
        Prognoz::where('id', $id)->delete();

        return redirect()->back();
    }
    public function new_prognoz(){
        $get = Prognoz::
                wherein('status', ['Начался','Начало'])


            ->orderby('start_carbon', 'desc')
            ->get();

        return view('admin.prognoz.index', compact('get'));
    }
    public function old_prognoz(){
        $get = Prognoz::
                where('status', '<=', 'Завершен')
            ->orderby('start_carbon', 'desc')
            ->get();

        return view('admin.prognoz.index', compact('get'));
    }

    public function create_prognoz(){
        $country = County::orderby('id', 'desc')->get();
        return view('admin.prognoz.create', compact('country'));
    }

    public function create_prognoz_post(Request $request){




        try{
                $get_prognoz = Prognoz::where('url', $request->url)->first();
                if ($get_prognoz != null && $request->url != null){
                    return response()->json([
                       'status' => false,
                       'message' => 'Таккая  Ссылка  уже  сушествует'
                    ],422);
                }
//                if ($request->team_one_logo == null && $request->team_two_logo == null){
//                    return response()->json([
//                        'status' => false,
//                        'message' => 'Лого  команд обезательное поле'
//                    ],422);
//                }
//                try{
//                    $tiem = time();
//                    $one_photo =  $request->team_one_logo;
//                    $fileName = $tiem++.'.'.$one_photo->getClientOriginalExtension();
//                    $filePath = $one_photo->move('uploads', $fileName);
//
//
//                }catch (\Exception $e){
//                    return response()->json([
//                        'status' => false,
//                        'message' => 'Лого  команд обезательное поле'
//                    ],422);
//                }

//                try{
//                    $two_photo =  $request->team_two_logo;
//                    $fileName_two = $tiem+.10.'.'.$two_photo->getClientOriginalExtension();
//                    $filePath_two = $two_photo->move('uploads', $fileName_two);
//
//                }catch (\Exception $e){
//                    return response()->json([
//                        'status' => false,
//                        'message' => 'Лого  команд обезательное поле'
//                    ],422);
//                }



                $get_liga = \App\Models\Liga::where('id', $request->liga_id)->first();

                $get_command_home = \App\Models\Command::where('id', $request->command_home)->first();
                $get_command_guest = \App\Models\Command::where('id', $request->command_guest)->first();
                if ($get_liga->url != null){
                    $url = str_replace(' ', '-',strtolower($get_command_home->name_two)) .'-'. str_replace(' ', '-',strtolower($get_command_guest->name_two)).'-'.$get_liga->url.'-'.Carbon::parse($request->date)->format('Y-m-d');
                }else{
                    $url = str_replace(' ', '-',strtolower($get_command_home->name_two)) .'-'. str_replace(' ', '-',strtolower($get_command_guest->name_two)).'-'.Carbon::parse($request->date)->format('Y-m-d');
                }
            $url = str_replace('-|-', '-', $url);

                
                   
                    $create = Prognoz::create([
                    'country_id' => $request->country_id,
                    'star' => $request->star,
                   'title' => "Тур ".$request->name,
                   'sport_type' => $request->sport_type,
                   'country' => $request->country,
                   'liga' => $get_liga->name,
                   'liga_id' => $get_liga->id,
                   'url' =>  $url,
                   'team_one' => $get_command_home->name_one,
                   'team_one_two' => $get_command_home->name_two,
                   'team_two' => $get_command_guest->name_one,
                   'team_two_two' => $get_command_guest->name_two,
                   'team_one_logo' =>$get_command_home->logo,
                   'team_two_logo' =>$get_command_guest->logo,
                   'command_home_id' =>$request->command_home,
                   'command_guest_id' =>$request->command_guest,
                   'start_date' => Carbon::parse($request->date)->format('Y-m-d') ,
                   'start_time' => Carbon::parse($request->time)->format('H:i'),
                    'start_carbon' => Carbon::parse("$request->date $request->time")
                ]);

                    if (isset($request->analize)){
                        PrognozAttr::create([
                            'prognoz_id' => $create->id,
                            'attr' => $request->analize,
                            'group_id' => 9999999999
                        ]);
                    }

                if ( isset($request->datas) ){

                    $i = 100;
                    foreach ($request->datas as $rty){
                       $decode = json_decode($rty);
                        if (isset($decode->start_time)  && isset($decode->description)){
                            if ($decode->id == null){
                                $id = $i++;
                            }else{
                                $id = $decode->id;
                            }

                            $get_prognoz_attr = PrognozAttr::where('prognoz_id', $create->id)->where('group_id', $id)->first();
                            if ($get_prognoz_attr == null){
                                $text =  json_decode($decode->description);
                            }else{
                                $text = null;
                            }
                                PrognozAttr::create([
                                    'prognoz_id' => $create->id,
                                    'title' => $decode->start_time,
                                    'kf' => $decode->price,
                                    'attr' => $text,
                                    'group_id' =>$id,
                                    'super' =>$decode->super??0,
                                    'sobitie' => $decode->sobitie,
                                    'risk' => $decode->risk,
                                ]);
                        }

                    }
                }

            return response()->json([
                   'status' => true,
                   'message' => 'created'
                ],200);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' =>  'Что то пошло  не  так  свяжитесь с разработчиком'
            ],422);
        }
    }
}
