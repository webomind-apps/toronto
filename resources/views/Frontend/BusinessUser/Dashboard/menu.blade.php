<div class="col-md-3 box-shadow-1">
    <div class="ac-list">
    <div class="text-center">
        <div class="icon-circle">
            <h3>{{ucfirst(user()->fname)[0]}}</h3>
        </div>
        <p ><b>{{ucfirst(user()->name)}}</b></p>
        <p class="text-grey">{{user()->email}}</p>
    </div>
        <ul>
            <li>
                <a href="{{route('business.user.profile')}}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
            </li>
            <li>
                <a href="{{route('business.user.wishlist')}}"><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</a>
            </li>

            <li>
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                <form id="logout-form" action="{{ route('business.user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
