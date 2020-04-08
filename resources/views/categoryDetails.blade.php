@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 5px; margin: auto;">
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
                    <div class="card-header">Category Details</div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"> Category Name</th>
                                        <th scope="col"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $cat)
                                        <tr>
                                            <th scope="row">{{ $cat->category_name }}</th>
                                            <td>
                                                <a href="/admin/category/edit/{{ $cat->id }}">Edit</a>
                                                |
                                                <a href="/admin/category/delete/{{ $cat->id }}">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
