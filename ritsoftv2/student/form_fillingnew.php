<?php
include("includes/header.php");
include("includes/sidenav.php");
include("../connection.php");


if ($_POST) { 

	$_SESSION['POST'] =  $_POST; 
	echo "<script type='text/javascript'>location.href='".$_SERVER['REQUEST_URI']."'</script>";
	exit();
}
if (isset($_SESSION ['POST'])) {
	$_POST = $_SESSION['POST'];
	unset($_SESSION['POST']);
}



?>

<?php

if( !isset($_POST['admission_no']) || ! isset($_POST['class_id']) ) {
	echo "<script>window.location.href='semregpostnew.php'</script>";
	exit();
}
$admissionno = $_POST['admission_no'];
$classid = $_POST['class_id'];


$showButton = false;


$l=mysql_query("select * from stud_sem_registration where adm_no='$admissionno'") or die(mysql_error());
if(mysql_num_rows($l) > 0)
	if( !isset($_POST['Re-Submit']) &&  !isset($_POST['Re-print'])) 
		echo "<script>window.location.href='semregviewnew.php'</script>";
	else{

	}  

	$form_data = '';
	$status = '';
	$statusl = '';

	if(isset($_POST['Re-print'])) {
		$lsd=mysql_query("select * from stud_sem_registration where adm_no='$admissionno'") or die(mysql_error());
		while($dat3=mysql_fetch_array($lsd)) 	{ 
			$form_data =$dat3["form_data"];
			$status =$dat3["apv_status"];
			$statusl =$dat3["apl_status"];
		}

		// if($status != 'Not Approved' ) { 
		if($statusl != 'Applied' || ( $status != 'Not Approved' && $status != 'Rejected by office' && $status != 'Rejected by HOD' && $status != 'Approved by staff advisor' )) { 

			// echo "

			// <div style='width:100%; text-align:center;'>
			// $statusl <br>
			// $status
			// </div>
			// ";
			echo "<script>window.location.href='semregviewnew.php'</script>";
			exit();
		}
	}
	function parse($text) {
    // Damn pesky carriage returns...
		$text = str_replace("\r\n", "\n", $text);
		$text = str_replace("\r", "\n", $text);

    // JSON requires new line characters be escaped
		$text = str_replace("\n", "\\n", $text);
		return $text;
	}


	// if($status == 'Not Approved' && !is_null($form_data) && !empty($form_data)) { 
	if(( $statusl == 'Applied' && ( $status == 'Not Approved' || $status == 'Rejected by office' || $status == 'Rejected by HOD' || $status == 'Approved by staff advisor' )) && !is_null($form_data) && !empty($form_data)) { 
		try { 

			$json = json_decode(parse($form_data), true);
			


			include 'Mobile_Detect.php';
			$detect = new Mobile_Detect();

			?>



			<?php if ($detect->isMobile() ) :?>




				<div id="page-wrapper">
					<div class="col-lg-12">
						<h1 class="page-header text-center" style="text-transform: uppercase;"><b>download form</b>  <small>  </small></h1>
					</div>
					<div class="text-center" style="margin: 3rem ;">
						<form id="myForm" action="sem_reg_from_mobilenew.php"  class="fomr "   method="post">
							<?php
							foreach ($json as $a => $b) {
								echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
							}

							$showButton = true;

							?>


							<div class="form-group ">
								<div class="button-group">
									<a class="btn btn-lg btn-warning" style="margin-right: 1rem;" href="semregviewnew.php" type="subject">view status</a>
									<button class="btn btn-lg btn-success" type="subject">download</button>
								</div>

							</div>
						</form>
					</div>
				</div>

				<?php else: ?> 


					<form id="myForm" action="sem_reg_fromnew.php"    method="post">
						<?php

						if($json)
							foreach ($json as $a => $b) {
								echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
							}
							?>
						</form>
						<script type="text/javascript">
							alert(' you must make sure that the document is saved, it is only generated once !! ');

    // $("form").attr('target', '_blank');
    document.getElementById('myForm').submit();
</script>

<?php endif; ?> 

<?php


} catch (Exception $e) {

}
exit();
}

