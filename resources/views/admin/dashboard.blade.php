@extends('layouts.plantilla-admin')
@section('title', 'Books | Admin')
@section('content')
    <div class="container-fluid dashboard__content mt-3">
        <div class="card-estadisticas">
            <div class="card-item">
                <i class="bi bi-graph-up-arrow"></i>
                <div class="info">
                    <p class="title">Ventas del último mes</p>
                    <p class="data">2.148€</p>
                </div>
            </div>
            <div class="card-item">
                <i class="bi bi-piggy-bank"></i>
                <div class="info">
                    <p class="title">Beneficio del último mes</p>
                    <p class="data">2.148€</p>
                </div>
            </div>
            <div class="card-item">
                <i class="bi bi-book"></i>
                <div class="info">
                    <p class="title">Libros vendidos último mes</p>
                    <p class="data">2.148€</p>
                </div>
            </div>
            <div class="card-item">
                <i class="bi bi-person-up"></i>
                <div class="info">
                    <p class="title">Usuarios registrados hoy</p>
                    <p class="data">2.148€</p>
                </div>
            </div>
        </div>
        <div class="charts__container mt-2">
            <div class="chart">
                {!! $chart->container() !!}
            </div>
            <div class="chart">
                {!! $userChart->container() !!}
            </div>
        </div>

        {!! $chart->script() !!}
        {!! $userChart->script() !!}
    </div>
    <script src="{{asset('build/assets/chart.umd.js')}}"></script>
@endsection