<?php

include_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';



$kode_pemesanan= isset($_GET['kode_pemesanan']) ? $_GET['kode_pemesanan'] : null;


$tsql = "SELECT te.nama,te.alamat,tp.tanggal,tp.jml_dewasa,tp.jml_anak,tp.tanggal_masuk,tp.tanggal_keluar,tp.permintaan_khusus,tc.tanggal as 'tgl_bayar',ta.nama as 'petugas'
        FROM tbl_pelanggan te JOIN tbl_pemesanan tp on (te.id_pelanggan = tp.id_pelanggan)
        JOIN tbl_transaksi tc on (tp.kode_pemesanan = tc.kode_pemesanan) JOIN tbl_petugas ta on (tc.id_petugas = ta.id_petugas)
        WHERE tp.kode_pemesanan ='$kode_pemesanan'";

$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      

      while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
            $dataRincian = array(); // Your return array
            $dataRincian["nama"] = $row["nama"];
            $dataRincian["alamat"] = $row["alamat"];
        	$dataRincian["tanggal"] = $row["tanggal"];
            $dataRincian["jml_dewasa"] = $row["jml_dewasa"];
            $dataRincian["jml_anak"] = $row["jml_anak"];
            $dataRincian["tanggal_masuk"] = $row["tanggal_masuk"];
            $dataRincian["tanggal_keluar"] = $row["tanggal_keluar"];
            $dataRincian["permintaan_khusus"] = $row["permintaan_khusus"];
            $dataRincian["tanggal_bayar"]= $row["tgl_bayar"];
            $dataRincian["petugas"]= $row["petugas"];
            // pushes a new row onto your array with each iteration
        }


} else {
    echo 'failure'; //Empty result
}


 
$tsql2 = "SELECT tj.jenis,tr.jumlah,tr.harga,tr.jenis_kasur
        FROM tbl_rincianPemesanan tr join tbl_jenis tj on (tr.kode_jenis = tj.kode_jenis)
        WHERE kode_pemesanan='$kode_pemesanan'";

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
        <strong>TANDA TERIMA PEMESANAN<strong>
        <div class="tebal"></div>
       
        <div text align="left" style="margin-left:20px;">
            <p style="font-weight: normal;">ID Booking &emsp;: <?php echo $kode_pemesanan;?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Tanggal: <?php 
                $t = strtotime($dataRincian["tanggal"]);
                echo date("d-M-Y",$t);?></p>
            <?php if(substr($kode_pemesanan, 0,1)=='G')
                    echo '<p style="font-weight: normal;">PIC &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: '.$dataRincian["petugas"].'</p>';
            ?>
            <p style="font-weight: normal;">Nama &emsp;&emsp;&emsp;&nbsp;: <?php echo $dataRincian["nama"];?></p>
            <p style="font-weight: normal;">Alamat &emsp;&emsp;&nbsp;&nbsp;: <?php echo $dataRincian["alamat"];?></p>
        </div>
        <div class="tipis"></div>
        <strong>DETAIL PEMESANAN<strong>
        <div class="tebal"></div>
        <div text align="left" style="margin-left:20px;">

            <p style="font-weight: normal;">Check In &emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php 
             $t = strtotime($dataRincian["tanggal_masuk"]);
            echo date("d-M-Y",$t);?>
            <p style="font-weight: normal;">Check Out &emsp;&nbsp;&nbsp;&nbsp;: <?php 
             $t = strtotime($dataRincian["tanggal_keluar"]);
            echo date("d-M-Y",$t);?>
            <p style="font-weight: normal;">Dewasa &emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $dataRincian["jml_dewasa"];?></p>
            <p style="font-weight: normal;">Anak &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;: <?php echo $dataRincian["jml_anak"];?></p>
            <p style="font-weight: normal;">Tanggal Bayar : <?php 
            $t = strtotime($dataRincian["tanggal_bayar"]);
            echo date("d-M-Y",$t);?>

        </div>
        <div class="tipis"></div>
        <br>
        <div text align="left" style="margin-left:20px;">
       
           <table>
                <tr>
                    <th>Jenis Kamar</th>
                    <th>Bed</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
                <?php
                   $jumlahTotal=0;
                    while ($row2 = $getResults2->fetch(PDO::FETCH_ASSOC)) {
                        $hargaKamar = number_format( $row2["harga"]/$row2["jumlah"], 0 , ',' , '.' );
                        $hargaTotal = number_format( $row2["harga"], 0 , ',' , '.' );
                        echo "<tr>";
                        echo "<td>".$row2["jenis"]."</td>"; 
                        echo "<td>".$row2["jenis_kasur"]."</td>";
                        echo "<td>".$row2["jumlah"]."</td>";
                        echo "<td>Rp".$hargaKamar."</td>";
                        echo "<td>Rp".$hargaTotal."</td>";      
                        echo "</tr>";
                        $jumlahTotal = $jumlahTotal+$row2["harga"];
                    }
                ?>
                <tr style="border-bottom:hidden;">
                    <td style="border-bottom:hidden;border-right:hidden;border-left:hidden;"></td>
                    <td style="border-bottom:hidden;border-right:hidden;border-left:hidden;"></td>
                    <td style="border-bottom:hidden;border-right:hidden;border-left:hidden;"></td>
                    <td style="border-bottom:hidden;border-left:hidden;"></td>
                    <td><strong>Rp<?php $jumlahTotal = number_format( $jumlahTotal , 0 , ',' , '.' );
                        echo $jumlahTotal;?><strong></td>
                </tr>
           </table> 
         
        </div>
        <br>
        <div text align="left" style="margin-left:20px;">
           <p style="font-weight: normal;">Permintaan khusus :</p>
           <p style="font-weight: normal;"><?php echo $dataRincian["permintaan_khusus"];?>
        </div>
        
    </div>
</body>
</html>


<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();

//Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
$mpdf->WriteHTML($html);
$mpdf->Output('TandaTerimaReservasi.pdf','I');
?>