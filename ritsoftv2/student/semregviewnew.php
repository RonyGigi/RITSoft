<?php
include("includes/header.php");
include("includes/sidenav.php");
include("../connection.php");
$admissionno=$_SESSION["admissionno"];

$l=mysql_query("select * from stud_sem_registration where adm_no='$admissionno'") or die(mysql_error());
if(mysql_num_rows($l) == 0)
	echo "<script>window.location.href='semregpostnew.php'</script>";
if(isset($_POST["submit"]))
{
	mysql_query("update stud_sem_registration set apv_status='Not Approved' where adm_no='$admissionno'") or die(mysql_error());
	echo "<script>alert('Re-submitted Successfully')</script>";
}

?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<marquee scrolldelay="5"><h1 class="page-header"><b>REGISTRATION STATUS </b></h1></marquee>
		</div>
	</div>
	<?php 
	$query="select distinct(name),admissionno,courseid from stud_details join current_class_semreg where admissionno='$admissionno'";	
	$res=mysql_query($query);
	$row =mysql_fetch_assoc($res);
	$result=mysql_query("select semid from class_details where classid =(select classid from current_class_semreg where studid = '$admissionno' )");

	$adm_status = '';
	$classid = null;
	while($dat1=mysql_fetch_array($result)) 	{
		$sem=$dat1["semid"];
					// $scourse=$dat["courseid"]; 
		$re=mysql_query("select * from current_class_semreg where studid = '$admissionno' ");
		while($dat2=mysql_fetch_array($re))
		{
			$classid=$dat2["classid"];
						// $scourse=$dat["courseid"];
			$adm_status = $dat2["adm_status"];

		}
	}
	$quer="select * from stud_sem_registration where adm_no ='$admissionno'";
	$l=mysql_query($quer);
	$r=mysql_fetch_assoc($l);


	?>
	<form method="post" action="form_fillingnew.php">
		<div class="table-responsive">
			<table   class="table table-hover table-bordered" border="4">
				<tr>
					<th style="text-align: center;"> NAME<?php echo '<td style="text-align: center;">'.$row['name'].'</td>'?></th>
				</tr>
				<tr>
					<th style="text-align: center;"> ADMISSION NUMBER<?php echo '<td style="text-align: center;">'.$row['admissionno'].'</td>'?></th>
				</tr>
				<tr>
					<th style="text-align: center;"> COURSE<?php echo '<td style="text-align: center;">'.$row['courseid'].'</td>'?></th>
				</tr>
				<tr>
					<th style="text-align: center;">PREVIOUS SEMESTER<td style="text-align: center;"><?php echo $sem; ?></td></th>
				</tr>
				<tr>
					<th style="text-align: center;">NEW SEMESTER<td style="text-align: center;"><?php echo $sem+1; ?></td></th>
				</tr>
				<tr>
					<th style="text-align: center;">APPLICATION DATE<td style="text-align: center;"><?php echo date("Y-m-d"); ?></td></th>
				</tr>
				<tr>

					<th style="text-align: center;">APPLIED STATUS <td style="text-align: center;"><?php echo $r["apl_status"];?>

					

				</td></th>
			</tr>

			<tr style="text-transform: uppercase;">

				<th style="text-align: center;">APPROVED STATUS <td style="text-align: center;"><p style=" <?php 
				if($r["apv_status"]=="Rejected by staff advisor"  && $r["apl_status"]=="Applied")
					{ echo " color: red;background: rgba(255, 0, 0, 0.08);padding: 0.21pc; ";
			} 
			?>"> <?php echo $r["apv_status"];?>

			<?php 
			if ($r["apv_status"] == 'Approved by office' && $adm_status != '' && ! is_null($adm_status)) {
				echo "<sub style='padding: 0 0.5rem;' class='text-primary'> $adm_status</sub>";
			}

			?>

		</p></td></th>
	</tr>
	<?php
	if($r["apv_status"]=="Rejected by staff advisor" && $r["apl_status"]=="Applied")
	{
		?>
		<tr>

			<th style="text-align: center;">REMARKS<td style="text-align: center;"><?php echo $r["remarks"];?></td></th>
		</tr>
		<tr>

			<input type="hidden" class="form-control" id="class_id" name="class_id"  value="<?php echo $classid; ?>">

			<input type="hidden" class="form-control"  name="admission_no"  value="<?php echo $admissionno; ?>"> 


			<input type="hidden" name="Re-Submit" value="true">
			<th style="text-align: center;"><td style="text-align: center;"><input type="submit" name="submit" class="btn btn-primary" value="Re-Submit"></td></th>
		</tr>

		<?
	}
	?>

	<?php
			// if($r["apv_status"]=="Not Approved" && $r["apl_status"]=="Applied")
	$status = $r["apv_status"];
	if($r["apl_status"]=="Applied" && ( $status == 'Not Approved' || $status == 'Rejected by office' || $status == 'Rejected by HOD' || $status == 'Approved by staff advisor' ) && $status != "Rejected by staff advisor" )
	{
		?> 
		<tr>

			<input type="hidden" class="form-control" id="class_id" name="class_id"  value="<?php echo $classid; ?>">

			<input type="hidden" class="form-control"  name="admission_no"  value="<?php echo $admissionno; ?>"> 


			<input type="hidden" name="Re-print" value="true">
			<th style="text-align: center;"><td style="text-align: center;"><input type="submit" name="submit" class="btn btn-primary" value="Re Print"></td></th>
		</tr>

		<?
	}
	?>



</table>
</form>	
</div>		
<?php

include("includes/footer.php");
?>
