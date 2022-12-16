@extends('layouts.admin')
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
                         {{--  <div class="col-lg-3 col-6">
                               {{--  <div class="small-box bg-primary">
                                    <div class="inner">
                                        <p style="font-size: 30px" id="clock">&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-clock" style="top: 10px;"></i>
                                    </div>
                                    <span style="height: 15px;" class="small-box-footer"></span>
                                </div>  --}}
                            {{--  </div>    --}}
                              <div class="col-lg-4 col-4">
                                <a href="{{route('inquiry')}}">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <p style="font-size: 20px">Verkauf - Anfragen</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-balance-scale" style="top: 10px;"></i>
                                        </div>
                                        <span class="small-box-footer">Mehr Info <i
                                                    class="fas fa-arrow-circle-right"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-4">
                                <a href="{{route('domain')}}">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <p style="font-size: 20px">Domains - Domainliste</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-funnel-dollar" style="top: 10px;"></i>
                                        </div>
                                        <span class="small-box-footer"> Mehr Info <i
                                                    class="fas fa-arrow-circle-right"></i></span>
                                    </div>
                                </a>
                            </div>  
                              <div class="col-lg-4 col-4">
                                <a href="{{route('statistics')}}">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <p style="font-size: 20px">Statistiken – Aufrufe Detail</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-chart-bar" style="top: 10px;"></i>
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
