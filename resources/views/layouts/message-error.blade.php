@if (session('message'))
    <div class="row">
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    </div>
@endif
@if (session('error'))
    <div class="row">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
@endif