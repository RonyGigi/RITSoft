<?php
include("includes/header.php");
  include("includes/connection1.php");
  include("includes/sidenav.php");
?>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><span>GRIEVANCES
                         
                    </span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
  					
            <!-- /.row -->
           	<div>
            
            <div class="table-responsive">
            <?php
            $query="select id_com,subject,content,com_time,response,res_time from complaint where fid='$hodid' and designation='hod' and status=1 order by com_time desc";
			$res=mysql_query($query,$con);
            echo "<table class='table table-hover table-bordered'>
                <tr>
					<th> SUBJECT  </th>
                    <th> MESSAGE </th>
                    <th>MESSAGE TIME</th>
					<th>RESPONSE</th>
					<th>RESPONSE TIME</th>
                 </tr>";
            $i=0;
            while($row =mysql_fetch_assoc($res))
            {
                $i++;
                echo "<tr>";
				echo "<td>".$row['subject']."</td>";
                echo "<td>".nl2br($row['content'])."</td>";
                $com=new DateTime($row['com_time']);
                echo "<td>".$com->format('d-m-Y')."</td>";
                echo "<td>".nl2br($row['response'])."</td>";
                if ($row['res_time']) {
                    $re=new DateTime($row['res_time']);
                    echo "<td>".$re->format('d-m-Y')."</td></tr>";
                }
                else {
                    echo "<td>  </td></tr>";;
                }
            }
            if($i==0)
            {
                echo '<tr><td colspan="5"><center><b>NO complaints yet.......!</b></center></td></tr> ';
            }
            ?>

       </tbody>
     </table>
     <?php
	include("includes/footer.php");
?>