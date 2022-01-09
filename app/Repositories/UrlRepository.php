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
            $result = $result->simplePaginate($perPage);
        }

        return $result;
    }

    public function getUrlBySlug($slug) {
        $result = Url::where('slug', $slug)->first();

        return $result;
    }
    
    public function create($data)
    {
        if (!validateURL($data['url']??null)) {
            return response()->json(['status' => 'failed', 'status_code' => 10406 ,'message' => 'Invalid url found']);
        }

        $data['id'] = Str::uuid()->toString();
        $data['slug'] = $this->createSlug();
        try {
            $url = Url::create($data);
            Log::info("new url added ".json_encode($data));
            return response()->json(['status' => 'success', 'data' => $url->refresh(),
            'message' => 'New url added successfully'], 200);
        } catch(Throwable $e) {
            Log::info("adding new url failed with ".$e->getMessage());
            return response()->json(['status' => 'failed', 'message' => 'Adding new url failed']);
        }
    }

    public function update($id, $link)
    {
        if (!validateURL($link??null)) {
            return response()->json(['status' => 'failed', 'status_code' => 10406 ,'message' => 'Invalid url found']);
        }

        try {
            $url = Url::find($id);
            $url->update(['url'=>$link]);
            Log::info("url updated ".$link);
            return response()->json(['status' => 'success', 'data' => $url->refresh(),
            'message' => 'Url updated successfully'], 200);
        } catch(Throwable $e) {
            Log::info("Updation of url failed with ".$e->getMessage());
            return response()->json(['status' => 'failed', 'message' => 'Updation of url failed']);
        }
    }

    public function delete($id)
    {
        if (!$id) {
            return response()->json(['status' => 'failed', 'status_code' => 10404 ,'message' => 'Id not found']);
        }

        try {
            $url = Url::find($id);
            if($url){
                $url->delete();
                return response()->json(['status' => 'success', 'message' => 'Url deleted successfully'], 200);
            }
        } catch(Throwable $e) {
            Log::info("deleting url failed with ".$e->getMessage());
            return response()->json(['status' => 'failed', 'message' => 'Deleting url failed']);
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
