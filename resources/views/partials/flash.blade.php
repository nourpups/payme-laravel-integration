@if(session('flash'))
    <div class="relative">
        <div class="absolute inset-x-80 top-5 bg-{{session('flash')['class']}}-300 rounded px-4 py-3 w-1/2 text-lg text-center">
            {{session('flash')['message']}}
        </div>
    </div>
@endif
