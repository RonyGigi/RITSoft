<?php
/**
 * @Author: indran
 * @Date:   2018-11-05 14:02:41
 * @Last Modified by:   indran
 * @Last Modified time: 2018-11-30 15:48:42
 */
include("includes/header.php");
include("includes/sidenav.php");
include("../connection.php");
$count=0;

$classid=$_SESSION["classid"]; 
$username=$_SESSION['fid']; 

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


if (isset($_POST['action-bk'])) {
	
	var_dump($_POST);

}


?>









<?php


if (isset($_POST['action-reject'])) { 
	$subjectid = $_POST['selected_subject'];

	$query =" UPDATE sessional_status SET verification_status = -1 WHERE subjectid ='$subjectid'  AND classid = '$classid' "; 
	$es=mysql_query($query) ;  
	if($es) {
		$query =" UPDATE sessional_marks SET verification_status = -1 WHERE subjectid ='$subjectid'  AND classid = '$classid' "; 
		$es=mysql_query($query) ;  
	}


}

?>

<?php


if (isset($_POST['action-verify'])) { 
	$subjectid = $_POST['selected_subject'];

	$query =" UPDATE sessional_status SET verification_status = 1 WHERE subjectid ='$subjectid'  AND classid = '$classid' "; 
	$es=mysql_query($query) ;  
	if($es) {
		$query =" UPDATE sessional_marks SET verification_status = 1 WHERE subjectid ='$subjectid'  AND classid = '$classid' "; 
		$es=mysql_query($query) ;  
	}


}

?>



<?php


if (isset($_POST['action-s-reject'])) { 
	$subjectid = $_POST['selected_subject'];
	$studid = $_POST['studid'];


	// $query =" UPDATE sessional_status SET verification_status = -1 WHERE subjectid ='$subjectid'  AND classid = '$classid' "; 
	// $es=mysql_query($query) ;  
	// if($es) {
	$query =" UPDATE sessional_marks SET verification_status = -1 WHERE subjectid ='$subjectid' AND studid = '$studid'   AND classid = '$classid' "; 
	$es=mysql_query($query) ;  
	// }
	


}

if (isset($_POST['action-s-verify'])) { 
	$subjectid = $_POST['selected_subject'];
	$studid = $_POST['studid'];


	$query =" UPDATE sessional_marks SET verification_status = 1 WHERE subjectid ='$subjectid' AND studid = '$studid'    AND classid = '$classid' "; 
	$es=mysql_query($query) ;  


}

?>
<!-- 

-->

