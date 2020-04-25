@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('home')}}"><img src="https://ecs7.tokopedia.net/img/cache/300/default_picture_user/default_toped-17.jpg" class="mx-auto d-block img-fluid rounded-circle"></a>
                        <h1 class="text-center font-weight-bold" style="font-family: 'Agency FB' ">
                            Halo, {{Auth::user()->name}}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <form method="POST" action="">

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
