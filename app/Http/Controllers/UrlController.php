<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Url;
use App\Repositories\UrlRepository;

class UrlController extends Controller
{
    protected $urlRepository;
    
    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function index(Request $request, $slug)
    {   
        $data = $this->urlRepository->getUrlBySlug($slug);
        if(!$data){
            return abort(404);
        }
        
        // save no of redirects
        $this->urlRepository->saveUrlRedirects($data->id??null);

        return redirect()->away($data->url);
    }

    public function create(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'url' => $request['url']
        ];
        return $this->urlRepository->create($data);
    }
}
