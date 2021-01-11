@extends('auth.admin_layouts.main')

@section('title','Dashboard')

@section('custom_styles')
    <style>
       
    </style>
@endsection

@section('content')
<div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <!--<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">-->
              <!--  <div class="mdc-card info-card info-card--success">-->
              <!--    <div class="card-inner">-->
              <!--      <h5 class="card-title">Borrowed</h5>-->
              <!--      <h5 class="font-weight-light pb-2 mb-1 border-bottom">$60,076</h5>-->
              <!--      <p class="tx-12 text-muted">48% target reached</p>-->
              <!--      <div class="card-icon-wrapper">-->
              <!--        <i class="mdi mdi-chart-donut-variant"></i>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <!--<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">-->
              <!--  <div class="mdc-card info-card info-card--danger">-->
              <!--    <div class="card-inner">-->
              <!--      <h5 class="card-title">Annual Profit</h5>-->
              <!--      <h5 class="font-weight-light pb-2 mb-1 border-bottom">$90,104</h5>-->
              <!--      <p class="tx-12 text-muted">55% target reached</p>-->
              <!--      <div class="card-icon-wrapper">-->
              <!--        <i class="mdi mdi-cash-usd"></i>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <!--<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">-->
              <!--  <div class="mdc-card info-card info-card--primary">-->
              <!--    <div class="card-inner">-->
              <!--      <h5 class="card-title">Lead Conversion</h5>-->
              <!--      <h5 class="font-weight-light pb-2 mb-1 border-bottom">$234,769</h5>-->
              <!--      <p class="tx-12 text-muted">87% target reached</p>-->
              <!--      <div class="card-icon-wrapper">-->
              <!--        <i class="mdi mdi-chart-bubble"></i>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <!--<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">-->
              <!--  <div class="mdc-card info-card info-card--info">-->
              <!--    <div class="card-inner">-->
              <!--      <h5 class="card-title">Average Income</h5>-->
              <!--      <h5 class="font-weight-light pb-2 mb-1 border-bottom">$1,200</h5>-->
              <!--      <p class="tx-12 text-muted">87% target reached</p>-->
              <!--      <div class="card-icon-wrapper">-->
              <!--        <i class="mdi mdi-cash-multiple"></i>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
             <h1>Welcome {{Auth::user()->name}}...!</h1>
            </div>
          </div>
          @endsection