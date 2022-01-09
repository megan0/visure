<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

        $hash_visura=$request->visure;

        $validate_condit=$this->validate_visure_data($hash_visura);

        if($validate_condit!='Error'){


            foreach($validate_condit as $key=>$cond){
                if($cond['null']=='0' || $cond['null']==false){
                    if($request->data[$key]==null){
                        return response()->json([
                            'error'=>'please fill all the required fields'
                        ],404);
                    }
                }
            }


            // return $data;

            $params = [
                "state"=>0,
                // "test"=>true,
                "hash_visura"=>$hash_visura,
                "json_visura"=>$request->data,
                "callback_data"=>["method"=>"JSON","field"=>"string","url"=>"https://www.mysite.it/callback.php","data"=>[]],
                "email_target"=>$request->email,
            ];

            $url = "https://test.visengine2.altravia.com/richiesta";

            $res = Http::withHeaders([
                'Authorization' => 'Bearer '.env('TOKEN')
            ])->post($url, $params);

            $jsonres = $res->json();

            if ($jsonres['success'] == true){

                $order = new Order;

                $order->order_id=$jsonres['data']['_id'];
                $order->email=$jsonres['data']['owner'];

                $order->save();


                return response()->json([
                    'data'=>$jsonres
                ],200);
            }

            return response()->json([
                'error'=>'Error',
                'data'=>$jsonres
            ],500);


        }
        return response()->json([
            'error'=>'Error'
        ],500);


    }

    public function validate_visure_data($visure){

        $url = "https://test.visengine2.altravia.com/visure/".$visure;

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('TOKEN')
        ])->get($url);
        $jsonres = $res->json();
        if ($jsonres['success'] == true){

            return $jsonres['data']['json_struttura']['campi'];
        }

        return 'Error';
    }
}
