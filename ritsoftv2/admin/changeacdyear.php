<?php
include("includes/header.php");
include("includes/sidenav.php");
?>
<?php


if (isset($_POST["change"])) {
	$acd_year=$_POST["acd"];
	$l=mysql_query("select * from academic_year where acd_year='$acd_year'") or die(mysql_error());
	if(mysql_num_rows($l)==0)
		{mysql_query("insert into academic_year values('$acd_year',1)") or die(mysql_error());}
	
	else
	{
	mysql_query("update academic_year set status=1 where acd_year='$acd_year'") or die(mysql_error());
	}
	mysql_query("update academic_year set status=0 where acd_year!='$acd_year'") or die(mysql_error());
}
?>

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Academic Year Setting</h2>
                    </div>
				</div>

			</div>

<?php
/*$y=date('Y')+1;
$s=2010;
while ($s<$y) {
	$a=$s.'-'.($s+1);
	$l=mysql_query("select * from academic_year where acd_year='$a'") or die(mysql_error());
	if(mysql_num_rows($l)==0)
		mysql_query("insert into academic_year values('$a',0)") or die(mysql_error());
	$s++;
}
*/

?>
<form method="post">

<div class="row">
	<div class="col-md-6">
		<label>Current Academic Year :</label>
		
		<?php $l=mysql_query("select acd_year from academic_year where status in (1)");
                      $r=mysql_fetch_assoc($l);
                      $ac=$r['acd_year'];
                     echo $ac;
                      
                      ?>
		
		<div>
		<div>
		<br><br>
<div class="row">
	<div class="col-md-6">
		<label>Change Academic Year</label>
		<select class="form-control" name="acd">
			<option value="">--select--</option>
			<?php
			$start=date('Y');
			
			$end=$start+1;
			$newacdyear=$start."-".$end;
			
				$l=mysql_query("select * from academic_year") or die(mysql_error());
				while ($r=mysql_fetch_assoc($l)) {
					if($r["status"]==1)
					
				        //echo '<option selected value="'.$newacdyear.'">'.$newacdyear.'</option>';
                                       echo '<option selected value="'.$r["acd_year"].'">'.$r["acd_year"].'</option>';


					else
						echo '<option  value="'.$r["acd_year"].'">'.$r["acd_year"].'</option>';
				}
			?>
		</select>
	</div>
</div>
<br>

<div class="row">
<div class="col-sm-4">
	
</div>

<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block" value="Change" name="change">
</div>
</div>

</form>

</div>


<?php
include("includes/footer.php");
?>  
