<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\UrlRepository;

class HomeController extends Controller
{
    protected $urlRepository;
    
    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function index(Request $request)
    {
        $currentUserUrls = $this->urlRepository->getUrls(Auth::user()->id??null);
        $allUrls = $this->urlRepository->getUrls(null, ['redirect_count','desc']);
        return view('index', [
            'allUrls' => $allUrls,
            'currentUserUrls' => $currentUserUrls
        ]);
    }

    public function getAllRepo(Request $request) {
        $allRepo = getAllRepoAuthUser(Auth::user()->github->personal_access_token);

        // validating of data is valid
        if(isset($allRepo->message) && $allRepo->message){
            return response()->json(['status' => 'failed', 'message' => 'Access token is invalid']);
        }
        
        $allStarredRepo = '';
        foreach($allRepo as $repo){
            $allStarredRepo .= $this->getHtmlRepoDump($repo);
        }
        return response()->json(['status' => 'success', 'message' => 'All repositories fetched successfully',
        'data' => $allStarredRepo]);
    }

    public function getAllStarredRepo(Request $request) {
        $allRepo = getAllRepoAuthUser(Auth::user()->github->personal_access_token);

        // validating of data is valid
        if(isset($allRepo->message) && $allRepo->message){
            return response()->json(['status' => 'failed', 'message' => 'Access token is invalid']);
        }

        $allStarredRepo = '';
        foreach($allRepo as $repo){
            if($repo->stargazers_count > 0){
                $allStarredRepo .= $this->getHtmlRepoDump($repo);
            }
        }
        return response()->json(['status' => 'success', 'message' => 'All starred repositories fetched successfully',
        'data' => $allStarredRepo]);
    }

    public function getHtmlRepoDump($data){
        return '
            <div class="repo mb-15 mt-15">
                <span class="mr-15" style="float: right;">Last Updated: '.$data->updated_at.'</span>
                <label><a href="'.$data->html_url.'" target="_blank">'.$data->name.'</a></label>
            </div>
        ';
    }
}
