@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-white">
                    <h6 class="m-0 font-weight-bold text-primary">{{$products->product_name}}</h6>
                    <p class="text-right font-weight-bold text-primary">Rate : @if($rate==null) x @else {{round($rate,2)}}@endif/5</p>
                </div>
                <div class="media">

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 200px; height: 100px;">
                        <div class="carousel-inner" role="listbox">
                            @foreach($img as $image)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img class="d-block img-fluid" src="/product_images/{{$image->image_name}}" alt="First slide">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <div class="media-body" style="margin-left: 1%">
                        <p class="text-left">Stock : {{$products->stock}}</p>
                        <p class="text-left">Weight : {{$products->weight}}</p>
                        <p class="text-left">Price : {{$products->price}}</p>
                        @foreach($discount as $discountProduct)
                            <p class="text-left font-italic btn btn-outline-success">Diskon : {{$discountProduct->percentage}}%</p>
                        @endforeach
                        @foreach($categorydetailproducts as $cdp)
                            <p class="text-left font-italic btn btn-outline-danger" style="font-size: 9px"> {{$cdp->checkCategory->category_name}}</p>
                        @endforeach
                        <form method="POST" action="{{route('itemsaction')}}">
                            <div class="form-group">
                                @csrf
                                <input name="product_id" type="hidden" value="{{$products->id}}">
                                <input name="qty" type="number" class="form-control col-1" placeholder="Qty" id="qty" @if($products->stock<1) value="0" min="0" @else value="1" min="1" @endif max="{{$products->stock}}"><br/>
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
        <div class="card shadow h-100 py-2" style="margin-top:1%">
            <div class="card-header text-xl-left font-weight-bold text-primary text-uppercase mb-2">Review</div>
            <div class="card-body">
                @foreach($review as $rev)
                    <div class="card border-bottom-danger mb-3">
                        <div class="card-title ml-3 mt-2 text-xl-left font-weight-bold text-primary text-uppercase mb-2">{{$rev->user_rev->name}}</div>
                        <div class="card-body bg-gradient-primary text-white">
                            <p>{{$rev->content}}</p>
                        </div>
                    </div>
                 @endforeach
            </div>
        </div>
    </div>
@endsection
