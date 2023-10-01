<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Liga;
use App\Models\County;
class LigaController extends Controller
{

    public function all_liga(){
        $get = Liga::orderby('id', 'desc')->get();

        return view('admin.liga.all', compact('get'));
    }

    public function create_liga(){
        $get = County::orderby('id','desc')->get();


        return view('admin.liga.create', compact('get'));
    }

    public function create_liga_post(Request $request){
        Liga::create([
           'name' => $request->name,
           'country_id' => $request->country_id,
           'url' => $request->url
        ]);



        return redirect()->back()->with('created','created');
    }

    public function delete_liga($id){
        Liga::where('id', $id)->delete();


        return redirect()->back()->with('deleted','deleted');
    }

    public function single_page_liga($id){
        $get = County::orderby('id', 'desc')->get();
        $liga = Liga::where('id', $id)->first();

        return view('admin.liga.single', compact('get', 'liga'));
    }

    public function update_liga(Request $request){

        Liga::where('id', $request->liga_id)->update([
           'country_id' => $request->country_id,
           'name' => $request->name,
           'url' => $request->url,
        ]);

        return redirect()->back()->with('created','created');
    }
}
