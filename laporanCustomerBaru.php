<?php

include_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';


$tahun= isset($_GET['tahun']) ? $_GET['tahun'] : null;
 
$tsql2 = "SELECT number AS No, DATENAME(MONTH, '2012-' + CAST(number AS varchar(2)) + '-1') AS Bulan, 
        (select count(distinct ts.id_pelanggan) from tbl_pelanggan tp join tbl_pemesanan ts on (tp.id_pelanggan = ts.id_pelanggan)
        where tp.flag_pemesanan = 0 and month(ts.tanggal)= master.dbo.spt_values.number and year(ts.tanggal) = '$tahun') as Jumlah
        FROM  master.dbo.spt_values
        WHERE (type = 'P') AND (number BETWEEN 1 AND 12)";

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
        <strong>LAPORAN CUSTOMER BARU<strong>
        <div class="tebal"></div>
       
   
        <div text align="left" style="margin-left:20px;">
        <p>Tahun: <?php echo $tahun ?></p>
           <table>
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                </tr>
                <?php
                    $no=0;
                    while ($row2 = $getResults2->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row2["No"]."</td>";
                        echo "<td>".$row2["Bulan"]."</td>";
                        echo "<td>".$row2["Jumlah"]."</td>";
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
$mpdf->Output('Laporan Customer Baru.pdf','I');
?>