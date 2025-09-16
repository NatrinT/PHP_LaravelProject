@extends('frontend')
@section('css_before')
@section('navbar')
@endsection

@section('showProduct')

    {{-- @foreach($products as $data) --}}
    <div class="col-12 col-sm-4 col-md-4 col-lg-3 mb-2">
      <div class="card" style="width: 100%;">
        {{-- <a href="/detail/{{ $data->id}}">
          <img src="{{ asset('storage/' . $data->product_img) }}" class="card-img-top" alt="devbanban.com">
        </a> --}}
        <div class="card-body">
          <h5 class="card-title">
            {{-- <a href="/detail/{{ $data->id}}" class="link-offset-2 link-underline link-underline-opacity-0">
              {{$data->product_name}}
            </a>
          </h5>
          <p class="card-text">Price {{number_format($data->product_price,2)}} THB.</p>
          <a href="/detail/{{ $data->id}}" class="btn btn-success">more detail click...</a> --}}
        </div>
      </div>
    </div>
    {{-- @endforeach --}}



  <div class="row mt-2 mb-2">
    <!-- Pagination links -->
    <div class="col-sm-5 col-md-5"></div>
    <div class="col-sm-3 col-md-3">
      <center>
        {{-- {{ $products->links() }} --}}
      </center>
    </div>
</div>




@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}