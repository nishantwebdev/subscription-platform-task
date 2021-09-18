<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

use Validator;
use App\Models\User;
use App\Models\Website;
use DB;

class SubscriptionController extends Controller
{
    public function sendError($error, $errorMessages, $code)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code??404);
    }
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response, 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestArr = $request->json()->all();

        $validator = Validator::make($requestArr, [
          'website_id' => 'required',
          'email' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }


        $website = Website::find($requestArr['website_id']);

        if (!empty($website)) {
            $user = User::where('email', $requestArr['email'])->first();
            DB::beginTransaction();
            if (empty($user)) {
                $user = User::create(['email'=>$requestArr['email']]);
                if (!$user) {
                    DB::rollBack();
                    return $this->sendError("Data not saved.", '', 500);
                }
            }
            $website->usersSubscribed()->syncWithoutDetaching($user);
            DB::commit();
            $resArr = [];
            return $this->sendResponse($resArr, 'User Subscribed.');
        } else {
            return $this->sendError("Website data not found.", '', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
