<div class="tab-pane fade user-edit pt-3" id="user-edit">
    @foreach ($users as $data)
   <form action="{{ route('kirim.user') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
            <div class="col-md-8 col-lg-9">
                <input name="username" id="username" type="text" class="form-control" required autocomplete="on" value="{{ $data->username ?? '-' }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
            <div class="col-md-8 col-lg-9">
                <input name="email" id="email" type="email" class="form-control" autocomplete="on" required value="{{ $data->email ?? '-' }}">
            </div>
        </div>
        <div class="text-center mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    @endforeach
</div>

