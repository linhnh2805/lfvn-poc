@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<div class="py-5 text-center">
<img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>Thanh toán thành công!</h2>
  <div class="row">
      <div class="alert alert-success">
          Hệ thống sẽ tự động chuyển về trang của đối tác trong vòng 5s ...
      </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 order-md-2 mb-4">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted">Giỏ hàng</span>
      <span class="badge badge-secondary badge-pill">{{$quantity}}</span>
    </h4>
    <ul class="list-group mb-3">
      @foreach ($order->line_items as $item)
      <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
          <h6 class="my-0">{{$item->name}}</h6>
          <small class="text-muted">Số lượng: {{$item->quantity}}</small>
        </div>
        <span class="text-muted">{{$item->price}}</span>
      </li>
      @endforeach
      <li class="list-group-item d-flex justify-content-between">
        <span>Total (VND)</span>
        <strong>{{$order->total}}</strong>
      </li>
    </ul>
  </div>
  <div class="col-md-8 order-md-1">
    <h4 class="mb-3">Thông tin thanh toán</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
          <label for="cc-name">Họ</label>
          <div class="success-feedback bold">
            {{ $order->billing->first_name }}
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="cc-number">Tên</label>
          <div class="success-feedback bold">
          {{ $order->billing->last_name }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="cc-name">Email</label>
          <div class="success-feedback bold">
            {{ $order->billing->email }}
          </div>
        </div>
      </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#progressbar').hide();

    var redirect_url = '{{$redirect_url}}';

    var counter = 5;
    setTimeout(function() {
      window.location = redirect_url;
    }, 5000);
  });
</script>
@endsection