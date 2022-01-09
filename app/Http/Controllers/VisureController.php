<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VisureController extends Controller
{


    public function index(){

        $url = "https://test.visengine2.altravia.com/visure";

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('TOKEN')
        ])->get($url);
        $jsonres = $res->json();
        if ($jsonres['success'] == true){
            return response()->json([
                'data'=>$jsonres['data']
            ],200);
        }

        return response()->json([
            'error'=>'Error',
            'data'=>$jsonres
        ],500);

    }

    public function select_visure(Request $request){
        $hash_visure=$request->visure;

        $url = "https://test.visengine2.altravia.com/visure/".$hash_visure;

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('TOKEN')
        ])->get($url);
        $jsonres = $res->json();
        if ($jsonres['success'] == true){
            return response()->json([
                'data'=>$jsonres['data']
            ],200);
        }

        return response()->json([
            'error'=>'Error',
            'data'=>$jsonres
        ],500);

    }

    public function buy(){

    }


    public function details(){

    }
}
