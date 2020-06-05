@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">

            <div class="card col-lg-3 bg-white" style="height: 10%">
                <div class="card-body">
                    <h1 class="my-4">Hehe Shop</h1>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin-bottom: 2%">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="https://i2.wp.com/www.agoda.com/wp-content/uploads/2019/05/Jeddah-day-trips-Feature-Photo-1200-x-350-Jeddah-city-at-sunset.jpg?fit=1200%2C350&ssl=1" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="https://www.mentalhealthfirstaid.org/wp-content/uploads/2018/07/shutterstock_189788309-1200x350.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="https://www.sodexo.co.id/app/uploads/2019/11/Tajir-1200x350.jpg" alt="Third slide">
                        </div>
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

                <div class="row">
                    @foreach($allproducts as $ap)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 ">
                                <a href="#"><img class="card-img-top" src="https://htmlstream.com/preview/space-v1.1/assets/img/700x400/img1.jpg" alt=""></a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="/products/{{$ap->id}}">{{$ap->product_name}}</a>
                                    </h4>
                                    <h5>Rp. {{$ap->price}}</h5>
                                    <p class="card-text">{{$ap->description}}</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
@endsection
