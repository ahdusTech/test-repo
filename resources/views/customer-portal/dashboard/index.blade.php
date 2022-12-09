@extends('customer-portal.layout.customer')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                {{-- <a href="{{route('customer.auction.all')}}"> --}}
                                    <a href="#">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <p style="font-size: 20px">All auctions</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-gavel" style="top: 10px;"></i>
                                        </div>
                                        <span class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <a href="#">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <p style="font-size: 20px">My auctions</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-gavel" style="top: 10px;"></i>
                                        </div>
                                        <span class="small-box-footer">More info<i
                                                    class="fas fa-arrow-circle-right"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                                <a href="#">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <p style="font-size: 20px"> My favorites </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-gavel" style="top: 10px;"></i>
                                        </div>
                                        <span class="small-box-footer"> More Info <i
                                                    class="fas fa-arrow-circle-right"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <a href="#">
                                    <div class="small-box bg-warning text-white">
                                        <div class="inner">
                                            <p style="font-size: 20px" class="text-white">My Watchlist </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-bell" style="top: 10px;"></i>
                                        </div>
                                        <span class="small-box-footer"> More info <i
                                                    class="fas fa-arrow-circle-right"></i></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
