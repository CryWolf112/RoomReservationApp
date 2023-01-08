@extends('layouts.layout')

@section('content')

@if (Auth::check() && Auth::user()->isAdmin())
<form action="news/update" method="POST" enctype="multipart/form-data">
  @csrf

  @include('layouts.info')

  <div class="d-flex justify-content-between">
    <h1 class="text-start gradient-title">News</h1>
    <div class="d-flex gap-2">
      <img src="{{ asset('storage/img/other/add-icon.svg') }}" width="54" height="54" draggable="false" class="img-fluid news-tool rounded-3 p-2" title="Add Item" onclick="addNewsItem('{{ asset('storage/img/other/') }}')">
      <input type="image" src="{{ asset('storage/img/other/database-add.svg') }}" width="54" height="54" draggable="false" class="img-fluid news-tool rounded-3 p-2" title="Save Changes" alt="Submit">
      <img src="{{ asset('storage/img/other/reverse-icon.svg') }}" width="54" height="54" draggable="false" class="img-fluid news-tool rounded-3 p-2" title="Dispose Changes" onclick="location.reload()">
    </div>
  </div>

<div class="col" id="news-container">
    @php
      foreach ($news as $news_item) {
        $id = $news_item->id;
        $date = Carbon\Carbon::parse($news_item->updated_at)->format('F j, Y.');

        echo '
        <div class="card my-3" id="div-'.$id.'">
            <input type="text" name="news_item['.$id.'][id]" value="'.$id.'" hidden>
            <div class="row g-0">
                <div class="col-md-4 p-3" ondragover="dragover(event)" ondrop="dropNewsImage(event, '.$id.')">
                    <img src="'.asset('storage/img/news/'.$news_item->news_image).'" id="news-img-'.$id.'" height="298" draggable="false" class="card-img-top rounded-3" style="cursor: pointer" onclick="clickNewsImageUpload('.$id.')">
                    <input type="file" id="upload-'.$id.'" name="news_item['.$id.'][image]" accept=".jpg,.jpeg,.svg,.png" onchange="displayNewsImage(this.files[0], '.$id.')" hidden>
                </div>
                <div class="col-md-8">
                    <div class="card-body text-start">
                        <div class="d-flex">
                            <input type="text" name="news_item['.$id.'][title]" value="'.$news_item->title.'" class="card-title textbox-news h5 w-100" placeholder="News Item Title" required>
                            <img src="'.asset('storage/img/other/delete-icon.svg').'" width="48" height="48" draggable="false" class="img-fluid rounded-3 p-2 ml-auto" title="Remove Item" style="cursor: pointer" onclick="removeNewsItem(`div-'.$id.'`)">
                        </div>
                        <textarea class="card-text textbox-news w-100" name="news_item['.$id.'][content]" placeholder="News Item Content" style="height: 186px" required>'.$news_item->content.'</textarea>
                        <p class="text-end"><small class="text-muted">Last updated on '.$date.'</small></p>
                    </div>
                </div>
            </div>
        </div>';
      }
    @endphp
</div>
</form>
@else
  <div class="d-flex justify-content-between">
    <h1 class="text-start gradient-title">News</h1>
  </div>
 <div class="col" id="news-container">
    @php
    foreach ($news as $news_item) {

      $date = Carbon\Carbon::parse($news_item->updated_at)->format('F j, Y.');
      
      echo '
      <div class="card my-3">
          <div class="row g-0">
              <div class="col-md-4 p-3">
                  <img src="'.asset('storage/img/news/'.$news_item->news_image).'" height="298" draggable="false" class="card-img-top rounded-3">
              </div>
              <div class="col-md-8">
                  <div class="card-body text-start">
                      <div class="d-flex">
                          <h5 class="card-title w-100">'.$news_item->title.'<p>
                      </div>
                      <p class="card-text w-100">'.$news_item->content.'</p>
                      <p class="text-end"><small class="text-muted">Last updated on '.$date.'</small></p>
                  </div>
              </div>
          </div>
      </div>';
    }
    @endphp
  </div>
@endif
@stop