<?php
  $d=getdate();
  $year=$d['year'];
  $total = 0; $cost = 0;
  for ($i=1; $i <= 12 ; $i++) 
  {   
    $list_orrders = $this->Morders->order_follow_month($year, $i);
    $sum = 0;
    foreach ($list_orrders as $row_orrder) 
    {
      $order_detail = $this->Morderdetail->orderdetail_orderid($row_orrder['id']);
      foreach ($order_detail as $value) {
        $sum += $value['count'];
      }
      $total += $row_orrder['money'];
    }
  }

  $conn = new mysqli("localhost", "root", "", "codeigter");
  $query = "SELECT * FROM db_product WHERE trash = 1";
  $result = mysqli_query($conn, $query);
  $chart_data = '';

  while($row = mysqli_fetch_array($result)){
    $chart_data .= "{ ten:'".$row["name"]."', soluong:'".$row["number_buy"]."', doanhthu:'".$row["number_buy"] * $row["price_sale"]."'}, ";
  }
  $chart_data = substr($chart_data, 0, -2);

  
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?php echo $total1; ?></h3>
            <p>Sản phẩm</p>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
          <a href="<?php echo base_url() ?>admin/product" class="small-box-footer">Danh sách sản phẩm</a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php echo $total2; ?></h3>
            <p>Bài viết</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-chat "></i>
          </div>
          <a href="<?php echo base_url() ?>admin/content" class="small-box-footer">Danh sách bài viết</a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php echo $total3; ?></h3>
            <p>Liên hệ</p>
          </div>
          <div class="icon">
            <i class="ion ion-email"></i>
          </div>
          <a href="<?php echo base_url() ?>admin/customer" class="small-box-footer">Liên hệ khách hàng</a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo $total4; ?></h3>
            <p>Đơn hàng</p>
          </div>
          <div class="icon">
            <i class="ion ion-cube"></i>
          </div>
          <a href="<?php echo base_url() ?>admin/orders" class="small-box-footer">Danh sách đơn hàng</a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
  
  
    <!-- /.content -->

    



  </div>
  <!-- /.content-wrapper -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  <script>

  new Morris.Bar({
    element: 'myfirstchart2',
    barColors: ['#3366CC'],
    data: [<?php echo $chart_data?>],
    xkey: 'ten',
    ykeys: ['soluong','doanhthu'],
    labels: ['Số Lượng Bán','Doanh Thu'],
    hideHover:'auto',
    stacked:true
  });


   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawVisualization);

   function drawVisualization() {
    var data = google.visualization.arrayToDataTable([
     ['Month', 'Bán ra', 'Đơn hàng'],
     <?php
     $d=getdate();
     $year=$d['year'];
     for ($i=1; $i <= 12 ; $i++) 
     {   
      $list_orrders = $this->Morders->order_follow_month($year, $i);
      $sum = 0;
      foreach ($list_orrders as $row_orrder) 
      {
        $order_detail = $this->Morderdetail->orderdetail_orderid($row_orrder['id']);
        foreach ($order_detail as $value) {
          $sum += $value['count'];
        }
      }
      if($i >= 1 && $i <=9)
      {
        echo "['0".$i.'/'.$year."',".$sum.",".count($list_orrders)."],";
      }
      else
      {
        echo "['".$i.'/'.$year."',".$sum.",".count($list_orrders)."],";
      }
    }
    ?>

    ]);

    var options = {
      title: 'Số lượng bán ra từ 01/2022 - 12/2022',
      seriesType: 'bars'
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  } 
</script>