 <?php
 //session_start();
 //include("../connection.php");
 include("../connection.mysqli.php");
// $con=mysqli_connect("localhost","root","","ritsoft");
 
 $uname=$_SESSION['fid'];
 if(isset($_POST["submit"]))
 {
 	$a=explode(",",$_POST['a']);
 	$b=explode("-",$_POST['b']);
 	$c=$_POST["date"];
 	//$d=$_POST["hour"];

      //$d=$_POST["hour"];

//foreach($_POST['hour'] as $d) {
 //echo $d; }


foreach($_POST['hour'] as $d) {


	//$res=mysqli_query($con,"SELECT a.adm_no,b.name,c.rollno FROM stud_sem_registration a,stud_details b,current_class c,elective_student e where a.classid='$a[0]' and a.new_sem='$a[2]' and a.adm_no=b.admissionno and a.classid=c.classid and a.adm_no=c.studid and e.sub_code='$b[0]' and e.stud_id=a.adm_no order by c.rollno asc");
 	$res=mysqli_query($con3,"SELECT c.studid,b.name,c.rollno FROM stud_details b,current_class c,elective_student e where c.classid='$a[0]' and c.studid=b.admissionno and e.sub_code='$b[0]' and e.stud_id=c.studid order by c.rollno asc");
 	$i=1;
 	$e=0;
 	while($rs=mysqli_fetch_array($res))
 	{

 		$sid=$rs["studid"];
 		$resoIn = mysqli_query($con3,"SELECT * FROM attendance where  date = '$c' and hour= '$d' and classid = '$a[0]' and studid = '$sid' ");

 		if(mysqli_num_rows($resoIn) == 0) {

 			if(isset($_POST[$rs["studid"]]))
 				$st="P";
 			else
 				$st="A";
			//echo "insert into attendance values('0','$c','$d','$b[0]','$a[0]','$sid','$st')<br/>";
 			$e=mysqli_query($con3,"insert into attendance values('0','$c','$d','$b[0]','$a[0]','$sid','$st')");
 			$i++;
 		}

 	} 

 	if($e>0)
 	{
 		?>
 		<script>
 			alert("Insert Successfully");
 			window.location="hos_att.php";
 		</script>
 		<?php
 	}
 	else
 	{
 		?>
 		<script>
 			alert("Error In Insertion");
 			window.location="hos_att.php";
 		</script>
 		<?php
 	} 

} 

 } 
 ?>