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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ads = AdInsights::all();
        return view('insights.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('insights.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $id = $request->object_id;
        $ad = AdInsights::find($id);
        if(isset($ad)) {
            return $ad->json;
        } else {
            $ad = new AdInsights;
            $ad->object_id = $id;
            $facebook = new FacebookRequest;
            try {
                $response = $facebook->get()->ad($ad->object_id)->insights();
                dd($response);
            } catch (Exception $e) {
                return redirect('insights.index')->with(['error' => 'Error getting response from Facebook']);
            }
            $ad->json = $response;
            $ad->save();
        }

        return view('insights.show', compact('ad'));
    }

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
                $response = $facebook->get()->ad($ad->object_id)->insights();
            } catch (Exception $e) {
                return redirect('insights.index')->with(['error' => 'Error getting response from Facebook']);
            }
            $ad->json = $response;
            $ad->save();
        }

        return $ad->json;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $ad = AdInsights::find($id);
        if(isset($ad)) {
            return $ad->json;
        } else {
            $ad = new AdInsights;
            $ad->object_id = $id;
            $facebook = new FacebookRequest;
            $response = $facebook->get()->ad($ad->object_id)->insights();
            $ad->json = $response;
            $ad->save();
        }

        return redirect('insights.show', compact('ad'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
