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



    public function details(Request $request){

        $url = "https://test.visengine2.altravia.com/richiesta/".$request->visure;

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('TOKEN')
        ])->get($url);

        $jsonres = $res->json();

        if ($jsonres['success'] == true){
            return response()->json([
                'data'=>$jsonres
            ],200);
        }

        return response()->json([
            'error'=>'Error',
            'data'=>$jsonres
        ],500);
    }


    public function document(Request $request){

        $url = "https://test.visengine2.altravia.com/documento/".$request->id;

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('TOKEN')
        ])->get($url);

        $jsonres = $res->json();

        if ($jsonres['success'] == true){
            return response()->json([
                'data'=>$jsonres
            ],200);
        }

        return response()->json([
            'error'=>'Error',
            'data'=>$jsonres
        ],500);
    }




    public function buy(Request $request){

        $params = [
            "state"=>0,
            // "test"=>true,
            "hash_visura"=>'a87ff679a2f3e71d9181a67b7542122c',
            "json_visura"=>[
                "$0"=>"NRea","$1"=>"Cciaa"
            ],
            "callback_data"=>["method"=>"JSON","field"=>"string","url"=>"https://www.mysite.it/callback.php","data"=>[]],
            "email_target"=>'ismailimegan@gmail.com',
        ];

        $url = "https://test.visengine2.altravia.com/richiesta";

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('TOKEN')
        ])->post($url, $params);

        $jsonres = $res->json();

        if ($jsonres['success'] == true){
            return response()->json([
                'data'=>$jsonres
            ],200);
        }

        return response()->json([
            'error'=>'Error',
            'data'=>$jsonres
        ],500);

    }
}
