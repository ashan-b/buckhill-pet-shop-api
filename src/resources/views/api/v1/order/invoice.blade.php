<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{$order->uuid}}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        /*.invoice-box table tr td:nth-child(2) {*/
        /*    text-align: right;*/
        /*}*/

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
            border: 1px solid #eee;
            font-size: 12px;
            line-height: 14px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            text-align: center;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .text-right {
            text-align: right
        }

        .text-center {
            text-align: center;
        }

        .avoid-table-break{
            page-break-inside:avoid;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .text-small {
            font-size: 10px;
        }

        .no-wrap {
            white-space: nowrap;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        table {
            font-size: 12px;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                           {{config('app.store_name')}}
                        </td>

                        <td>
                            <strong>Date:</strong> {{$order->created_at!==null?$order->created_at->format('d-m-Y'):""}}
                            <br/>
                            <strong>Invoice #:</strong> {{$order->uuid}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td width="50%">
                            <strong>Customer Details</strong><br/>
                            First Name: {{$order->user->first_name}}<br/>
                            Last Name: {{$order->user->last_name}}<br/>
                            ID: {{$order->user->uuid}}<br/>
                            Phone Number: {{$order->user->phone_number}}<br/>
                            Email: {{$order->user->email}}<br/>
                            Address: {{$order->user->address_title}}<br/>
                            12345 Sunny Road<br/>
                            Sunnyville, CA 12345
                        </td>

                        <td class="text-right">
                            <strong>Billing/Shipping Details</strong><br/>
                            Billing: {{$order->address['billing']}}<br/>
                            Shipping: {{$order->address['shipping']}}<br/><br/>
                            <strong>Payment Details</strong><br/>
                            Payment Type: {{$order->payment['type']}}<br/>
                            <ul>
                                @if($order->payment['type']!=="credit_card")
                                    @foreach ($order->payment['details'] as $key => $node)
                                        <li>{{ $key }}: {{ $node }}</li>
                                    @endforeach
                                @else
                                    <li>Holder Name: {{ $order->payment['details']['holder_name'] }}</li>
                                    <li>
                                        Number: {{str_pad(substr($order->payment['details']['number'],-4),strlen($order->payment['details']['number']), "X", STR_PAD_LEFT)}}</li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h5>Items</h5>
    <table cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td class="text-center">#</td>
            <td>ID</td>
            <td>Item Name</td>
            <td>Quantity</td>
            <td>Unit Price</td>
            <td>Price</td>
        </tr>

        @foreach($order->products as $product)
            <tr class="item">
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-small">{{$product['uuid']}}</td>
                <td>{{$product['product']}}</td>
                <td class="text-center">{{$product['quantity']}}</td>
                <td class="text-right no-wrap">$ {{$product['price']}}</td>
                <td class="text-right no-wrap">$ {{round($product['price']*$product['quantity'],2)}}</td>
            </tr>
        @endforeach
    </table>


    <h5>Total</h5>
    <table class="avoid-table-break" style="width: 50%;  margin-right: 0px; margin-left: auto; border: 5px #eee solid;">
        <tr>
            <td width="80%" style=""><strong>Subtotal</strong></td>
            <td class="text-right no-wrap">$ {{$order->amount}}</td>
        </tr>
        <tr>
            <td><strong>Delivery fee</strong></td>
            <td class="text-right no-wrap">$ {{$order->delivery_fee}}</td>
        </tr>
        <tr>
            <td><strong>TOTAL</strong></td>
            <td class="text-right no-wrap"><strong>$ {{$order->amount+$order->delivery_fee}}</strong></td>
        </tr>
    </table>
</div>
</body>
</html>
