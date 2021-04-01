 <form method="post" action="index.php?content=hasil">
    <h5>Pilih Gejala</h5>


        <?php 
$no=1;
$sql=mysqli_query($db,"select * from gejala ");
while($rs=mysqli_fetch_array($sql))
    {
?>
    <p>
       <input type="checkbox" class="filled-in" id="<?php echo $no;?>" name="<?php echo $no;?>" value="<?php echo $rs[no];?>" />
      <label for="<?php echo $no;?>"><b><?php echo $rs[gejala];?></b></label>
    </p>
  <?php $no=$no+1; } 

  ?>

<button type="submit" class="btn btn-default">Diagnosa</button>                  
</form>