$sem = 0;

$l=mysql_query("select classid from current_class_semreg where studid='$admissionno'") or die(mysql_error());
if(mysql_num_rows($l)>0)
{
	$r=mysql_fetch_assoc($l);
	$classid=$r["classid"];
	$l=mysql_query("select semid,courseid,branch_or_specialisation from class_details where classid='$classid'") or die(mysql_error());
	$r=mysql_fetch_assoc($l);
	$semid=$r["semid"];
	$courseid=$r["courseid"];
	$branch=$r["branch_or_specialisation"];

	$newsemid=$semid+1;

	$l=mysql_query("select * from semregstatus where status=1 and curr_sem='$classid'") or die(mysql_error());

	if (mysql_num_rows($l)==0) {
		echo "<script>alert('semester registration unavailable')</script>"; 
		echo "<script>window.location.href='dash_home.php'</script>"; 
	}
}
$result=mysql_query("select semid from class_details where classid =(select classid from current_class_semreg where studid = '$admissionno' )");
while($dat1=mysql_fetch_array($result))
{
	$sem=$dat1["semid"];
   // $scourse=$dat["courseid"];

}
$re=mysql_query("select * from current_class_semreg where studid = '$admissionno' ");
while($dat2=mysql_fetch_array($re))
{
	$classid=$dat2["classid"];
   // $scourse=$dat["courseid"];

}

//while($data=mysql_fetch_array($result))
//{   
//$cur_sem=$data["cur_sem"];

$re=mysql_query(" SELECT sd.* , cc.rollno AS rollnoOR FROM stud_details sd LEFT JOIN current_class_semreg cc ON cc.studid = sd.admissionno WHERE sd.admissionno =  '$admissionno' ");
$name = '';
$year_of_admission = '';
$branch = '';
$promotion_class = $sem+1;
$last_class = $sem;
$discontinued_and_reason = ''; //Period during which the study in the college was discontinued and reason there of
$registered_for_pre_semester  = '';//Whether registered for pre-semester 
$subject_to_pass = '';// The subject in which you have to pass in respect of previous class
$fees_paid = '';// Whether fees has been paid for all instalments of previous semsters 
$eligible_fee_concession = '';//Whether eligible for fee concession if so with nature of concession 
$shortage_of_attendance = '';//Whether there was any shortage of attendance for any of the previous semester and whether condonation has been obtained 
$Present_residential_address  = '' ;//Present residential address for correspondence and phone no. 
$place = '';
$phone = '';
$rollno = '';
while($dat2=mysql_fetch_array($re)) {
	// print_r($dat2);
	$name = $dat2['name'];




	$Present_residential_address =  $dat2['address'];
	$rollno = $dat2['rollnoOR'];
	$phone = $dat2['mobile_phno'];

	$branch = $dat2['branch_or_specialisation'];
	$year_of_admission = $dat2['year_of_admission'];

}


?>
<style type="text/css">
#page-wrapper {
	display: flow-root;
	padding-bottom: 3pc;
}
.text-capitalize {
	text-transform: capitalize;
}
</style>


