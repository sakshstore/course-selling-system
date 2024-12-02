
<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<style>
body {
font-family: Arial, sans-serif;
}
.invoice-header, .invoice-details, .customer-details, .product-details, .invoice-summary {
margin-bottom: 20px;
}
.invoice-header {
text-align: center;
border-bottom: 1px solid #ddd;
padding-bottom: 10px;
}
.invoice-details, .customer-details {
display: flex;
justify-content: space-between;
}
.product-details table {
width: 100%;
border-collapse: collapse;
}
.product-details th, .product-details td {
padding: 10px;
border: 1px solid #ddd;
}
.invoice-summary p {
font-size: 1.2em;
margin: 5px 0;
}
</style>
</head>
<body>
<div class="invoice-header">
<h2>Invoice Details</h2>
</div>
<div class="invoice-details">
<div>
<p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
<p><strong>Date:</strong> {{ $invoice->date }}</p>
<p><strong>Status:</strong> {{ $invoice->status }}</p>
</div>
<div class="customer-details">
<h4>Customer Details</h4>
<strong>Name:</strong> {{ $invoice->customer->name }} 
<br/><strong>Email:</strong> {{ $invoice->customer->email }} 
<br /><strong>Phone:</strong> {{ $invoice->customer->phone }}</br>
</div>
</div>
<div class="product-details">
<h4>Products</h4>
<table>
<thead>
<tr>
<th>Product Name</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>
</thead>
<tbody>
@foreach ($invoice->products as $product)
<tr>
<td>{{ $product->name }}</td>
<td>{{ $product->pivot->quantity }}</td>
<td>{{ $product->price }}</td>
<td>{{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="invoice-summary">
<p><strong>Subtotal:</strong> {{ number_format($invoice->products->sum(function($product) { return $product->price * $product->pivot->quantity; }), 2) }}</p>
<p><strong>Tax:</strong> {{ $invoice->tax }}</p>
<p><strong>Total:</strong> {{ number_format($invoice->products->sum(function($product) { return $product->price * $product->pivot->quantity; }) + $invoice->tax, 2) }}</p>
</div>
</body>
</html>
