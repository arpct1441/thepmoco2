<html>

<head>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;

        }

        header,
        h5 {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: ;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: #;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        p,
            {
            margin-right: 50px;
            margin-left: 50px;
        }

        table,
        th,
        td {
            margin-right: 80px;
            margin-left: 50px;
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px";

        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        {{ Session::get('property_name') }} | Acknowledgment Receipt
        <h5>{{ App\Models\Property::find(Session::get('property'))->country->country }},
            {{ App\Models\Property::find(Session::get('property'))->province->province }},
            {{ App\Models\Property::find(Session::get('property'))->city->city }},
            {{ App\Models\Property::find(Session::get('property'))->barangay }}
        </h5>

    </header>

    <footer>
        <h5>
            Prepared by: {{ $user }}, {{ $role }} | {{ auth()->user()->mobile_number }}
        </h5>
        {{ Session::get('property_name') }} Copyright &copy;
        <?php echo date("Y");?>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <hr>
        <p>
            AR #: {{ $ar_no }}
        </p>
        <p>
            Payment Made: {{ Carbon\Carbon::parse($created_at)->format('M d, Y') }}
        </p>
        <p>
            Amount Paid: {{ number_format($amount, 2) }}
        </p>
        <p>
            Tenant: {{ $tenant }}
        </p>

        <p>
            Mode of Payment: {{ $mode_of_payment }}
        </p>



        @if($mode_of_payment === 'cheque')
        <p>
            Cheque #: {{ $cheque_no }}
        </p>
        @endif

        @if($mode_of_payment === 'bank')
        <p>
            Bank #: {{ $bank }}
        </p>

        <p>
            Date Deposited: {{ Carbon\Carbon::parse($date_deposited)->format('M d, Y') }}
        </p>
        @endif


        <p>
            Unpaid Bills: {{ number_format(($balance->sum('bill') - $balance->sum('initial_payment')),2)}}
        </p>
        <br><br><br>
        <p>
            <b>Payments Breakdown</b>
        </p>

        <p>
        <table class="">
            <tr>
                <th>Bill #</th>
                <th>Date Posted</th>
                <th>Unit</th>
                <th>Particular</th>
                <th>Period Covered</th>
                <th>Amount</th>
            </tr>

            @foreach($collections as $item)

            <tr>
                <td>{{ $item->bill->bill_no }}</td>

                <td>{{ Carbon\Carbon::parse($item->bill->created_at)->format('M d, Y') }}</td>
                <td>{{ $item->unit->unit }}</td>
                <td>{{ $item->bill->particular->particular }}</td>
                <td>{{ Carbon\Carbon::parse($item->bill->start)->format('M d,
                    Y').'-'.Carbon\Carbon::parse($item->bill->end)->format('M d, Y') }} </td>
                <td>{{ number_format($item->collection,2) }}</td>


            </tr>

            @endforeach
        </table>
        </p>



    </main>
</body>

</html>