 <div class="title m-b-md">
    @yield('title')
 </div>

<div class="links">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ route('pokerhands') }}">Check Poker Hands</a>
    <a href="{{ route('uploadpokerhands') }}">Upload Poker Hands</a>
</div>