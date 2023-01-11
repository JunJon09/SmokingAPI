<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Convenience_store;
use App\Models\Comment;

class GoogleAPIController extends Controller
{
    public function index($ido, $keido){
        require('../secret.php');
        $requestURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=36.572672,140.643013&radius=5000&types=convenience_store&sensor=false&language=ja&key=" .$val;
        $method = "GET";
        $client = new Client();
        $response = $client->request($method, $requestURL);
        
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $items= $posts["results"];
        $jsonCode = [];
        #ほしい情報は緯度,経度,名前, そのコンビニの状態
        
        foreach($items as $item){
            $tmp = [];
            array_push($tmp, $item["name"]);
            $lat = $item["geometry"]["location"]["lat"];
            $lng = $item["geometry"]["location"]["lng"];
            array_push($tmp, $lat);
            array_push($tmp, $lng);
            $cond = ['lat' =>$lat, 'lng' => $lng];
            $value = Convenience_store::where($cond)->first();
            $comments = [];
            #null判定いる
            if (is_null($value)){
                $value = -1;
            }else{
                $DB_Comments = Comment::where('convenienceID', '=', $value->id)->get();
                foreach($DB_Comments as $comment){
                    array_push($comments, $comment->comment);
                }
                $value = $value->check;
            }
            array_push($tmp, $value);
            array_push($tmp, $comments);
            array_push($jsonCode, $tmp);
        }
        $json = json_encode($jsonCode, JSON_UNESCAPED_UNICODE);
        return response()->json($json);
    }    
    
}
