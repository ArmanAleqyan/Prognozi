<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\CommandLiga;
use App\Models\Liga;
class CommandController extends Controller
{


    public function get_commands(Request $request){

        if (isset($request->country_id)){
            $get_liga = Liga::where('country_id' , $request->country_id)->first();


            $get_cpmmand_liga = CommandLiga::where('liga_id', $get_liga->id)->get('command_id')->pluck('command_id')->toarray();


            $get_command = Command::wherein('id',$get_cpmmand_liga )->get();
        }elseif(isset($request->liga_id)){
            $get_cpmmand_liga = CommandLiga::where('liga_id', $request->liga_id)->get('command_id')->pluck('command_id')->toarray();
            $get_command = Command::wherein('id',$get_cpmmand_liga )->get();
        }



        return response()->json([
           'status' => true,
           'data' => $get_command
        ],200);



    }

    public function all_commands(){
        $get = Command::orderby('name_one')->get();


        return view('admin.Commands.all', compact('get'));
    }

    public function create_command(){
        $get = Liga::orderby('id', 'desc')->get();

        return view('admin.Commands.create', compact('get'));
    }

    public function create_command_post(Request $request){
        $one_photo =  $request->logo;
        $fileName_one_photo = time().'.'.$one_photo->getClientOriginalExtension();
        $filePath = $one_photo->move('uploads', $fileName_one_photo);
       $create = Command::create([
           'name_one' => $request->name_one,
           'name_two' => $request->name_two,
           'logo' => $fileName_one_photo,
        ]);
       if (isset($request->liga_id)){
           foreach ($request->liga_id as $item) {
                    CommandLiga::create([
                       'liga_id'  => $item,
                       'command_id'  => $create->id,
                    ]);
           }
       }

        return redirect()->back()->with('created','created');
    }


    public function update_command(Request $request){
        $get = Command::where('id', $request->command_id)->first();

        if ( $get == null){
            return  redirect()->back();
        }

        if (isset($request->logo)){
            $one_photo =  $request->logo;
            $fileName_one_photo = time().'.'.$one_photo->getClientOriginalExtension();
            $filePath = $one_photo->move('uploads', $fileName_one_photo);
        }else{
            $fileName_one_photo = $get->logo;
        }


        $get->update([
            'name_one' => $request->name_one,
            'name_two' => $request->name_two,
            'logo' => $fileName_one_photo,
        ]);


        if (isset($request->liga_id)){
            foreach ($request->liga_id as $item) {
                CommandLiga::create([
                    'liga_id'  => $item,
                    'command_id'  => $request->command_id,
                ]);
            }
        }

        return redirect()->back()->with('created','created');

    }

    public function delete_command($id){
        Command::where('id', $id)->delete();
        return redirect()->back()->with('deleted','deleted');
    }


    public function single_page_command($id){
        $get_have = CommandLiga::where('command_id', $id)->get('liga_id')->pluck('liga_id')->toarray();


        $get = Liga::orderby('id','desc')->where('id', '!=', $get_have)->get();


        $get_command =  Command::where('id', $id)->first();


        if ($get_command == null){
        return redirect()->back();
        }


        return view('admin.Commands.single', compact('get', 'get_command'));

    }

    public function delete_liga_for_command($id){
        CommandLiga::where('id', $id)->delete();



        return redirect()->back()->with('created','created');

    }
}
