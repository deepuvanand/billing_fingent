<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Billing Solution</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('links');?>
  </head>
  <body>
    <?php $this->load->view('header');?>
    <div class="container">
      <div class="mt-3">
        <div class="card bg-light mb-3" >
          <div class="card-header">Sales Report</div>
          <div class="card-body">
            <table id="mainTable" class="table table-bordered table-striped serial">
              <thead class="table-dark">
                <tr>
                  <th>Sl.&nbsp;No</th>
                  <th width="25%">Invoice&nbsp;Number</th>
                  <th>Customer&nbsp;Name</th>
                  <th>Total&nbsp;Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($result) && !empty($result)) {foreach ($result as $key => $row) {$data = json_decode($row->data);?>
                <tr>
                  <td><?php echo ($key + 1) ?></td>
                  <td><a target="_balnk" href="<?php echo base_url('viewInvoice/' . ($row->invoice_number)) ?>"><?php echo $row->invoice_number; ?></a></td>
                  <td><?php echo $data->customer_name; ?></td>
                  <td><?php echo currency . "&nbsp;" . number_format(array_sum($data->totalAmount), 2); ?></td>
                </tr>
                <?php }} else {?>
                  <tr>
                    <td colspan="4" class="text-center">No result</td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('footer');?>
  </body>
</html>