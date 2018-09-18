<?php

include_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';


$tahun= isset($_GET['tahun']) ? $_GET['tahun'] : null;

 
$tsql2 = "SELECT distinct top (5) tp.nama,tp.flag_pemesanan as 'Jumlah Reservasi',
        (select sum(total_harga) FROM tbl_transaksi ta JOIN tbl_pemesanan tb on 
            (ta.kode_pemesanan = tb.kode_pemesanan) where (tb.id_pelanggan = tp.id_pelanggan)) as 'Total Pembayaran'
        from tbl_pelanggan tp JOIN tbl_pemesanan tr on (tp.id_pelanggan = tr.id_pelanggan) 
        join tbl_transaksi tt on (tr.kode_pemesanan =  tt.kode_pemesanan)
        where year(tt.tanggal) = '$tahun'
        order by [Jumlah Reservasi] desc";

$getResults2 = $conn->prepare($tsql2);
$getResults2->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);


if ($getResults2) {
      
        // connection nod
     
} else {
    echo 'failure'; //Empty result
}




$mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8', 
        'format' => [190, 236], 
        'orientation' => 'P'
]);
ob_start();
?>

<html>
<head>
    <style>
        html{ 
            margin-top:20;
            margin-left:200; 
            margin-right:200; /* Space from this element (entire page) and others*/
            padding-top: 10;
            padding-left: 200; /*space from content and border*/
            padding-right: 200; 
            padding-bottom: 10;
            border: solid black;
            border-width: thin;
            overflow:hidden;
            display:block;
            box-sizing: border-box;
           
        }
        body{
             font-family: calibri;
        }
        .tipis{
            width: 700px;
            height: 1px;
            margin: 0; /* Space from this element (entire page) and others*/
            padding: 0; /*space from content and border*/
            border: solid black;
            border-width: thin;
            overflow:hidden;
            display:block;
            box-sizing: border-box;
        }
         .tebal{
            width: 700px;
            height: 2px;
            margin: 0; /* Space from this element (entire page) and others*/
            padding: 0; /*space from content and border*/
            border: solid black;
            border-width: thin;
            overflow:hidden;
            display:block;
            box-sizing: border-box;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div align="center">
        <img src="logo.png" style="margin-top:20px;">
        <br/>
        <br/>
        <div class="tipis"></div>
        <strong>LAPORAN 5 CUSTOMER RESERVASI TERBANYAK<strong>
        <div class="tebal"></div>

        <div text align="left" style="margin-left:20px;">
        <p>Tahun: <?php echo $tahun ?></p>
           <table>
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Jumlah Reservasi</th>
                    <th>Total Pembayaran</th>
                </tr>
                <?php
                    $no=0;
                    while ($row2 = $getResults2->fetch(PDO::FETCH_ASSOC)) {
                        $totalPembayaran = number_format( $row2["Total Pembayaran"], 0 , ',' , '.' );
                        $no++;
                        echo "<tr>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row2["nama"]."</td>";
                        echo "<td>".$row2["Jumlah Reservasi"]."</td>";
                        echo "<td>Rp".$totalPembayaran."</td>";
                        echo "</tr>";
                    }
                ?>
                
           </table> 
         
        </div>

        <br/>
        <br/>
        <div align="right" style="margin-left:20px">
            <p>Dicetak tanggal <?php 
   
              
                echo date('d F Y');?>
        </div>

        
    </div>
</body>
</html>


<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();

//Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan 5 Customer.pdf','I');
?>