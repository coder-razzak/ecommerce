


@extends('layouts.frontend.app')

@section('title', 'Brand wise')
    
@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url({{ asset('assets/frontend/images/bg-01.jpg') }});">
        <h2 class="ltext-105 cl0 txt-center">
            Brand Wise
        </h2>
    </section>

    <section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="row isotope-grid" style="position: relative; height: 1717.38px;">
                @foreach ($brandProducts as $brandProduct)
                    @foreach ($brandProduct->product as $item)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women" style="position: absolute; left: 25%; top: 0px;">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ Storage::disk('public')->url('product/'.$item->image) }}" alt="IMG-PRODUCT">

                                    <a href="{{ $item->slug }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">
                                        Add to Card
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $item->name }}
                                        </a>

                                        <span class="stext-105 cl3">
                                            ${{ $item->price }}
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            
		</div>
	</section>


@endsection