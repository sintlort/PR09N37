@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-white">
                    <h6 class="m-0 font-weight-bold text-primary">{{$products->product_name}}</h6>
                </div>
                <div class="media">
                    <img src="/product_images/{{$prodimg->image_name}}" style="width:20%">
                    <div class="media-body" style="margin-left: 1%">
                        <p class="text-left">Stock : {{$products->stock}}</p>
                        <p class="text-left">Weight : {{$products->weight}}</p>
                        <p class="text-left">Price : {{$products->price}}</p>
                        <p class="text-left font-italic btn btn-outline-danger" style="font-size: 9px"> {{$catproducts->category_name}}</p>
                        <form method="POST" action="{{route('itemsaction')}}">
                            <div class="form-group">
                                @csrf
                                <input name="product_id" type="hidden" value="{{$products->id}}">
                                <input name="qty" type="number" class="form-control col-1" placeholder="Qty" id="qty" value="1" min="1"><br/>
                                <button type="submit" class="btn btn-primary" name="action" value="buy">Buy</button>
                                <button type="submit" class="btn btn-primary" name="action" value="cart">Add to Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-left-primary shadow h-100 py-5" style="margin-top:1%">
            <div class="card-body" style="background-color: lightcyan;">
                <h1>Description</h1>
                <p>{{$products->description}}</p>
            </div>
        </div>
    </div>
@endsection
