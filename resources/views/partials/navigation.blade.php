
<nav class="navbar navbar-expand-lg navbar-light bg-primary">



    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            
            @auth
            
            <li class="nav-item">
                <a class="nav-link" href="#"> 
                    {{ Auth::user()->name }} 
                </a>
            </li>
            

            @include('partials.logout')
            

            @else

            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"> {{ __('Login') }} </a>
            </li>

            <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}"> {{ __('Create Account') }} </a>
            </li>
                

            @endauth
        </ul>
    </div>

</nav>