<div id="page-wrapper">

	<div class="row">
		<div class="col-lg-12" >
			<h1 class="page-header">SESSIONAL MARK OF 
				<?php
				$r=mysql_query("select courseid,semid from class_details where classid='$classid'");
				while($d=mysql_fetch_array($r))
				{
					$co=$d["courseid"];
					$sem=$d["semid"];
				}
                        //echo $co;
				?>       
				SEMESTER
				<?php
				echo $sem;
				?>       
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>




	<div class="contact-grids" align="center" style="padding: 1rem 0;">
		<div class="row">
			<div class="col-sm-12">
				<form class="form" method="post" action="">
					<div class="form-group">
						<div class="col-sm-12 col-md-2">
							<label class="form-lable">Subject :</label>
						</div>
						<div class="col-sm-12 col-md-5">
							<select class="form-control" name="selected_subject" style="width: auto;" onChange="this.form.submit();">
								<option selected disabled>Select Subject</option>
								<?php 


								// $c=mysqli_query($con3,"SELECT * FROM subject_allocation s,subject_class c where c.classid='$classid' and s.subjectid=c.subjectid and s.fid='$username' and s.type='main'");



								// $re=mysql_query("SELECT * FROM `subject_class` s LEFT JOIN subject_allocation a ON s.subjectid = a.subjectid  where s.classid='$classid'  ");
								// $re=mysql_query("SELECT * FROM subject_allocation s,subject_class c where c.classid='$classid' and s.subjectid=c.subjectid and s.fid='$username' and s.type='main'");
								// $re=mysql_query("SELECT * FROM subject_allocation s,subject_class c where c.classid='$classid' and s.subjectid=c.subjectid and s.fid='$username'  
								// 	");	
								$re=mysql_query(" SELECT * FROM  subject_class  WHERE classid ='$classid'  ");

								// 'PG29'



								?>
								<?php while($d=mysql_fetch_array($re)): ?>
									<?php 
									$subid = $d['subjectid'];
									$sujectname =  $d['subject_title']."-".$d['type'];;

									$selectedMe = "";
									if(isset($_POST['selected_subject']))
										if($_POST['selected_subject'] == $subid )
											$selectedMe = "  selected ";


										echo "<option value='$subid'   $selectedMe>$sujectname</option>";
										?>
									<?php endwhile;  ?>


								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php if(isset($_POST['selected_subject'])): ?>





			<?php 
			$tdeda = false;
			$sessional_status = "";
			$sessional_remark = "";
			$verification_status = 0;
			$verification_status_b = 0;

			$subjectid  = $_POST['selected_subject'];


			$res=mysql_query("SELECT * FROM sessional_status  where classid='".$classid."' and  subjectid='".$subjectid."'  order BY  sessional_date DESC LIMIT 1");


			if(mysql_num_rows($res)>0){

				while($rs=mysql_fetch_array($res)) { 

					$sessional_status = $rs['sessional_status'];
					$sessional_remark = $rs['sessional_remark'];
					$verification_status_b = $rs['verification_status'];
					$tdeda = true;

				}

			}







			?>


		<!-- 	<div class="table-responsive">
				<table width="50%"  class="table table-hover table-bordered">
					<tr>
						<td></td>
						<td></td>
					</tr>

				</table>

			</div> -->





			<?php if($tdeda): ?>
				<div class="row" style="margin: 1rem 0; padding: 1rem; border: 2px solid #ddd; ">

					<div class=" col-sm-12    text-center">



						<?php 

						$dis_option = "";


						?>

						<div class="form-inline row"  style="text-align: center; margin: 1rem 0 ;">
							<?php if( $verification_status_b == 0): ?>
								<div class="form-group col-sm-12  ">

									<p style=" color: blue; text-transform: uppercase; border: 1px solid; padding: 0.4rem 0; "><label for="sessional_status">Status:</label> 
										: <span> verify for publish result  </span>
									</p>
									<?php 
									$dis_option  = " disabled='disabled' "; ?>
								</div>
								<?php elseif( $verification_status_b == -1 ):  ?>
									<div class="form-group col-sm-12  ">

										<p style=" color: red; text-transform: uppercase; border: 1px solid; padding: 0.4rem 0; "><label for="sessional_status">Status:</label> 
											: <span> sessional marks rejected </span>
										</p>

									</div>
									<div class="form-group col-sm-12  ">
									</div>  
									<?php elseif( $verification_status_b == 1   ):  ?>
										<div class="form-group col-sm-12  ">

											<p style=" color: green; text-transform: uppercase; border: 1px solid; padding: 0.4rem 0; "><label for="sessional_status">Status:</label> 
												: <span> <?php echo $sessional_status;  ?> sessional marks published  </span>
											</p>



										</div>  
										<?php elseif( $verification_status_b == 2  ):  ?>
											<div class="form-group col-sm-12  ">

												<p style=" color: orange; text-transform: uppercase; border: 1px solid; padding: 0.4rem 0; "><label for="sessional_status">Status:</label> 
													: <span> <?php echo $sessional_status;  ?> sessional marks changed  </span>
												</p>



											</div>  
											<?php else: ?>
												<div class="form-group col-sm-12  ">

													<p style=" color: green; text-transform: uppercase; border: 1px solid; padding: 0.4rem 0; "><label for="sessional_status">Status:</label> 
														: <span> <?php echo $sessional_status;  ?> sessional marks published  </span>
													</p>

												</div>

											<?php endif; ?>

										</div>



										<div class="row">


											<form method="post" action="">		


												<div class="form-inline row"  style="text-align: left;">
													<div class="form-group col-sm-3">
														<label for="sessional_status">Status:</label> 
														<br>

														<p class="form-control" style="width: 100%;  font-weight: 800; text-transform: uppercase;    <?php if($sessional_status == 'draft'){ echo " color: green;"; }else{ echo " color: blue;";}  ?>">
															<?php echo $sessional_status; ?>
														</p>
													</div>
													<div class="form-group col-sm-9">
														<label for="sessional_remark" >Remark:</label>
														<br>

														<p class="form-control" style="width: 100%;">
															<?php echo  $sessional_remark; ?>
														</p>

													</div>  


												</div>	
											</form>



											<div class="form" style="margin-top: 1rem;">		

												<!-- <input type="hidden" value="<?php echo $_POST['class']; ?>" name="class"/>
													<input type="hidden" value="<?php echo $_POST['sub']; ?>" name="sub"/> -->
													<input type="hidden" name="btnshow" value="true">

													<div class="form-inline row"  style="text-align: left;">
														<?php if( $verification_status_b == 0): ?>
															<div class="form-group col-sm-3">
																<form method="post" action=""> 
																	<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
																	<button name="action-reject" class="btn btn- btn-danger btn-block" style="text-transform: uppercase;">reject All</button>  
																</form> 
																<br>  
															</div>
														<?php endif; ?>


														<?php if( $verification_status_b == 0): ?>


															<?php 
															$res=mysql_query("SELECT * FROM sessional_marks  where classid='".$classid."' and  subjectid='".$subjectid."'  AND verification_status = -1 ");


															if(mysql_num_rows($res)==0){

																?>

																<div class="form-group col-sm-3">
																	<form method="post" action=""   <?php  if($sessional_status == 'final'   ) { ?>

																		onsubmit = "return confirm('Do you really want to publish the mark?');" 

																	<?php }
																	?> > 
																	<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
																	<button name="action-verify" class="btn btn- btn-success btn-block" style="text-transform: uppercase;">Verify All</button>  
																</form> 
																<br>  
															</div>

														<?php } ?>

													<?php endif; ?>

													<?php  if($sessional_status == 'final' && $verification_status_b == 1 ) :?>

														<div class="form-group col-sm-6">
															<form method="post" action=""  onsubmit = "return confirm('Do you really want to reject the published marks?' );"    > 
																<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
																<button name="action-reject" class="btn btn- btn-danger btn-block" style="text-transform: uppercase;">reject final sessional mark</button>  
															</form> 
															<br>  
														</div>
														<?php else:?>
															<div class="form-group col-sm-3">
																<form method="post" action=""      > 
																	<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
																	<button name="ac" class="btn btn- btn-info btn-block" id="doProcessnOwbulk" style="text-transform: uppercase;"> bulk action </button>  
																</form> 
																<br>  
															</div>

														<?php endif;?>

													</div>	



												</div>



											</div>






										</div>

									</div>
								<?php endif; ?>





								<?php
	//$res=mysqli_query($con,"SELECT a.adm_no,b.name,c.rollno,d.sessional_marks FROM stud_sem_registration a,stud_details b,current_class c,sessional_marks d where a.classid='$a[0]' and a.new_seum='$a[2]' and a.adm_no=b.admissionno and a.classid=c.classid and a.adm_no=c.studid and d.subjectid='$b' and d.studid=b.admissionno order by c.rollno asc");

	//$res=mysql_query("SELECT a.adm_no as adno,b.name,c.rollno FROM stud_sem_registration a,stud_details b,current_class c where a.classid='$a[0]' and a.new_sem='$a[2]' and a.adm_no=b.admissionno and a.classid=c.classid and a.adm_no=c.studid order by c.rollno asc");



								$res=mysql_query("SELECT c.studid,b.name,c.rollno FROM stud_details b,current_class c where c.classid='$classid' and c.studid=b.admissionno and b.admissionno in ( select studid from sessional_marks where subjectid='$subjectid' and classid='$classid'  )  order by c.rollno asc");
												// echo "--" . $b[0];
								$l=mysql_query("select * from sessional_marks where subjectid='$subjectid' and classid='$classid'");
								if(mysql_num_rows($l)>0)
								{
									?>
									<div class="table-responsive">
										<table class="table table-hover table-bordered">

											<tr>
												<th>Roll No</th>
												<th>Name</th>
												<th>Marks</th>
												<th>Remark</th>
												<?php if( $verification_status_b == 0 || $verification_status_b == 2 ): ?>  
													<th>verification status </th>
													<th>action</th>
												<?php endif; ?>  
											</tr>

											<?php
											$i=0;
											while($rs=mysql_fetch_array($res))
											{
												$aid=$rs["studid"];

												$r=mysql_query("select sessional_marks, sessional_remark,verification_status from sessional_marks where subjectid='$subjectid' and studid='$aid'");
												$x=mysql_fetch_assoc($r);
												if($x["verification_status"]=="")
												{
													$vi=0;
													$dis='';	
												}
												else
												{		
													$vi=1;
																	// $dis='disabled="disabled"';	
																	// removed 
													$dis = "";

												}

												$dis_option  = "   "; 
												$dis_option  = " disabled='disabled' "; 
												$verification_status = $x['verification_status'];
												if( $verification_status == 0){
													$dis_option  = " disabled='disabled' "; 
												}


												?>        

												<!-- <form method="post" action=""  >    -->
													<tr class="update-form">
														<td><?php echo $rs["rollno"]; ?></td>
														<td><?php echo $rs["name"]; ?></td>
														<td> <input type="text" <?php echo $dis; ?> <?php echo $dis_option; ?> name="mark" value="<?php echo $x["sessional_marks"]; ?>"/></td>
														<td> <textarea name="remark"  <?php echo $dis_option; ?> ><?php echo $x["sessional_remark"]; ?></textarea></td>


														<?php if( $verification_status_b == 0 || $verification_status_b == 2 ): ?>  
															<td>

																<?php

																switch ($verification_status) {
																	case 0:
																	echo "<span class='text-black'> waiting for staff advisor verification  </span>";
																	break;
																	case -1:
																	echo "<span class='text-danger'> sessional mark  rejected </span>";
																	break;
																	case 1 :
																	echo "<span class='text-success'>  $sessional_status sessional marks published  </span>
																	";
																	break;
																	case 2:
																	echo "<span class='text-warning'> $sessional_status sessional marks changed  </span>";
																	break;


																	default:
																	echo "<span class='text-info'>  $sessional_status sessional marks published  </span>
																	";
																	break;
																}


																?>



															</div>





														</td>
														<td>



															<?php if( $verification_status == 0 || $verification_status == 2): ?>
																<div class="form-group ">
																	<form method="post" action="" style="border: 1px solid red; padding: 3px 5px;     display: inline-flex;"> 
																		<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
																		<input type="hidden" name="studid" value="<?php echo $aid; ?>">
																		<input type="hidden" name="classid" value="<?php echo $classid; ?>">
																		<input type="hidden" name="status" value="-1">
																		<input type="hidden" name="id" value="<?php echo $aid; ?>">
																		<input type="radio" name="checkbox_<?php echo $aid; ?>" style=" margin: 8px;" class="for-all-chekc checkbox_<?php echo $aid; ?> checkbox_todo" action-date="checkbox_<?php echo $aid; ?>">
																		<button name="action-s-reject" class="btn btn-sm btn-danger  " style="text-transform: uppercase;">reject</button>  
																	</form> 
																	<br>  
																</div>
															<?php endif; ?>


															<?php if( $verification_status == 0 ||$verification_status == 2): ?>

																<div class="form-group ">
																	<form method="post" action=""  style="border: 1px solid green; padding: 3px 5px;     display: inline-flex;"> 

																		<input type="hidden" name="studid" value="<?php echo $aid; ?>">
																		<input type="hidden" name="status" value="1">
																		<input type="hidden" name="id" value="<?php echo $aid; ?>">
																		<input type="hidden" name="classid" value="<?php echo $classid; ?>">

																		<input type="radio" name="checkbox_<?php echo $aid; ?>" style=" margin: 8px; " class="for-all-chekc  checkbox_todo" action-date="checkbox_<?php echo $aid; ?>">

																		<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
																		<button name="action-s-verify" class="btn btn-sm btn-success  " style="text-transform: uppercase;">Verify</button>  
																	</form> 
																	<br>  
																</div>

															<?php endif; ?>


														</td>

													<?php endif; ?> 


												</tr>
												<!-- </form> -->
												<?php

												$i++;
											}
											?>






										</table>


										<?php
									} 

									?>






								</div>











							<?php endif; ?>
							<?php ?>
							<?php ?>



							<!-- <button class="btn btn-primary" onclick="PrintElem('page-wrapper')">Print</button> -->


							<!-- /.row -->
							<div class="row">





								<!-- /.row -->
								<div class="row">
									<div class="col-lg-8">

									</div>
									<!-- /.panel-heading -->

									<!-- /.panel-body -->
								</div>
								<!-- /.panel -->

								<!-- /.panel-body -->

								<!-- /.panel-footer -->
							</div>
							<!-- /.panel .chat-panel -->
						</div>
						<!-- /.col-lg-4 -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /#page-wrapper -->

			</div>
			<!-- /#wrapper -->   
			<form style="display: none;" action="" method="post" id="submit-backend">
				<input type="hidden" name="selected_subject" value="<?php if(isset($_POST['selected_subject'])) {echo $_POST['selected_subject']; } ?>">
			</form>


			<script src="../dash/vendor/jquery/jquery.min.js"></script>
			<script type="text/javascript">

				$(document).ready(function($) {
					

					$(document).on('change', '.checkbox_todo', function(event) {
						event.preventDefault();

						$this = $(this);
						$action = $this.attr('action-date'); 
						$('.checkbox_todo[action-date="'+$action+'"]').prop( "checked", false );
						$this.prop('checked', true);


					});
						// confirm('Do you really want to proceed the build verification' )
						$(document).on('click', '#doProcessnOwbulk', function(event) {
							event.preventDefault();
							$arra = [];
							$('.checkbox_todo').each(function() {  
								$paretnForm = $(this).closest('.form-group');
								$inarr = {};
								if($(this).is(':checked')) { 
									$paretnForm.find('input').each(function(index, el) {
										
										$inarr[$(this).attr('name')] = $(this).val();  
									}); 
									$arra.push($inarr);
								}
							});


							// $arra.push($this.val());
							
							if ($arra.length  < 1) {

								alert('noting to submit');
								return;
							}
							$returdta = JSON.stringify( $arra );
							// $('#submit-backend').append('<input type="hidden" name="data-buk" value="'+$returdta+'" > ');
							// $('#submit-backend').submit();

							

							jQuery.ajax({
								url: 'sessional_verification_ajax.php',
								type: "POST",
								data: {data: $returdta },
								dataType: "json",

								success: function(result) {
									console.log(result);

									if (result == 1) {
										alert("successfully updated");
										$('#submit-backend').submit();

									} else {
										alert("error in processing");
									}
								}
							});      


						});




					});



				</script>
				<?php

				include("includes/footer.php");
				?>