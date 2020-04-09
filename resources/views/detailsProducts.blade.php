@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 5px; margin: auto;">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header font-weight-bold">{{$products->product_name}}</div>
                    <div class="card-body" >
                        <div class="media">
                            <span>

                            </span>
                            <div class="media-body">
                                <p class="text-left">Stock : {{$products->stock}}</p>
                                <p class="text-left">Weight : {{$products->weight}}</p>
                                <p class="text-left">Price : {{$products->price}}</p>
                                <p class="text-left font-italic" style="font-size: 9px"> {{$catproducts->category_name}}</p>
                                <form method="get" action="">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Buy</button>
                                    </div>
                                </form>
                                <form method="get" action="">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="background-color: lightgrey;">
                        <h1>Description</h1>
                        <p>{{$products->description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
