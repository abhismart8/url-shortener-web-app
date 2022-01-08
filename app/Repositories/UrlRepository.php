<?php

namespace App\Repositories;

use Log;
use Illuminate\Support\Str;
use App\Models\Url;
use App\Models\UrlRedirect;
use Throwable;

class UrlRepository
{
    public function getUrls($userId=null, $sort=null, $perPage=null) {
        $result = Url::user($userId)->sorting($sort);

        if($perPage){
            $result = $result->paginate($perPage);
        }

        return $result;
    }

    public function getUrlBySlug($slug) {
        $result = Url::where('slug', $slug)->first();

        return $result;
    }
    
    public function create($data)
    {
        $data['id'] = Str::uuid()->toString();
        $data['slug'] = $this->createSlug();
        try {
            $url = Url::create($data);
            Log::info("new url added ".json_encode($data));
            return response()->json(['status' => 'success', 'data' => $url->refresh(),
            'message' => 'New url added successfully']);
        } catch(Throwable $e) {
            Log::info("adding new url failed with ".$e->getMessage());
            return response()->json(['status' => 'failed', 'message' => 'Adding new url failed']);
        }
    }

    public function createSlug(){
        $slug = Str::random(10);
        $url = Url::where('slug', $slug)->first();
        if($url){
            return $this->createSlug();
        }
        return $slug;
    }

    public function saveUrlRedirects($id){
        $url = Url::find($id);
        $url->update(['redirect_count' => $url->redirect_count+1]);
    }
}