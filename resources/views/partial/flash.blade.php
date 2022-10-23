@if(session('message'))
    <div class="alert alert-{{ session('alert-type') }} alert-dismissible" role="alert" id="session-alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- @if ($errors->any())

<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-ban"></i> Validdation Error</h5>
  @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
  @endforeach
</div>

@endif
@if (session()->has('message'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-check"></i> Success</h5>
  {{session()->get('message')}}
</div>
@endif --}}
