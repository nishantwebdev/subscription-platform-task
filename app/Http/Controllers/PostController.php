<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Jobs\SendNewPostEmails​;

use Illuminate\Http\Request;
use Validator;
use App\Models\Website;
use DB;

class PostController extends Controller
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
          'title' => 'required',
          'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $website = Website::find($requestArr['website_id']);
        if (!empty($website)) {
            DB::beginTransaction();
            $post = Post::create($requestArr);
            if ($post) {
                DB::commit();
                $resArr['post'] = $post;
                dispatch(new SendNewPostEmails​($post, $website));
                return $this->sendResponse($resArr, 'Post Saved.');
            } else {
                DB::rollBack();
                return $this->sendError("Data not saved.", '', 500);
            }
        } else {
            return $this->sendError("Website data not found.", '', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
