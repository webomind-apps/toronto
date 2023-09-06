@push('style')
<style>
.nav.nav-tabs > li.{
    pointer-events: none;
}

</style>
@endpush
<!--   -->
<div class="col-md-12">
    <ul class="nav nav-tabs tabs-left sideways">
        <li>
            <a class="@if (Route::currentRouteName()=='registration.step1' ) active @endif disable" href="javascript:void(0)" data-toggle="tab">
                <i class="fa fa-user-plus"></i>
                <b>Step-1:</b> Create Account
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" class="@if (Route::currentRouteName()=='registration.step2' ) active @endif" >
                <i class="fa fa-check-square-o fa-2x"></i>
                <b>Step-2:</b> Select Advertising Packages
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" class="@if (Route::currentRouteName()=='registration.step3' ) active @endif">
                <i class="fa fa-wpforms fa-2x"></i>
                <b>Step-3:</b> Business Details
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" class="@if (Route::currentRouteName()=='registration.step4' ) active @endif">
                <i class="fa fa-credit-card-alt"></i>
                <b>Step-4:</b> Payment Option
            </a>
        </li>
    </ul>
</div>
