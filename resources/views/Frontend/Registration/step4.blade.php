@push('style')
    <style>
        .paymentTable {
            width: 50%;
            margin-right: auto;
            margin-left: auto;
            margin-bottom: 20px;
        }

        .paymentTable tr td {
            padding: 10px;
        }

        .text-right {
            text-align: right;
        }

        .payment-radio {
            margin-left: 0px !important;
        }

        .paymentTable tr td:nth-child(1) {
            width: 180px;
            text-align: right;
        }

        .paymentTable tr td:nth-child(3) {
            width: 200px;
        }

        .paymentTable tr td:nth-child(2) {
            width: 5px;
            text-align: center;
        }

        .paymentTable tr td:nth-child(3) {
            text-align: left;
        }

        .paymentTable tr:nth-child(4) {
            border-top: 1px solid black;
        }

    </style>
@endpush
<h3>Payment Details</h3>

<form action="{{ route('registration.submit.step4') }}" method="post">
    @csrf
    <fieldset>
        <div class="panel-body row">
            <div class="col-md-12">
                <table class="paymentTable">
                    <tr>
                        <td class="text-right">Registration Date</td>
                        <td>:</td>
                        <td>{{ $detail->business_upgrade_temps->upgraded_date??"" }}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Package Expiry Date</td>
                        <td>:</td>
                        <td>{{ $detail->business_upgrade_temps->expired_date??"" }}</td>
                    </tr>
                </table>
            </div>
            <hr />
            @php
                $pack_price = $detail->business_upgrade_temps->package_price??99;
                $gst_per = session()->get('registration_step1_gst_per') ?? 0;
                $pack_gst_amount = ($gst_per*$pack_price)/100;
            @endphp
            <div class="col-md-12">
                <table class="paymentTable">
                    <tr>
                        <td class="text-right">Premimum Package Price</td>
                        <td>:</td>
                        <td class="">${{$pack_price}}</td>
                    </tr>

                    <tr>
                        <td class="text-right">Hst({{$gst_per}}%)</td>
                        <td>:</td>
                        <td>${{$pack_gst_amount}}</td>
                    </tr>

                    <tr>
                        <td class="text-right">Total</td>
                        <td>:</td>
                        <td>${{$pack_price+$pack_gst_amount}}</td>
                    </tr>
                </table>
            </div>
            <hr />
            <div class="col-md-12">
                <table class="paymentTable">
                    <tr>
                        <td class="text-right">Payment Mode</td>
                        <td>:</td>
                        <td class=""><input type="radio" name="paymentType" class="payment-radio" />Credit Card 
                                     <input type="radio" name="paymentType" class="payment-radio" />Paypal 
                                     <input type="radio" name="paymentType" class="payment-radio" />E-transfer
                                     <input type="radio" name="paymentType" class="payment-radio" />Cheque       
                        </td>
                    </tr>
                </table>
            </div>
            <hr />
        </div>
    </fieldset>

    <div class="text-center">
        <button type="submit" name="register_now" class="view-btn">Register Now</button>
    </div>

</form>

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
