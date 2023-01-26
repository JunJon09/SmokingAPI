<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Convenience_store;
use App\Models\Comment;

class GoogleAPIController extends Controller
{
    public function index($lat, $lng, $zoom){
        $r = 0;
        if ($zoom <= 12){
            $r = 10000;
        }elseif ($zoom <= 13){
            $r = 5000;
        }elseif ($zoom <= 14){
            $r = 3000;
        }elseif ($zoom <= 15){
            $r = 1250;
        }elseif ($zoom <= 16){
            $r = 600;
        }elseif ($zoom <= 17){
            $r = 400;
        }elseif ($zoom <= 18){
            $r = 200;
        }elseif ($zoom <= 19){
            $r = 100;
        }elseif ($zoom <= 20){
            $r = 50;
        }else{
            $r = 25;
        }
        require('../secret.php');
        $requestURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lng ."&radius=" . $r . "&types=convenience_store&sensor=false&language=ja&key=" .$val;
        $method = "GET";
        $client = new Client();
        $response = $client->request($method, $requestURL);
        
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $items= $posts["results"];
        $jsonCode = array();
        #ほしい情報は緯度,経度,名前, そのコンビニの状態
        #-1だとまだ入力されてない
        #0だと無い、1だと有る
        foreach($items as $item){
            $lat = $item["geometry"]["location"]["lat"];
            $lng = $item["geometry"]["location"]["lng"];
            $cond = ['lat' =>$lat, 'lng' => $lng];
            $value = Convenience_store::where($cond)->first();
            $comments = array();
            #null判定いる
            if (is_null($value)){
                $jsonCode[] = array('lat'=>$lat, 'lng'=>$lng, 'name'=>$item["name"], 'value'=>-1, 'comment'=>$comments);
            }else{
                $DB_Comments = Comment::where('convenienceID', '=', $value->id)->get();
                foreach($DB_Comments as $comment){
                    $comments[] = array('com'=>$comment->comment);
                }
                $jsonCode[] = array('lat'=>$lat, 'lng'=>$lng, 'name'=>$item["name"], 'value'=>$value->check, 'comment'=>$comments);
            }
        }
        $json = json_encode($jsonCode, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        return response()->json($json);
    }    
    
}
