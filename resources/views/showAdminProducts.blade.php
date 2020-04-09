@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 5px; margin: auto;">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Products Detail</div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"> Product Name</th>
                                <th scope="col"> Product Price</th>
                                <th scope="col"> Action </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allproducts as $prod)
                                <tr>
                                    <th scope="row">{{ $prod->product_name }}</th>
                                    <td>{{$prod->price}}</td>
                                    <td>
                                        <a href="/products/{{ $prod->id }}">View</a> |
                                        <a href="products/{{$prod->id}}">Edit</a> |
                                        <a href="products/delete/{{$prod->id}}">Delete</a>
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
