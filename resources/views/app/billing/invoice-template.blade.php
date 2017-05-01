<div class="sender">
    <img src="/img/product-logos/logo-pink.png" alt="null" />
    <div class="vcard address">
        <p class="fn"><a class="url" href="#">Provision Tracker</a><p>
        <p class="adr">
            <span class="street-address">HTML5 Hospital</span><br>
            <span class="region">Doctorville</span><br>
            <span class="postal-code">Postal Code</span><br>
            <span class="country-name">Great Britain</span>
        </p>
        <p class="tel">+44 (0)XXXX XXXXXX</p>
    </div>
</div>

<div class="recipient">
    <div class="vcard address">
        <p class="fn"><a class="url" href="#">Simon Hamilton</a><p>
        <p class="adr">
            <span class="street-address">HTML5 Hospital</span><br>
            <span class="region">Doctorville</span><br>
            <span class="postal-code">Postal Code</span><br>
            <span class="country-name">Great Britain</span>
        </p>
        <p class="tel">+44 (0)XXXX XXXXXX</p>
    </div>
</div>

<div class="details">
    Invoice {{$invoice->invoice_number}}
    payment due by {{$invoice->due_date}}
</div>

<table class="listing invoice-items">
    <thead>
        <tr>
            <th>Service description</th>
            <th>Quantity</th>
            <th>Unit price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoice_items as $item)
        <tr>
            <td>{{$item->description}}</td>
            <td>x {{$item->quantity}}</td>
            <td><?php echo number_format($item->unit_price, 2, '.', ',') ?></td>
            <td><?php echo number_format($item->net_total, 2, '.', ',') ?></td>
        </tr>
        @endforeach
    </tbody>
</table>
<table class="listing invoice-items totals">
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td>Net total</td>
            <td><?php echo number_format($invoice->net_total, 2, '.', ',') ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>VAT</td>
            <td><?php echo number_format($invoice->vat, 2, '.', ',') ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Total due</td>
            <td><?php echo number_format($invoice->gross_total, 2, '.', ',') ?></td>
        </tr>
    </tbody>
</table>
