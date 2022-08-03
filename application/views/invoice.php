<html>
    <head>
        <meta charset="utf-8" />
        <title>Invoice number : <?php echo $result->invoice_number; ?></title>
        <?php $this->load->view('links');?>
    </head>
    <body class="mb-5">
        <?php $data = json_decode($result->data);?>
        <div class="container mt-5 p-4 border border-dark rounded">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="text-info border-bottom">Invoice</h3>
                    <h5 class="text-danger"><?php echo project; ?></h5>
                </div>
                <div class="col-6 text-left">
                    <p class="text-dark">Invoice&nbsp;Number&nbsp;:&nbsp;<strong class="text-info"><?php echo $result->invoice_number; ?></strong></p>
                    <p class="text-dark">Invoice&nbsp;Date&nbsp;:&nbsp;<strong class="text-info"><?php echo $result->created_on; ?></strong></p>
                </div>
                <div class="col-6 text-right">
                    <p class="text-dark">Customer&nbsp;Name&nbsp;:&nbsp;<strong class="text-info"><?php echo $data->customer_name; ?></strong></p>
                    <button id="print" class="btn btn-sm text-primary"><i class="fa fa-print"></i>&nbsp;Print</button>
                </div>
                <div class="col-12 border-top">
                    <div class="mt-3">
                        <div class="card">
                            <h5 class="card-header">Fare Details</h5>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Sl.&nbsp;No</th>
                                            <th width="25%">Item</th>
                                            <th>Quantity</th>
                                            <th>Base&nbsp;Price</th>
                                            <th>Tax</th>
                                            <th>Discount</th>
                                            <th>Net&nbsp;Amount</th>
                                            <th>Total&nbsp;Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($data->name[0])) {foreach ($data->name as $key => $row) {?>
                                        <tr>
                                            <td><?php echo ($key + 1) ?></td>
                                            <td><?php echo $data->name[$key]; ?></td>
                                            <td><?php echo number_format($data->quantity[$key], 2); ?></td>
                                            <td><?php echo currency . "&nbsp;" . number_format($data->basePrice[$key], 2); ?></td>
                                            <td><?php echo number_format($data->tax[$key], 2); ?>%</td>
                                            <td class="text-right"><?php echo currency . "&nbsp;" . number_format($data->discountAmount[$key], 2); ?></td>
                                            <td class="text-right"><?php echo currency . "&nbsp;" . number_format($data->netAmount[$key], 2); ?></td>
                                            <td class="text-right"><?php echo currency . "&nbsp;" . number_format($data->totalAmount[$key], 2); ?></td>
                                        </tr>
                                        <?php }}?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right"><strong>Grand&nbsp;Total</strong></th>
                                        <th class="text-right grandNet"><strong><?php echo currency . "&nbsp;" . number_format(array_sum($data->netAmount), 2); ?></strong></th>
                                        <th class="text-right grandSum"><strong><?php echo currency . "&nbsp;" . number_format(array_sum($data->totalAmount), 2); ?></strong></th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="mt-5 text-right">
                                    <p>
                                        Total Base Amount : <strong><?php echo currency . "&nbsp;" . number_format(array_sum($data->netAmount), 2); ?></strong>
                                    </p>
                                    <p>
                                        Total Tax Amount : <strong><?php echo currency . "&nbsp;" . number_format(array_sum($data->totalAmount)+array_sum($data->discountAmount) - array_sum($data->netAmount), 2); ?></strong>
                                    </p>
                                    <p>
                                        discount Amount : <strong><?php echo currency . "&nbsp;" . number_format(array_sum($data->discountAmount) , 2); ?></strong>
                                    </p>
                                    <p class="border-top">
                                        Payable Amount : <strong><?php echo currency . "&nbsp;" . number_format(array_sum($data->totalAmount), 2); ?></strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-center text-muted">
                        <small>--- Thanks from <?php echo project; ?> team ---</small>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).on("click", "#print", function(){
           window.print();
           window.close();
           return false;
        });
    </script>
</html>