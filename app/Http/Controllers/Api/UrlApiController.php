<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalAccessToken;
use App\Repositories\UrlRepository;
use App\Http\Controllers\Controller;
use Log;

class UrlApiController extends Controller
{
    protected $urlRepository;
    
    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function getAllLink(Request $request)
    {
        Log::info("Get all links of current user.");

        $accessToken = $request->input('apikey');
        if (empty($accessToken)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10401,
                "message" => "Unauthorized access"
            );
            return response()->json($response, 401);
        }

        $accessTokenData = PersonalAccessToken::where('token',$accessToken)->first();
        if (empty($accessTokenData)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10401,
                "message" => "Unauthorized access"
            );
            return response()->json($response, 401);
        }

        $userId = $accessTokenData->user->id??null;
        if (empty($userId)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10404,
                "message" => "User not found"
            );
            return response()->json($response, 404);
        }

        $response = [
            "status" => "success",
            "urls" => $this->urlRepository->getUrls($userId, null, 10)
        ];

        return response()->json($response, 200);
    }

    public function shortenUrl(Request $request)
    {
        $accessToken = $request->input('apikey');
        if (empty($accessToken)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10401,
                "message" => "Unauthorized access"
            );
            return response()->json($response, 401);
        }

        $accessTokenData = PersonalAccessToken::where('token',$accessToken)->first();
        if (empty($accessTokenData)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10401,
                "message" => "Unauthorized access"
            );
            return response()->json($response, 401);
        }

        $userId = $accessTokenData->user->id??null;
        if (empty($userId)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10404,
                "message" => "User not found"
            );
            return response()->json($response, 404);
        }

        $inputUrl = $request->input('url');
        if (empty($inputUrl)) {
            $response = array(
                "status" => "failed",
                "status_code" => 10404,
                "message" => "Url not found"
            );
            return response()->json($response, 404);
        }

        $data = [
            'user_id' => $userId,
            'url' => $inputUrl
        ];

        return $this->urlRepository->create($data);
    }
}
