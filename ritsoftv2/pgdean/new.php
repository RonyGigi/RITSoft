<?php
include("includes/header.php");
include("includes/sidenav.php");
error_reporting(0);

$admisno=$_SESSION['adm'];

$issued_by=$_SESSION['fid'];

echo $admisno;
//$name1=$_SESSION['name'];
//echo $name1;
$name="";
$course="";
$batch="";
$sem="";
 //$year="";
include('../connection.php');
?>
<!--<script type="text/javascript">
//function Checkcolor(val)
//{
	//var element=document.getElementById('color');
	//var element2=document.getElementById('branch');
	//var element3=document.getElementById('branchlabel')
	//if(val=='M.TECH')
	//{
		//element.style.display='block';
		//element2.style.display='none';
		//element3.style.display='none';
		//}
		
		//else
		//{
		//element.style.display='none';
		//element2.style.display='block';
		//element3.style.display='block';
		//}
		//if(val=='MCA'||val=='B.ARCH')
		//{
		//element2.style.display='none';
		//element3.style.display='none';
		//}
//}



//</script>-->



<?php

// $sql="select sd.name,cc.*,s.* from current_class cc,class_details s,stud_details sd where cc.classid=s.classid and cc.studid=sd.admissionno and sd.admissionno='$admisno'";
$sql="select * from stud_details  where admissionno='$admisno'";
	//echo $sql;
$result=  mysql_query($sql);
while($db_field=mysql_fetch_array($result))
{ 
	$name=$db_field["name"];
	$_SESSION['name']=$name;
	$year=$db_field["year_of_admission"];
	$_SESSION['year']=$year;
	$course=$db_field["courseid"];
	$_SESSION['courseid']=$course;

	//echo $name;		

}

$sql2="select * from current_class  where studid='$admisno'";
//echo $sql2;
$result2=  mysql_query($sql2);
while($db_field1=mysql_fetch_array($result2))
{ 
	$classid=$db_field1["classid"];
	$_SESSION["classid"]=$classid;

}



$sqll="select * from class_details  where classid='$classid'";
//echo $sqll;
$result1=  mysql_query($sqll);
while($dbfield=mysql_fetch_array($result1))
{ 


	$branch=$dbfield["branch_or_specialisation"];
	$sem=$dbfield["semid"];
	
	$_SESSION["spec"]=$branch;
	$_SESSION["sem"]=$sem;
  //echo $name;   

}
?>
<div id="page-wrapper">

	<form name="form1" method="post"  bgcolor="#292929"  >
		<ul class="errorMessages"></ul>
		<div align="center">
			<p>&nbsp;</p>
			<table width="737" height="946" border="0" background="img2/116209-desktop-wallpaper-desktop-wallpaper-1920x1200.jpg" bordercolor="#00486A">
				<tr bgcolor="#002040">
					<th height="65" colspan="2" scope="row"><font color="#FFFFFF"><center><h3><b>STUDENT CERTIFICATE</center></h3></b></th>
					</tr>
					<tr>
						<th width="174" height="65" scope="row"><div align="left">Name</div></th>
						<td ><input type="text" class="form_control"name="name" id="name"  value="<?php  echo $name; ?>" </td>
					</tr>
					<tr>
						<th height="71" scope="row"><div align="left"><strong>Course</strong></div></th>
						<td>
							<input type="text" name="course" id="course"  value="<?php  echo $course; ?>"</td> 
						</tr>
						<tr>
							<th height="45" scope="row"><div align="left"><label id="branchlabel">Branch</label></div></th>
							<td>  
								<input type="text" name="branch" id="branch"  value="<?php  echo $branch; ?>"
							</td>
						</tr>
						<tr>
							<th height="69" scope="row"><div align="left">Semester</label></div></th>
							<td>   <input type="text" name="semester" id="semester"  value="<?php  echo $sem; ?> "</td>

						</tr>
						<tr>
							<th height="129" scope="row">Purpose For Certificate</th>
							<td><textarea name="purpose" cols="45" rows="5" id="purpose" required></textarea></td>
						</tr>
						<tr>
							<th height="40" scope="row"><div align="left">Date</div></th>
							<td><input type="date" name="date" id="date" value="<?php echo date("d/m/Y"); ?>"></td>
						</tr>
						<tr>
							<th colspan="2" scope="row"> <div align="right">
								<p align="center">
									<input type="submit" name="submit" id="submit" value="submit"></p></div></th>
								</tr>
							</table>
							<p><font size="-1">Developed by MCA Department</font>
							</p>
						</div>
					</div>
					<?php
					if(isset($_REQUEST['submit']))
					{
						$p=$_POST['purpose'];
						$_SESSION['purpose']=$p;


						$c=	mysql_query("INSERT INTO serialno values('000','$classid','$issued_by','$admisno')") or die(mysql_error());

						if($c>0)
						{
							echo "sussess inserted";
						}

						else
						{
							echo "invalid insrted";
						}			
				//$_SESSION['branch']=$_POST['branch'];
				//$_SESSION['$spec']=$_POST['color'];
				//$spec=strtoupper($spec);

//echo $branch.$course;

		//echo $spec.$branch;

						echo "<script language='JavaScript' type='text/JavaScript'>
						window.location='cert_number.php';
						</script>
						";


//$_SESSION['adm']=$_POST['adm'];
//_SESSION['year']=$_POST['year'];
//$_SESSION['purpose']=$_POST['purpose'];

//$_SESSION['issued']=$_POST['issued'];
//$_SESSION['date']=$_POST['date'];
//$_SESSION['sem']=$_POST['sem'];
//$_SESSION['branch']=$branch;
//$_SESSION['spec']=$spec;
//$_SESSION['course']=$course;


					}
					?>

					<!--   <input type="submit" name="submit2" id="submit2" value="CLEAR">-->



					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>


				</form>
			</div>
			<?php

			include("includes/footer.php");
			?>
			<script>
				var createAllErrors = function() {
					var form = $( this ),
					errorList = $( "ul.errorMessages", form );

					var showAllErrorMessages = function() {
						errorList.empty();

            // Find all invalid fields within the form.
            var invalidFields = form.find( ":invalid" ).each( function( index, node ) {

                // Find the field's corresponding label
                var label = $( "label[for=" + node.id + "] "),
                    // Opera incorrectly does not fill the validationMessage property.
                    message = node.validationMessage || 'Invalid value.';

                    errorList
                    .show()
                    .append( "<li><span>" + label.html() + "</span> " + message + "</li>" );
                });
        };

        // Support Safari
        form.on( "submit", function( event ) {
        	if ( this.checkValidity && !this.checkValidity() ) {
        		$( this ).find( ":invalid" ).first().focus();
        		event.preventDefault();
        	}
        });

        $( "input[type=submit], button:not([type=button])", form )
        .on( "click", showAllErrorMessages);

        $( "input", form ).on( "keypress", function( event ) {
        	var type = $( this ).attr( "type" );
        	if ( /date|email|month|number|search|tel|text|time|url|week/.test ( type )
        		&& event.keyCode == 13 ) {
        		showAllErrorMessages();
        }
    });
    };
    
    $( "form" ).each( createAllErrors );
</script>

