@extends('admin.layouts.dashboard')

@section('content')
aca
  <form action="{{ route('admin.subscribe.post') }}" method="POST">
    {{ csrf_field() }}
    <script
      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
      data-key="{{ config('services.stripe.key') }}"
      data-amount="5000"
      data-name="Payments App"
      data-description="Subscription Monthly"
      data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
      data-locale="auto">
    </script>
  </form>
@endsection