<!-- /side nav -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
                           <!-- <li class="sidebar-search">
                          <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                           /input-group 
                       </li>-->
                       <li>
                        <a href="dash_home.php"><i class="fa fa-user fa-fw"></i>
                            <?php
                            include("../../connection.php");
                            $r=mysql_query("select name from faculty_details where fid='$hodid'");
                            while($d=mysql_fetch_array($r))
                            {
                                $fname=$d["name"]; 
                                echo $fname; 
                                
                            }                        
                            ?>                        
                            
                        </a>
                    </li>                        

                    <li>                        
                        <a href="#"><i class=" fa fa-edit fa-fw"></i>FACULTY<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="empreg.php">Registration</a>
                            </li>
                            <li>
                                <a href="viewaddstaff.php">View Faculty Details</a>
                            </li>
                            

                        </ul>
                    </li>
                    <li>                        
                        <a href="#"><i class=" fa fa-edit fa-fw"></i>STAFF ADVISOR<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="staffreg.php">Allot Staff Advisor</a>
                            </li>
                            <li>
                                <a href="viewstaffadvisor.php">View Staff Advisor</a>
                            </li> 

                        </ul>
                    </li>

                    
                    <li>                        
                        <a href="#"><i class=" fa fa-edit fa-fw"></i>SUBJECT<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="subreg.php">Add Subject</a>
                            </li>  
                            <li>
                                <a href="subject_view.php">View Subjects</a>
                            </li>                                
                            <li>
                                <a href="suballoc1.php">Allocate Subject</a>                                    
                            </li> 

                            <li>
                                <a href="suballoc_view.php">View Subject Allocation</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="student_search.php"><i class="fa fa-search fa-fw"></i>STUDENT SEARCH</a>
                    </li>
                    <li>
                        <a href="sem_verificationnew.php"><i class="fa fa-table fa-fw"></i>STUDENT SEMESTER REGISTRATON</a>
                    </li>

                    
					
					    <li>
                   	<a href="#"><i class="fa fa-align-justify"></i> ATTENDANCE</a>

                   	<ul class="nav nav-second-level">
					                   		<!-- <li>
                   			<a href="hod_hour_edit.php">Edit Hour</a>
                   		</li> -->

                   		<li>
                   			<a href="hod_subjectwiseview.php">View</a>
                   		</li>

                   	</ul>

                   </li>
					
					
					
					
					
                    <li>
                        <a href="sess_verification.php"><i class="fa fa-table fa-fw"></i>SESSIONAL MARKS VERIFICATION</a>
                    </li>

                    <li>
                        <!-- <a href="mark.php"><i class="fa fa-table fa-fw"></i>UNIVERSITY MARK</a> -->
                    </li>

                    <li>                        
                        <a href="#"><i class="fa fa-table fa-fw"></i>FEEDBACK<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="feedback_result.php">View All FeedBack</a>
                            </li>
                            <li>
                                <a href="start.php">Control Feedback Status</a>
                            </li>
							 <li>
                                <a href="feedback_count.php">View feedback Count</a> 
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="response.php"><i class="fa fa-table fa-fw"></i> PARENT COMPLAINT </a>
                    </li>
                    <li>
                        <a href="Certificate code/search_form.php"><i class="fa fa-edit fa-fw"></i>BONAFIDE CERTIFICATE </a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
