{{-- <tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/assets/logo.png') }}" class="logo" alt="Toronto Connection">
@else
{{ $slot }}
@endif
</a>
</td>
</tr> --}}

<tr>
    <td class="header" style="padding-bottom: 0px">
        <table style="background: #fbdedf;width:570px;margin: 0 auto    ">
            <tr>
                <td>
                    <a href="{{ $url }}" style="display: inline-block;">
                        <img style="width:auto;height:75px" src="{{ asset('assets/images/assets/logo.png') }}" alt="Toronto Connection" class="logo">
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
