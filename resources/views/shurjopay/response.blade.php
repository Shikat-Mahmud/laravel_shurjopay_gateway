<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Response - shurjoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center py-4 bg-white">
                        <h3>Payment Status</h3>
                    </div>
                    <div class="card-body p-4">
                        @if(isset($response[0]) && $response[0]->sp_code == '1000')
                            <div class="alert alert-success text-center">
                                <h4>Payment Successful!</h4>
                                <p>Transaction ID: {{ $response[0]->bank_trx_id }}</p>
                            </div>
                        @else
                            <div class="alert alert-danger text-center">
                                <h4>Payment Failed!</h4>
                                <p>{{ $response[0]->sp_message ?? 'Unknown error' }}</p>
                            </div>
                        @endif

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr><th>Order ID</th><td>{{ $response[0]->customer_order_id ?? 'N/A' }}</td></tr>
                                    <tr><th>shurjoPay Order ID</th><td>{{ $response[0]->sp_order_id ?? 'N/A' }}</td></tr>
                                    <tr><th>Amount</th><td>{{ $response[0]->amount ?? 'N/A' }} {{ $response[0]->currency ?? 'BDT' }}</td></tr>
                                    <tr><th>Customer Name</th><td>{{ $response[0]->name ?? 'N/A' }}</td></tr>
                                    <tr><th>Status</th><td>{{ $response[0]->sp_message ?? 'N/A' }}</td></tr>
                                    <tr><th>Time</th><td>{{ $response[0]->date_time ?? 'N/A' }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('shurjopay.index') }}" class="btn btn-primary">Back to Demo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
