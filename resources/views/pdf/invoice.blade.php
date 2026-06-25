<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Invoice</title>

  <style>
    body {
      font-family: sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 8px;
    }
  </style>
</head>

<body>

  <h2>INVOICE</h2>

  <p>
    Invoice :
    {{ $transaction->invoice_number }}
  </p>

  <p>
    Customer :
    {{ $transaction->customer->name }}
  </p>

  <p>
    Date :
    {{ $transaction->transaction_date }}
  </p>

  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
      </tr>
    </thead>

    <tbody>

      @foreach($transaction->items as $item)
        <tr>
          <td>
            {{ $item->product->name }}
          </td>

          <td>
            {{ $item->quantity }}
          </td>

          <td>
            {{ number_format($item->unit_price) }}
          </td>

          <td>
            {{ number_format($item->subtotal) }}
          </td>
        </tr>
      @endforeach

    </tbody>
  </table>

  <h3>
    Grand Total :
    Rp {{ number_format($transaction->grand_total) }}
  </h3>

</body>

</html>