<div id="page-wrapper">
	<div class="col-lg-12">
		<h1 class="page-header"><b>SEMESTER REGISTRATION</b>  <small>  Form Filling</small></h1>
	</div>
	<!-- registration -->
	<form id="form1" name="form1" method="post" action="registrationnew.php" enctype="multipart/form-data" class="sear_frm" >
		<input type="hidden" class="form-control" id="class_id" name="class_id"  value="<?php echo $classid; ?>">
		<input type="hidden" class="form-control" id="branch" name="branch"  value="<?php echo $branch; ?>">
		<?php 	if(isset($_POST['Re-print'])): ?> 
			<input type="hidden" class="form-control" id="branch" name="Re-print"  value="1">
		<?php 	 endif; ?>
		<div class="row">
			<div class="form-group col-md-4">
				<label for="religion">Name</label>
				<input type="text" class="form-control" disabled="disabled"  name="name"  value="<?php echo $name; ?>"> 
				<input type="hidden" class="form-control"   name="name"  value="<?php echo $name; ?>"> 
			</div>
			<div class="form-group col-md-4">
				<label for="religion">Admission no</label>
				<input type="text" class="form-control" disabled="disabled"  name="admission_no"  value="<?php echo $admissionno; ?>"> 
				<input type="hidden" class="form-control"  name="admission_no"  value="<?php echo $admissionno; ?>"> 
			</div>
			<div class="form-group col-md-4">
				<label for="religion">Branch or Specialisation</label>
				<input type="text" class="form-control" disabled="disabled"  name="branch"  value="<?php echo $branch; ?>"> 
				<input type="hidden" class="form-control"   name="branch"  value="<?php echo $branch; ?>"> 
			</div>
		</div>


		<div class="row">
			<div class="form-group col-md-3">
				<label for="caste">Year of Admission</label>
				<input class="form-control" disabled="disabled" type="text" name="year_of_admission" value="<?php echo $year_of_admission; ?>">
				<input class="form-control" type="hidden" name="year_of_admission" value="<?php echo $year_of_admission; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="caste">Previous semester</label>
				<input class="form-control" disabled="disabled" type="text" name="last_class" value="<?php echo $last_class; ?>">
				<input class="form-control" type="hidden" name="last_class" value="<?php echo $last_class; ?>">
			</div>
			<div class="form-group col-md-3">
				<label for="caste">New semester</label>
				<input class="form-control" disabled="disabled" type="text" name="promotion_class" value="<?php echo $promotion_class; ?>">
				<input class="form-control" type="hidden" name="promotion_class" value="<?php echo $promotion_class; ?>">
			</div> 

			<div class="form-group col-md-3">
				<label for="caste">Previous Class Rollno</label>
				<input class="form-control" required type="text" name="rollno" value="<?php echo $rollno; ?>"> 
			</div>

		</div>




		<div class="row">
			<div class="form-group col-md-12">
				<label for="caste text-capitalize" 
				title="Period during which the study in the college was discontinued and reason there of">Discontinued and Reason</label>
				<br>
				<small>Period during which the study in the college was discontinued and reason there of</small>
				<textarea  style="min-height: 100px;" class="form-control"  name="discontinued_and_reason" placeholder="Period during which the study in the college was discontinued and reason there of" required maxlength="190"></textarea> 
			</div>
		</div>


		<div class="row">
			<div class="form-group col-md-12">
				<div class="col-md-7">
					<label for=" caste text-capitalize" 
					title="Whether registered for pre-semester ">Whether registered for pre-semester</label>		
					<br>
					<small>Whether registered for pre-semester</small>		
				</div>
				<div class="col-md-5">
					<div class="  form-control">
						<input type="radio" name="registered_for_pre_semester" value="Yes" required > Yes 
						<input style="margin-left: 20%;" type="radio" name="registered_for_pre_semester" value="No" required > No 
						<input style="margin-left: 20%;" type="radio" name="registered_for_pre_semester" value="NA" required > Not Applicable 

					</div>
				</div>
				<!-- <template  class="form-control"  name="registered_for_pre_semester" placeholder="Whether registered for pre-semester "></template>  -->
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">
				<label for="caste text-capitalize" 
				title="The subject in which you have to pass in respect of previous class">Subject in which you have to pass</label>
				<br>
				<small>The subject in which you have to pass in respect of previous class</small>
				<textarea  style="min-height: 100px;" class="form-control"  name="subject_to_pass" placeholder="The subject in which you have to pass in respect of previous class" required   maxlength="190"></textarea> 
			</div>
		</div>




		<div class="row" style="margin-top: 1pc;">
			<div class="form-group col-md-12">
				<div class="col-md-7">
					<label for=" caste text-capitalize" 
					title="Whether fees has been paid for all instalments of previous semsters">Fees has been paid </label>		
					<br>
					<small>Whether fees has been paid for all instalments of previous semsters</small>		
				</div>
				<div class="col-md-5">
					<div class="  form-control">
						<input type="radio" name="fees_paid" value="Yes" required > Yes 
						<input style="margin-left: 20%;" type="radio" name="fees_paid" value="No" required > No 						
						<input style="margin-left: 20%;" type="radio" name="fees_paid" value="NA" required > Not Applicable 
					</div>
				</div> 
			</div>
		</div>
		<strong style="width: 100%; text-align: center; font-size: 1pc;"> OR</strong>
		<div class="row">
			<div class="form-group col-md-12">
				<div class="col-md-7">
					<label for=" caste text-capitalize" 
					title="Whether eligible for fee concession if so with nature of concession  ">Eligible for Fee Concession</label>	
					<br>
					<small>Whether eligible for fee concession if so with nature of concession </small>			
				</div>
				<div class="col-md-5">
					<div class="  form-control">
						<input type="radio" name="eligible_fee_concession" value="Yes" required > Yes 
						<input style="margin-left: 20%;" type="radio" name="eligible_fee_concession" value="No" required > No 		
						<input style="margin-left: 20%;" type="radio" name="eligible_fee_concession" value="NA" required > Not Applicable 
					</div>
				</div> 
			</div>
		</div>




		<div class="row" style="margin-top: 1pc;">
			<div class="form-group col-md-12">
				<div class="col-md-7">
					<label for=" caste text-capitalize" 
					title="Whether there was any shortage of attendance for any of the previous semester and whether condonation has been obtained">shortage of attendance for any of the previous semester </label>		
					<br>
					<small>Whether there was any shortage of attendance for any of the previous semester and whether condonation has been obtained</small>		
				</div>
				<div class="col-md-5">
					<div class="  form-control">
						<input type="radio" name="shortage_of_attendance" value="Yes" required> Yes 
						<input style="margin-left: 20%;" type="radio" name="shortage_of_attendance" value="No" required> No 
						<input style="margin-left: 20%;" type="radio" name="shortage_of_attendance" value="NA" required > Not Applicable 
					</div>
				</div> 
			</div>
		</div>



		<br>
		<br>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="caste text-capitalize" 
				title="Present residential address for correspondence">Present residential address </label>
				<br>
				<small>Present residential address for correspondence</small>
				<textarea  style="min-height: 100px;" class="form-control"  name="Present_residential_address" placeholder="Present residential address for correspondence" required  maxlength="190"></textarea> 
			</div>
			<div class="form-group col-md-6">
				<label for="caste text-capitalize" 
				title="phone no">phone no </label>
				<br> 
				<small>phone no </small>
				<input type="number" minlength="10" maxlength="15" class="form-control"  class="form-control"  name="phone"  value="<?php echo $phone; ?>" required>   
			</div>
		</div>
		<br>



		<div class="row">
			<div class="form-group col-md-6">
				<label for="caste">Place</label>
				<input class="form-control" type="text" name="place" value="<?php echo $place; ?>" required>
			</div>
			<div class="form-group col-md-6">
				<label for="caste">Application Date</label>
				<input class="form-control" type="text" name="date" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" required> 
			</div>
		</div>

		<div class="row">
			<br>
			<br> 
			<div class="col-sm-offset-4 col-sm-4">
				<?php if (!isset($_POST['Re-Submit']) && !isset($_POST['Re-print'])) {?>
					<button type="submit" value="" name="semreg_btn" id="semreg_btn" class="btn btn-primary btn-block" >Submit</button>
					<?php }else { ?>
						<button type="submit" value="re" name="re_semreg_btn" id="re_semreg_btn" class="btn btn-primary btn-block" onclick="return confirm('Did you cleared all remarks?')" >Submit</button>
					<?php }?>
				</div>
			</div>         


		</form> 
	</div>















	<?php

	include("includes/footer.php");
	?>
