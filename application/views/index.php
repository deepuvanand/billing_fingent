<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Billing Solution</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('links');?>

    <style>
      .serial {
        counter-reset: serial-number;
      }
      .serial td:first-child:before {
        counter-increment: serial-number;
        content: counter(serial-number);
      }
      .modal-open .modal {
          background-color: rgba(0, 0, 0, 0.8) !important;
      }
    </style>
  </head>
  <body>
    <?php $this->load->view('header');?>
    <div class="container">

      <div class="mt-3">

        <div class="card bg-light mb-3" >
          <div class="card-header">Items</div>
          <div class="card-body">
            <form id="mainForm" method="post" action="<?php echo base_url('printInvoice'); ?>" target="_blank" autocomplete="off">
              <div class="row p-3">
                <div class="col-6">Invoice&nbsp;Number : <strong><?php echo $invoiceNumber = rand("1000", "9999") . strtotime(date("YmdHis")); ?></strong>
                  <input type="hidden" class="form-control" readonly="" name="invoiceNumber" value="<?php echo $invoiceNumber; ?>" >
                </div>
                <div class="col-6">Invoice&nbsp;Date : <strong><?php echo $invouceDate = date("dS M, Y H:i A"); ?></strong>
                  <div class="form-group row mt-2">
                    <label class="col-4">Customer&nbsp;Name<span class="text-danger">*</label>
                    <div class="col-8">
                      <input type="text" name="customer_name" class="form-control validate[required]">
                    </div>
                  </div>
                </div>
              </div>
              <table id="mainTable" class="table table-responsive table-bordered table-striped serial">
                <thead class="table-dark">
                  <tr>
                    <th>Sl.&nbsp;No</th>
                    <th width="25%">Item</th>
                    <th>Quantity</th>
                    <th>Base&nbsp;Price</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Discount Amount</th>
                    <th>Net&nbsp;Amount</th>
                    <th>Total&nbsp;Amount</th>
                    <th width="60"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td><input type="text" name="name[]" class="form-control name validate[required]"></td>
                    <td><input type="text" name="quantity[]" onkeyup="calculate();" class="form-control quantity validate[required]"></td>
                    <td><input type="text" name="basePrice[]" onkeyup="calculate();" class="form-control basePrice validate[required]"></td>
                    <td class="text-right">
                      <select class="form-control tax" name="tax[]" onchange="calculate();" style="min-width:80px;">
                        <option value="0">0%</option>
                        <option value="1">1%</option>
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-control discountType" name="discountType[]" onchange="calculate();" style="min-width:120px;">
                        <option value="Fixed">Fixed</option>
                        <option value="Percentage">Percentage</option>
                      </select>
                      <input type="text" name="discount[]" onkeyup="calculate();" class="form-control discount">
                    </td>
                    <td class="text-right"><input type="text" name="discountAmount[]" readonly="" class="form-control discountAmount"></td>
                    <td class="text-right"><input type="text" name="netAmount[]" readonly="" class="form-control netAmount"></td>
                    <td class="text-right"><input type="text" name="totalAmount[]" readonly="" class="form-control totalAmount"></td>
                    <td class="text-center"></td>
                  </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th colspan="5" class="text-right"><strong>Grand&nbsp;Total</strong></th>
                  <th class="text-right grandNet"><strong></strong></th>
                  <th class="text-right grandSum"><strong></strong></th>
                </tr>
                </tfoot>
              </table>
            </form>
            <div class="text-right">
              <strong class="processingMessage mr-5 text-danger"></strong>
              <button type="submit" form="mainForm" id="printInvoice" class="btn btn-dark btn-sm"><i class="fa fa-print"></i>&nbsp;Print&nbsp;Invoice</button>
              <button type="button" id="addMore" class="btn btn-dark btn-sm"><i class="fa fa-plus"></i>&nbsp;Add&nbsp;More</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('footer');?>
  </body>
  <script>
  $(document).ready(function() {
      $("#mainForm").validationEngine();
  });
  $(document).on("click", "#addMore", function() {
      var data = $("#mainTable tbody tr:eq(0)").clone();
      data.find("td").last().append('<button class="btn btn-danger btn-sm removeRow"><i class="fa fa-times"></i></button>');
      data.find("input").val('');
      data.find("select").val('0');
      data.appendTo("#mainTable tbody");
  });
  $(document).on("click", ".removeRow", function() {
      $(this).closest('tr').remove();
  });

  function calculate() {
      var grandNet = grandSum = 0;
      $("#mainTable .warning").remove();
      $("#mainTable tbody tr").each(function() {
          var quantity = $(this).find(".quantity").val();
          var basePrice = $(this).find(".basePrice").val();
          var discount = $(this).find(".discount").val();
          var discountType = $(this).find(".discountType").val();
          var tax = $(this).find(".tax").val();
          if (quantity && !$.isNumeric(quantity)) {
              $(this).find(".quantity").closest("td").append('<b class="text-danger warning">Invalid&nbsp;number</b>');
              $(this).find(".quantity").val('').focus();
          }
          if (basePrice && !$.isNumeric(basePrice)) {
              $(this).find(".basePrice").closest("td").append('<b class="text-danger warning">Invalid&nbsp;number</b>');
              $(this).find(".basePrice").val('').focus();
          }
          if (discount && !$.isNumeric(discount)) {
              $(this).find(".discount").closest("td").append('<b class="text-danger warning">Invalid&nbsp;number</b>');
              $(this).find(".discount").val('').focus();
          }
          if (quantity && basePrice) {
              quantity = parseFloat(quantity);
              basePrice = parseFloat(basePrice);
              tax = parseFloat(tax);

              var net = quantity * basePrice;
              var sum = quantity * (basePrice + (basePrice * tax) / 100);

              var finalDiscount = 0;
              if(discountType=="Fixed" && parseFloat(discount)){
                finalDiscount = parseFloat(discount);
              }else if(parseFloat(discount)){
                finalDiscount = sum*parseFloat(discount)/100;
              }

              sum -= finalDiscount;

              $(this).find(".discountAmount").val(finalDiscount.toFixed(2));
              $(this).find(".netAmount").val(net.toFixed(2));
              $(this).find(".totalAmount").val(sum.toFixed(2));
              grandNet += net;
              grandSum += sum;
          }
      });
      $(".grandNet").text('<?php echo currency; ?>&nbsp;'+grandNet.toFixed(2));
      $(".grandSum").text('<?php echo currency; ?>&nbsp;'+grandSum.toFixed(2));
  }

  $(document).on("submit", "#mainForm", function(){
    var w = window.open('about:blank','Popup_Window','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=1200,height=700,left = 312,top = 234');
    this.target = 'Popup_Window';
  });

  </script>
</html>