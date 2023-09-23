@extends('layouts.layout')

@section('title', 'Cart')

@section('css')
    <link href="{{asset('assets/css/cart.css')}}" rel="stylesheet"/>
@endsection

@section('content')

    <div class="mb-12">
        <div class="text-center">
            <p class="title font-semibold text-sm">Total</p>
            <p class="value font-semibold text-lg font-bold">{{$cart->amount}}</p>
        </div>
        <ul class="p-4">

            @if($cart->products->isEmpty())
                <li class="text-center">There is no products...</li>
            @else
                @foreach($cart->products as $product)
                    <li class="flex bg-white p-5 rounded-lg shadow-lg mb-5" data-id="{{$product->id}}">
                        <img src="{{$product->image_url}}" class="w-28"/>
                        <div class="flex-grow flex flex-col md:flex-row items-center justify-center md:justify-between">
                            <div class="flex flex-col gap-3 md:text-lg mb-5 md:mb-0 md:pl-5 w-3/4">
                                <p class="title font-semibold">{{$product->name}}</p>
                                <p class="value font-bold ">{{$product->price}} sum</p>
                            </div>
                            <div class="flex">
                                <button
                                    class="fa fa-minus rounded-lg bg-yellow-400 flex justify-center items-center p-3 z-10"></button>
                                <input disabled id="count" type="number" value="{{$product->count}}"
                                       class="text-center text-md font-semibold p-2 rounded w-20 focus:outline-none product-count"/>
                                <button
                                    class="fa fa-plus rounded-lg bg-yellow-400 flex justify-center items-center p-3 z-10"></button>
                            </div>
                            <button class="fa-solid fa-trash rounded hover:bg-purple-200 p-2"></button>
                        </div>
                    </li>
                @endforeach

        </ul>
    </div>

    <div class="header-section flex flex-row px-8 py-1 fixed bottom-0 w-screen w-full z-50">
        <div class="flex-grow text-center">
            <form action="{{route('cart.store')}}" method="POST">
                @csrf
                <button class="bg-white px-10 py-3 rounded-lg w-full">
                    <span class="font-bold">Checkout</span>
                    <i class="fa fa-chevron-right"></i>
                </button>
            </form>
        </div>
    </div>
    @endif
@endsection

@section('js')
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script>
        $(function () {

            $(".fa-minus").click(function () {
                let input = $(this).siblings(".product-count");
                let currentCount = input.val();
                let newCount = currentCount - 1
                let product_id = $(this).parents('li').attr('data-id')

                if (currentCount <= 1) {
                    deleteLast(product_id);
                } else {
                    // input.val(newCount);
                    updateCart(product_id, newCount)
                }

            });

            $(".fa-trash").click(function () {
                let product_id = $(this).parents('li').attr('data-id')

                deleteLast(product_id)
            });

            function deleteLast(product_id) {
                $.ajax({
                    url: "{{route('cart.delete')}}",
                    method: 'DELETE',
                    data: {
                        _token: "{{csrf_token()}}",
                        product_id: product_id,
                    },
                    success: function (res) {
                        window.location.reload()
                    }
                })
            }

            $(".fa-plus").click(function () {
                let product_id = $(this).parents('li').attr('data-id')
                let input = $(this).siblings(".product-count");
                let currentCount = parseInt(input.val()); // without parseInt it concats values. e.g {currentValue (4) + 1 == 41, not 5}

                let newCount = currentCount + 1
                // input.val(newCount);

                updateCart(product_id, newCount)
            });

            function updateCart(product_id, count) {

                $.ajax({
                    url: "{{route('cart.update')}}",
                    method: 'PUT',
                    data: {
                        _token: "{{csrf_token()}}",
                        product_id: product_id,
                        count: count
                    },
                    success: function (res) {
                        window.location.reload()
                    }
                })
            }
        })
    </script>
@endsection
