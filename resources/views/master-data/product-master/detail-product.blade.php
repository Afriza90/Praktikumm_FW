<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product Detail')}}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="overflow-x-auto rounded-lg bg-white p-6 show-md">
            <a href="{{ route('product-index') }}" class="text-blue-500 hover:underline"><- Back</a>
            <div class="mt-4">
                <h3 class="mt-4 text-2xl font-semibold">{{ $product->product_name }}</h3>
                <p> <strong> ID : </strong> {{ $product->id}}</p>
                <p> <strong> Unit : </strong> {{ $product->unit}}</p>
                <p> <strong> Type : </strong> {{ $product->type}}</p>
                <p> <strong> Information : </strong> {{ $product->information}}</p>
                <p> <strong> Quantity : </strong> {{ $product->quantity}}</p>
                <p> <strong> Producer : </strong> {{ $product->producer}}</p>
            </div>
        </div>
    </div>
</x-app-layout>