<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdInsights;
use App\Facebook\FacebookRequest;

class AdInsightsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ad = AdInsights::where('object_id' ,'=', $id)->first();
        if(isset($ad)) {
            return $ad->json;
        } else {
            $ad = new AdInsights;
            $ad->object_id = $id;
            $facebook = new FacebookRequest;
            try {
                $json = $facebook->get()->ad($ad->object_id)->insights();
                $weekly = $facebook->get()->ad($ad->object_id)->insights(['date_preset' => 'last_7_days']);
            } catch (Exception $e) {
                return "Error retrieving ad insights from Facebook";
            }
            $ad->json = $json;
            $ad->weekly = $weekly;
            $ad->save();
        }

        return $ad->json;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function weekly($id)
    {
        $ad = AdInsights::where('object_id' ,'=', $id)->first();
        if(isset($ad)) {
            return $ad->weekly;
        } else {
            $ad = new AdInsights;
            $ad->object_id = $id;
            $facebook = new FacebookRequest;
            try {
                $json = $facebook->get()->ad($ad->object_id)->insights();
                $weekly = $facebook->get()->ad($ad->object_id)->insights(['date_preset' => 'last_7_days']);
            } catch (Exception $e) {
                return "Error retrieving ad insights from Facebook";
            }
            $ad->json = $json;
            $ad->weekly = $weekly;
            $ad->save();
        }

        return $ad->weekly;
    }

}
