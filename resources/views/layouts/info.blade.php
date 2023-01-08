@if (Session::has('errors'))
    <div class="alert alert-danger alert-dismissible text-center" role="alert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (Session::has('info'))
        <div class="alert alert-success alert-dismissible text-center" role="alert">
            {{ Session::get('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif