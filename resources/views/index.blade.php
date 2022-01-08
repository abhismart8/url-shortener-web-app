@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <a href="/logout" class="btn btn-danger mt-15" style="float: right;"> Logout </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <div class="mt-15">
            <div class="add-new-url">
                <h2><strong> Shorten Your Link </strong></h2>
                <div class="form-group">
                    <input type="text" class="form-control" id="new-url" placeholder="Enter Your Link" />
                </div>
                <div class="form-group">
                    <a href="javascript:" class="btn btn-primary" id="add-new-url-btn"> Shorten </a>
                </div>
                <div class="form-group shorten-url-div hide">
                    <input type="text" name="shorten-url" class="form-control" id="shorten-url" 
                    readonly>
                    <span style="float:right;">
                        <a href="javascript:;" class="btn btn-secondary" id="clipboard_btn_id">
                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 text-center">
        <div class="form-group mt-30">
            <h4>My Links</h4>
            <div class="table-responsive" id="users-table">
                <table class="table listings_table scrolldown">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Link</th>
                            <th>Shorter Link</th>
                            <th>Redirection Count</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($currentUserUrls) && $currentUserUrls->count())
                        @foreach($currentUserUrls->get() as $key => $url)
                        <tr>
                            <td> {{$key+1}} </td>
                            <td><a href="{{$url->url}}" data-toggle="tooltip" title="{{$url->url}}" target="_blank">{{substr($url->url, 0, 20).'...'}}</a></td>
                            <td><a href="{{$url->shorten_url}}" target="_blank">{{$url->shorten_url}}</a></td>
                            <td>{{$url->redirect_count}}</td>
                            <td>{{$url->created_at->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-center" style="margin-bottom: 30px;">
        <div class="form-group mt-30">
            <h4>Top 100 most frequently accessed URLs</h4>
            <div class="table-responsive" id="users-table">
                <table class="table listings_table scrolldown">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Link</th>
                            <th>Shorter Link</th>
                            <th>Redirection Count</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($allUrls) && $allUrls->count())
                            @foreach($allUrls->take(100)->get() as $key => $url)
                            <tr>
                                <td> {{$key+1}} </td>
                                <td><a href="{{$url->url}}" data-toggle="tooltip" title="{{$url->url}}" target="_blank">{{substr($url->url, 0, 20).'...'}}</a></td>
                                <td><a href="{{$url->shorten_url}}" target="_blank">{{$url->shorten_url}}</a></td>
                                <td>{{$url->redirect_count}}</td>
                                <td>{{$url->created_at->diffForHumans()}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('post-scripts')
<script src="{{ asset('js/index.js') }}"></script>
<script>
    window.shortenUrl = "{{route('shorten-url', ['slug' => 'xxxx'])}}"
    // add new url
    document.getElementById('add-new-url-btn').addEventListener('click', function(){
        addUrl("{{route('add-url')}}", document.getElementById('new-url').value)
    });

</script>
@endpush