

<?php



//perintah mengambil value dari checkbox di masukkan kedalam array $gejalaygdipilih
$no=1;
$sql=mysqli_query($db,"select * from gejala ");
while($rs=mysqli_fetch_array($sql))
    {
        if ($_POST[$no]=="") {}
        else{$gejalaygdipilih[]= $_POST[$no];}
$no=$no+1;
        }
     if (count($gejalaygdipilih)<=2){
          echo "<script>
          alert ('Gejala yang dipilih Kurang, Pilih Minimal 3 Gejala');
          location.href='index2.php?content=hasil2';
          </script>";
        }
        else{
?>

<table class="striped" >
        <thead>
          <tr>
              <th >No</th>
              <th >Gejala yang dipilih</th>
              <th >Densitas</th>
          </tr>
        </thead>

        <tbody>
 
<?php
for ($i=0; $i < count($gejalaygdipilih) ; $i++) { 
?>    

          <tr>
            <td><?php echo $i+1;?></td>
            <td><?php
        $sql1=mysqli_query($db,"select * from gejala where no='$gejalaygdipilih[$i]' ");
                    $rs1=mysqli_fetch_array($sql1);
             echo"[".$gejalaygdipilih[$i]."] ".$rs1[gejala];?></td>
            <td><?php echo"$rs1[ds]";?></td>
          </tr>
 <?php $no=$no+1; } ?>         
        </tbody>
      </table>



  <?php /// perhitungan awal
$sql=mysqli_query($db,"select * from penyakit");
        while($rs=mysqli_fetch_array($sql))
    { $tempkombinasinama[]=$rs[kode_hama];}
mysqli_query($db,"TRUNCATE temp ");
$jkt=implode("", $tempkombinasinama);

mysqli_query($db,"INSERT INTO temp (nama,nilai) 
    values(
      '$jkt',
      '1')");



//perulangan untuk menampilkan gejala yang di pilih pada form diagnosa
for ($i=0; $i <count($gejalaygdipilih) ; $i++) { 
  unset($nilai);
  unset($kata);
  ?>          
<table >
        <thead>
          <tr>
              <th ><?php
        //guery untuk menampilkan kombinasi penyakit
        $sql2=mysqli_query($db,"select * from rule where nogejala='$gejalaygdipilih[$i]' ");
        while($rs2=mysqli_fetch_array($sql2))
    { $namapenyakit[]=$rs2[nopenyakit];

}

              //query untuk menampilkan  nama gejala
        $sql1=mysqli_query($db,"select * from gejala where no='$gejalaygdipilih[$i]' ");
        $rs1=mysqli_fetch_array($sql1);


             echo$rs1[gejala]." { ".implode(", ", $namapenyakit). " }";?></th>
          </tr>
        </thead>

        <tbody>
          <tr>
              <th >#</th>
              <th ><?php //menyatakan gejala penyakit yang dipilih dan nilai densitas nya
             echo implode(",", $namapenyakit)." = ".$rs1[ds];  ?></th>
              <th ><?php $pl=1-$rs1[ds];  echo "ø = ". $pl; ?></th>
          </tr>

<?php 
 $sql3=mysqli_query($db,"select * from temp  ");
        while($rs3=mysqli_fetch_array($sql3))
    { 
      //inisialisasi data temp dari database menjadi variabel
      $value=$rs3[nama];
      $key=$rs3[nilai];?>
          <tr>
              <th ><?php echo $rs3[nama]." = ".$rs3[nilai]; ?></th>
              <td ><?php 
                //$value dan $value2 merupakan string yang akan di cari irisan nya
            
                $value2=implode("", $namapenyakit);
                  // perintah irisan antar 2 kombinasi 
                for ($e=0; $e <strlen($value) ; $e++) { 
                  for ($f=0; $f <strlen($value2) ; $f++) { 
                    if ($value[$e]==$value2[$f]) {
                      $komb[]=$value[$e];
                      
                    }
                  }
                }

            echo implode("", $komb);
            $kata[]=implode("", $komb);
            echo " = ";
            echo $rs1[ds]*$key;
            $nilai[]=$rs1[ds]*$key;
            unset($komb); 
            ?></td>
              <td ><?php
            echo $value;
            $kata[]=$value;
            echo" = ";
            echo$pl*$key;
            $nilai[]=$pl*$key;
            ?></td>
          </tr>
<?php }?>



     </tbody>
      </table>
</br>==================================================================================================</br>

      <?php //menyimpan hasil perkalian ke dalam array sekaligus menjumlahkan jika ada value yang sama
      for ($k=0; $k < count($kata) ; $k++) { 
        for ($l=$k+1; $l <count($kata) ; $l++) { 
          if ($kata[$k]==$kata[$l]) {
            $nilai[$k]=$nilai[$k]+$nilai[$l];
            unset($nilai[$l]);
            
          }
        } 
      }
$nilai=array_values($nilai);
      $kata=array_values(array_unique($kata));
      
//$kata=array_unique($kata);
//$nilai=array_values($nilai);      
//echo implode(" | ", $nilai);
//echo"</br>";
//echo implode(" | ", $kata);
for ($p=0; $p < count($kata) ; $p++) { 
  echo"</br>";
  echo "Nilai ".$kata[$p]." => ".$nilai[$p];}



// menentukan faktor pembagi pada rumus Dempster Shafer

for ($t=0; $t < count($kata) ; $t++) { 
  if ($kata[$t]=="") {
    $tou=$nilai[$t];
    unset($nilai[$t]);
  }
}
if (is_null($tou)) {
  $tou=0  ;
}
$xy=1-$tou;
echo "</br>Nilai Pembagi = ".$xy;



for ($m=0; $m < count($kata); $m++) { 
 
 $kata1=$kata[$m];
 $nilai1=$nilai[$m]/$xy;
  if ($kata[$m]=="") {
  }
  else{
$proses=mysqli_query($db,"INSERT INTO temp (nama,nilai) 
    values(
      '$kata1',
      '$nilai1')");
mysqli_query($db," UPDATE temp SET nilai='$nilai1'where nama ='$kata1'");

}

  
}


      unset($namapenyakit);
unset($irisannama);
}
unset($nilai);
unset($kata);

// hasil diagnosa
$sqlq=mysqli_query($db,"SELECT * FROM temp ORDER BY nilai DESC ");
$rsq=mysqli_fetch_array($sqlq);
    
      $sqlqq=mysqli_query($db,"SELECT * FROM penyakit where kode_hama='$rsq[nama]'");
      $rsqq=mysqli_fetch_array($sqlqq);

      $sqla=mysqli_query($db,"SELECT * FROM solusi where kode_hamapenyakit='$rsq[nama]'");
      $rsqa=mysqli_fetch_array($sqla);
echo "</br>";
echo "</br>";
echo "</br>==================================================================================================</br>";
echo "<h4>Diagnosa</h4>";
echo "==================================================================================================</br>";
      echo "</br>";
      echo "Dari Hasil Diagnosa Tanaman Duku Anda Terserang  Penyakit :";
      echo "</br>";
      $persen=100*$rsq[nilai];
      echo $rsqq[hama_penyakit]." dengan persentase <h5><strong>".$persen." % </strong></h5>";

echo "</br>==================================================================================================</br>";
echo "<h4>Solusi</h4>";
echo "==================================================================================================</br>";
      echo"".$rsqa[Solusi]."";
 }       
?>
