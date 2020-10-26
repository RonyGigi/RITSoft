<?php
include("../connection.mysqli.php");
//$con=mysqli_connect("localhost","root","","ritsoft");
require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$sum="";
$j=$_REQUEST["j"];

$k=$_REQUEST["k"];
$cls=$_REQUEST["cls"];
$date1=$_REQUEST["e"];
$date2=$_REQUEST["f"];
$d1=date('d-m-Y',strtotime($_REQUEST["e"]));
$d2=date('d-m-Y',strtotime($_REQUEST["f"]));
$bs=$_REQUEST["bs"];
$dept=strtolower($_REQUEST["dept"]);
$bs1=strtolower($bs);
$semester=$_REQUEST["d"];
$cid=$_REQUEST["cid"];

$html="";
$html.="<html>";
$html.="<head>";
$html.="<h2 style=margin-bottom:0><center>Rajiv Gandhi Institute Of Technology</center></h2>";
if($cid=='MCA'|| $cid =='BARCH')
{
	
	$html.='<h2 style=margin-top:0 ><center>'.$semester.' '.$cid.' Attendance Percentage </center></h2>';
}
else
{
	
	$html.='<h2 style=margin-top:0 ><center>'.$cls2.' '.$cid.' '.ucwords($bs).' Attendance Percentage </center></h2>';
}
$html.="<h3 style=margin-top:0><center>(From: ".$d1." To: ".$d2.") </center></h3>";
$html.="</head>";
$html.="<body>";
$html.="<table border='1' cellspacing='0' align=center cellspacing='0' width='100%'>";
$html.="<tr><th>Roll no</th>";
$html.="<th>Name</th>";
$res1=mysqli_query($con3,"select * from subject_class where classid='$cls' order by subjectid asc");
while($rs1=mysqli_fetch_array($res1))
{
	$html.="<th>".$rs1["subjectid"]."(%)</th>";
}
$html.="<th> Total(%) </th>";
$html.="</tr>";
while($j<=$k)
	{ 	//$res2=mysqli_query($con,"SELECT a.adm_no,b.name,c.rollno FROM stud_sem_registration a,stud_details b,current_class c where a.classid='$class[0]' and a.new_sem='$class[2]' and a.adm_no=b.admissionno and a.classid=c.classid and a.adm_no=c.studid and c.rollno='$j' order by c.rollno asc");

$res2=mysqli_query($con3,"SELECT c.studid,b.name,c.rollno FROM stud_details b,current_class c where c.classid='$cls' and c.studid=b.admissionno and c.rollno='$j' order by c.rollno asc");

while($rs2=mysqli_fetch_array($res2))
{
	$i=1;
	$sid=$rs2["rollno"];
	$html.="<tr>";
	$html.="<td align=center>".$rs2["rollno"]."</td>";
	$html.="<td >".strtoupper($rs2["name"])."</td>";

	
	
	$total=0;
	$present=0;
	$res3=mysqli_query($con3,"select * from subject_class where classid='$cls' order by subjectid asc");
	while($rs3=mysqli_fetch_array($res3))
	{
		
		$res4=mysqli_query($con3,"select distinct date,subjectid,hour from attendance where studid='$rs2[studid]' and date BETWEEN '$date1' AND '$date2' and subjectid='$rs3[subjectid]' and classid='$cls' and ( status = 'P' OR status = 'A' )");
		$res5=mysqli_query($con3,"select distinct date,subjectid,hour from attendance where studid='$rs2[studid]' and date BETWEEN '$date1' AND '$date2' and subjectid='$rs3[subjectid]' and classid='$cls' and status='P'");
		
		if(mysqli_num_rows($res4)==0){
			$tbo =   "0";
			$resulto=mysqli_query($con3,"select * from subject_class where  subjectid='$rs3[subjectid]' and type='ELECTIVE' ");
			if(mysqli_num_rows($resulto) > 0 ) { 
				$resulto1=mysqli_query($con3,"select * from elective_student where  sub_code='$rs3[subjectid]' and stud_id ='".$rs2["studid"]."' ");
				if(mysqli_num_rows($resulto1) <1 ) { 
					$tbo =   "--"; 
				} 
			}  
			

			$html.="<td align=center>$tbo</td>";
		}
		else
		{
			
			$sum=round(((mysqli_num_rows($res5)/mysqli_num_rows($res4))*100),2); 
			$html.="<td align=center>".$sum."</td>";
		}
		$total+=mysqli_num_rows($res4);
		$present+=mysqli_num_rows($res5);				
		
	}
	if($total==0)
		$html.= "<td>0</td>";
	else{
		$tot=round((($present/$total)*100),2); 
		$html.="<td align=center>".$tot."</td>";
		$html.="</tr>";                                  }
	}
	$j++;
	
}	$html.="</table>"; 



$html.="<br/><br/><br/><br/><br/><br/>";
$html.="<table border='1' cellspacing='0' align=center cellspacing='0' >";
$html.="<tr> <th> SUBJECT ID </th> <th> SUBJECT NAME </th></tr>";
$c=mysqli_query($con3,"select * from subject_class where classid='$cls' order by subjectid asc");
while($re=mysqli_fetch_array($c))
{
	$html.="<tr>
	
	<th>". $re["subjectid"]. "</th>
	<th>".$re["subject_title"] ."</th>
	</tr>";
	
}

$html.="</table>";


$html.="<br/><br/>";
$html.="<h3 align=right style=margin-bottom:0>HOD</h3>";



$html.="<h3 align=right style=margin-top:0>Department Of ".ucwords($dept)."</h3>";
$html.="</body>";
$html.="</html>";
$dompdf->loadHtml(html_entity_decode($html));	
$dompdf->setPaper('A4', 'landscape'); //portrait
$dompdf->render();
$dompdf->stream("attendance",array("Attachment"=>0));

?>
