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
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header">{{_('Edit Category')}}</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('edit.category')}}">
                            @csrf
                                <input type="hidden" name="id" value="{{ $categoryid->id }}"><br/>
                                <div class="form-group row">
                                    <label for="category_name" class="col-sm-4 col-form-label text-sm-right">{{_('Category Name')}}</label>
                                    <div class="col-sm-6">
                                        <input id="category_name" type="text" name="category_name" value="{{ $categoryid->category_name }}">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-sm-4 offset-sm-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Category') }}
                                        </button>
                                    </div>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
