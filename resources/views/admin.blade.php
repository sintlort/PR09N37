@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 5px; margin: auto; font-family: 'Agency FB'">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('home')}}"><img src="https://ecs7.tokopedia.net/img/cache/300/default_picture_user/default_toped-17.jpg" class="mx-auto d-block img-fluid rounded-circle"></a>
                        <h1 class="text-center font-weight-bold" style="font-family: 'Agency FB' ">
                            Halo, {{Auth::user()->name}}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <form action="{{route('category.details')}}" method="get" target="_blank">
                    <button type="submit" class="btn btn-primary">{{_("Category")}}</button>
                </form>

                <br/>
                <form action="{{route('showRegCategory')}}" method="get" target="_blank">
                    <button type="submit" class="btn btn-primary">{{_("Add Category")}}</button>
                </form>
            </div>
            <div class="col-sm-2">

            </div>
        </div>
    </div>
@endsection
