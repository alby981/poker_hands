<div class="title m-b-md">
    @yield('title')
</div>

<div class="links">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ route('pokerhands') }}">Poker Hands</a>
    <a href="{{ route('uploadpokerhands') }}">Upload Poker Hands</a>
    @guest
    <a href="{{ route('login') }}">{{ __('Login') }}</a>
    @if (Route::has('register'))
    <a href="{{ route('register') }}">{{ __('Register') }}</a>
    @endif
    @else
    {{ Auth::user()->name }} <span class="caret"></span>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endguest
</div>