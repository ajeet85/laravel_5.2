<table class="listing invoices">
    <thead>
        <tr>
            <th>Package / Subscription</th>
            <th>Amount</th>
            <th>Sent on</th>
            <th>Due date</th>
            <th>Paid</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($invoices as $invoice)
    <tr class="listing-row">
        <td><a href="/app/settings/billing/invoice/{{$invoice->invoice_number}}"> Invoice: {{$invoice->invoice_number}}</a></td>
        <td><a href="/app/orgs/"><?php echo number_format($invoice->gross_total, 2, '.', ',') ?></a></td>
        <td><a href="/app/orgs/">{{$invoice->created_at}}</a></td>
        <td><a href="/app/orgs/">{{$invoice->due_date}}</a></td>
        <td><a href="/app/orgs/">{{$invoice->paid}}</a></td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$invoices->links()}}</td></tr>
</tbody>
</table>
