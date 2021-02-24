@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<div class="py-5 text-center">
<img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>THÔNG TIN THANH TOÁN</h2>
  @include('layouts.message-error')
</div>

<div class="row">
  <div class="col-md-4 order-md-2 mb-4">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted">Đơn hàng</span>
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
        <span>Tổng (VND)</span>
        <strong>{{$order->total}}</strong>
      </li>
    </ul>
  </div>
  <div class="col-md-8 order-md-1">
    @if (Auth::check())
    <form class="needs-validation" novalidate action="payment" method="POST">
      @csrf
      <input type="hidden" name="order_id" value="{{$order->id}}">
      <input type="hidden" name="redirect_url" value="{{$redirect_url}}">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="cc-name">Tên người thanh toán</label>
          <div class="success-feedback bold">
            {{ $personal->full_name }}
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <label for="cc-number">Mã OTP</label>
          <input type="text" class="form-control" id="otp" name="otp" placeholder="" required pattern="[0-9]{6}">
          <div class="invalid-feedback">
            Yêu cầu nhập mã OTP
          </div>
        </div>
      </div>
      <hr class="mb-4">
      <button class="btn btn-primary btn-lg btn-block" id="continueBtn" type="submit"><i class="fa fa-circle-notch fa-spin hidden"></i> Thanh toán</button>
    </form>

    <form action="payment_logout" method="POST">
        @csrf
        <button class="btn btn-sm btn-warning btn-block" type="submit" formaction="payment_logout">Đăng xuất</button>
      </form>
    @else
    <form class="needs-validation" novalidate action="payment_login" method="POST">
      @csrf
      <input type="hidden" name="order_id" value="{{$order->id}}">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="cc-name">Tên tài khoản</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="" required>
          <small class="text-muted">LFVN cung cấp tài khoản là số điện thoại</small>
          <div class="invalid-feedback">
            Nhập tên tài khoản
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="cc-number">Mật khẩu</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="" required>
          <div class="invalid-feedback">
            Nhập mật khẩu
          </div>
        </div>
      </div>
      <hr class="mb-4">
      <button class="btn btn-primary btn-lg btn-block" id="continueBtn" type="submit"><i class="fa fa-circle-notch fa-spin hidden"></i> Đăng nhập để thanh toán</button>
    </form>
    @endif
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    $('#progressbar').hide();

    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');

      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            $('#continueBtn i').removeClass('hidden');
            $('#continueBtn').prop('disabled', true);
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>
@endsection