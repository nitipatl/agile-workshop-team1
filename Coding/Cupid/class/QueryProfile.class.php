<?php
class QueryProfile extends Operation{
// Select Data
//	function @name(){			
//		$sql = "";
//		return $this->selectQuery($sql);
//	}
//  Insert, Update, Delete
//	function @name(){			
//		$sql = "";
//		return $this->sendQuery($sql);
//	}

	function getUser($User,$Pass){
		 $sql = "SELECT	b.person_id, b.person_name, a.email, a.tel, a.status, a.role, a.agency
					FROM	tbl_userpass a LEFT JOIN
								tbl_person b ON a.username=b.person_id
					WHERE a.username='$User' AND a.password ='$Pass'  " ;
		return $this->selectQuery($sql);
	}
	
	/*function getUser($User,$Pass){
		 echo $sql = "SELECT		b.person_id, b.person_name, a.email, a.tel, a.status, a.role, a.agency, c.status AS position
					FROM		tbl_capacity AS c INNER JOIN
                         			tbl_person AS b ON c.person_id = b.person_id RIGHT OUTER JOIN
                         			tbl_userpass AS a ON b.person_id = a.username
					WHERE 		a.username='$User' AND a.password ='$Pass' 
					GROUP BY	b.person_id, b.person_name, a.email, a.tel, a.status, a.role, a.agency,c.status  " ;
		return $this->selectQuery($sql);
	}*/
	
	function getUserDetail($pid, $agency){
		 $sql = "SELECT	b.budget_year, b.period, a.person_id, a.person_name, b.position_name, b.agency, b.leader_id, d.person_name AS leader, c.email, c.tel
					FROM	tbl_person a INNER JOIN
								tbl_capacity b ON a.person_id = b.person_id INNER JOIN
								tbl_userpass c ON a.person_id = c.username LEFT OUTER JOIN
								tbl_person d ON b.person_id = d.person_id
					WHERE	a.person_id = '$pid' AND b.agency LIKE '$agency' AND b.budget_year+b.period = (SELECT MAX(budget_year+period) FROM tbl_capacity)" ;
		return $this->selectQuery($sql);
	}
	
	function getAgency($agency){
		$sql = "SELECT	DISTINCT agency, budget_year, period
					FROM	tbl_capacity
					WHERE	budget_year+period = (SELECT MAX(budget_year+period) FROM tbl_capacity) AND agency LIKE '$agency'";
		return $this->selectQuery($sql);
	}
	
	function getAgencyYear($budget_year_period, $agency){
		$sql = "SELECT	DISTINCT agency, budget_year, period
					FROM	tbl_capacity
					WHERE	budget_year+period = '$budget_year_period' AND agency LIKE '$agency' ";
		return $this->selectQuery($sql);
	}
	
	function getDetailCapacity($budget_year_period, $agency){
		$sql = "SELECT		budget_year, period, a.person_id, b.person_name, position_id, position_name, type, class, agency, status, leader_id, c.person_name AS leader
					FROM		tbl_capacity a LEFT OUTER JOIN
									tbl_person b ON a.person_id = b.person_id LEFT OUTER JOIN
									tbl_person c ON a.leader_id = c.person_id
					WHERE		budget_year+period = '$budget_year_period' AND agency = '$agency'
					ORDER BY	position_id";
		return $this->selectQuery($sql);
	}

	function getCapacityPerson($budget_year_period, $person_id){
		$sql = "SELECT	budget_year, period, a.person_id, b.person_name, position_id, position_name, type, class, agency, status, leader_id, c.person_name AS leader
							FROM	tbl_capacity a LEFT OUTER JOIN
										tbl_person b ON a.person_id = b.person_id LEFT OUTER JOIN
										tbl_person c ON a.leader_id = c.person_id
							WHERE	budget_year+period = '$budget_year_period' AND a.person_id = '$person_id'";
		return $this->selectQuery($sql);
	}
	
	function getCapacitySkill($budget_year, $period){
		 $sql = "SELECT	*
					FROM	tbl_capacity_main
					WHERE	budget_year = '$budget_year' AND period = '$period' " ;
		return $this->selectQuery($sql);
	}
	
	function getMainCapacity(){
		 $sql = "SELECT      id, type, class, score
					FROM         tbl_capacity_score" ;
		return $this->selectQuery($sql);
	}
	
	function getLeader($agency){
		 $sql = "SELECT	a.person_id, b.person_name, a.agency
					FROM	tbl_capacity a INNER JOIN
								tbl_person b ON a.person_id=b.person_id
					WHERE	a.status='หัวหน้า' AND agency='$agency' AND a.budget_year+a.period=(SELECT MAX(budget_year+period) FROM tbl_capacity)";
		return $this->selectQuery($sql);
	}
	
	function getLeader_year($budget_year_period, $agency){
		 $sql = "SELECT	a.person_id, b.person_name, a.agency
					FROM	tbl_capacity a INNER JOIN
								tbl_person b ON a.person_id=b.person_id
					WHERE	a.status='หัวหน้า' AND agency='$agency' AND a.budget_year+a.period='$budget_year_period'";
		return $this->selectQuery($sql);
	}
	
	function UpdateMainCapacity($id, $score){
		$sql = "UPDATE tbl_capacity_score SET score='$score' WHERE id='$id' ";
		return $this->sendQuery($sql);
	}
	
	function Execute($sql){
			return $this->sendQuery($sql);
		}
	
	function Execute1($sql){
			return $this->selectQuery($sql);
		}
		
	function getCourse($budget_year,$p){
		 $sql = "SELECT course_id, course_name, course_agency, place, fee, sdate, edate, day, file_path, profession, capacity, skill, insert_datetime, update_datetime, del_status, budget_year, insert_name, 
                         ISNULL(cast(approve as varchar),3) as approve , agency
						  FROM [dbo].[tbl_course] 
						  WHERE del_status is null and budget_year = '$budget_year' and period = '$p'
						  order by sdate " ;
		return $this->selectQuery($sql);
	}	
	
	function getdataCourse($id){
		 $sql = "SELECT * FROM tbl_course WHERE course_id = '$id' " ;
		return $this->selectQuery($sql);
	}	
	
	//---------add-course------------------//
	
	function getCourseMain($person_id,$budget_year,$period){
		
		$sql = "	SELECT	a.*, b.course_id AS chk
					FROM	tbl_course a LEFT OUTER JOIN
								(
								SELECT	course_id
								FROM	tbl_training
								WHERE	budget_year = $budget_year AND period = $period AND person_id = '$person_id'
								)b ON a.course_id = b.course_id
					WHERE	budget_year = $budget_year AND period = $period  AND approve=1";
//			 $sql = "
//SELECT a.budget_year,a.course_id,a.course_name,a.course_agency, a.place, a.fee, a.file_path, a.day, a.sdate, a.edate,
//		 a.profession, a.cap1, a.cap2, a.cap3, a.cap4, a.cap5,
//		 case 
//		 when a.cap1  >0 then 1
//		 when a.cap2  >0 then 2
//		 when a.cap3  >0 then 3
//		 when a.cap4  >0 then 4
//		 when a.cap5  >0 then 5
//		 else '0' end as cnt_cap,
//		 b.person_id as c_person_id,b.period,b.position_id,b.position_name,b.cap1 as c_cap1, b.cap2 as c_cap2, b.cap3 as c_cap3, b.cap4 as c_cap4, b.cap5 as c_cap5,
//		 c.score,
//		 d.person_id as p_person_id,d.person_name,
//		 (b.cap1-c.score) as cap_1,(b.cap2-c.score) as cap_2,(b.cap3-c.score) as cap_3,(b.cap4-c.score) as cap_4,(b.cap5-c.score) as cap_5,
//		 e.email
//FROM
//	(SELECT  course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, cap1, cap2, cap3, cap4, cap5
//	FROM    dbo.tbl_course 
//	WHERE  (del_status IS NULL) AND (budget_year = '$budget_year') AND (cap1 = 1) AND approve = 1
//	GROUP BY course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, cap1, cap2, cap3, cap4, cap5,approve 
//	UNION
//	SELECT  course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, 0, cap2, 0, 0, 0
//	FROM    dbo.tbl_course
//	WHERE  (del_status IS NULL) AND (budget_year = '$budget_year') AND (cap2 = 1) AND approve = 1
//	GROUP BY course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, cap1, cap2, cap3, cap4, cap5,approve 
//	UNION
//	SELECT  course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, 0, 0, cap3, 0, 0
//	FROM    dbo.tbl_course
//	WHERE  (del_status IS NULL) AND (budget_year = '$budget_year') AND (cap3 = 1) AND approve = 1
//	GROUP BY course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, cap1, cap2, cap3, cap4, cap5,approve 
//	UNION
//	SELECT  course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, 0, 0, 0, cap4, 0
//	FROM    dbo.tbl_course
//	WHERE  (del_status IS NULL) AND (budget_year = '$budget_year') AND (cap4 = 1) AND approve = 1
//	GROUP BY course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, cap1, cap2, cap3, cap4, cap5,approve 
//	UNION
//	SELECT  course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, 0, 0, 0, 0, cap5
//	FROM    dbo.tbl_course
//	WHERE  (del_status IS NULL) AND (budget_year = '$budget_year') AND (cap5 = 1) AND approve = 1
//	GROUP BY course_id, course_name, course_agency, place, fee, file_path, day, sdate, edate, budget_year, profession, cap1, cap2, cap3, cap4, cap5,approve 
//	) a left outer join
//	[dbo].[tbl_capacity] b ON a.budget_year = b.budget_year left outer join
//	[dbo].[tbl_capacity_score] c ON b.type = c.type and b.class = c.class left outer join
//	[dbo].[tbl_person] d ON b.person_id = d.person_id inner join
//	[dbo].[tbl_userpass] e ON d.person_id = e.username
//WHERE   (a.budget_year = '$budget_year') AND (b.person_id = '$person_id') AND (b.period = '$period') 
// GROUP BY a.budget_year,a.course_id,a.course_name,a.course_agency, a.place, a.fee, a.file_path, a.day, a.sdate, a.edate, a.budget_year, 
//					a.profession, a.cap1, a.cap2, a.cap3, a.cap4, a.cap5,
//					b.period,b.person_id,b.position_id,b.position_name,b.cap1, b.cap2, b.cap3, b.cap4, b.cap5,
//					c.score,
//					d.person_id ,d.person_name,
//		 			e.email
// ORDER BY a.cap1 Desc , a.cap2 Desc, a.cap3 Desc, a.cap4 Desc, a.cap5 Desc
//		" ; 
		
			return $this->selectQuery($sql);
	}	
	function getPersonCapacity($person_id,$budget_year,$period){
//			$sql = "SELECT  p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, c.leader_id, c.cap1, c.cap2, c.cap3, 
//				c.cap4, c.cap5, c.insert_datetime, c.update_datetime, m.score, c.capacity_detail, c.skill_detail,
//				sum(c.cap1-m.score) as score1,
//				sum(c.cap2-m.score) as score2,
//				sum(c.cap3-m.score) as score3,
//				sum(c.cap4-m.score) as score4,
//				sum(c.cap5-m.score) as score5
//	FROM    tbl_capacity c INNER JOIN
//				tbl_capacity_score m ON c.type = m.type AND c.class = m.class INNER JOIN
//				tbl_person p ON c.person_id = p.person_id
//	WHERE  (p.person_id = '$person_id') AND (c.budget_year = '$budget_year') AND (c.period = '$period') 
//	GROUP BY p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, c.leader_id, c.cap1, c.cap2, c.cap3, 
//				c.cap4, c.cap5, c.insert_datetime, c.update_datetime, m.score" ;
			$sql = "SELECT	p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, c.leader_id, c.insert_datetime, c.update_datetime, m.score, c.capacity_detail, c.skill_detail
						FROM    tbl_capacity c INNER JOIN
									tbl_capacity_score m ON c.type = m.type AND c.class = m.class INNER JOIN
									tbl_person p ON c.person_id = p.person_id
						WHERE  (p.person_id = '$person_id') AND (c.budget_year = '$budget_year') AND (c.period = '$period')" ;
			return $this->selectQuery($sql);
	}	
	function getdataTraining($budget_year, $period,$person_id, $course_id){
			$sql = "SELECT a.budget_year,a.period,a.person_id,a.course_id,
			a.approved_leader,a.approved_leader_date,a.approved_directer,a.approved_directer_date,trained,a.trained_price,a.insert_datetime,a.update_datetime,
			b.username,b.password,b.email,b.status,b.role,b.agency
			FROM [dbo].[tbl_training] a INNER JOIN
			[dbo].[tbl_userpass] b ON a.person_id = b.username
			 WHERE budget_year = '$budget_year' and period = '$period' and person_id = '$person_id' and course_id = '$course_id' " ;
			return $this->selectQuery($sql);
	}	
	function InsertTraining($budget_year, $period,$person_id, $course_id){
			$sql = "INSERT INTO [dbo].[tbl_training](budget_year, period, person_id,course_id, insert_datetime ) 
				VALUES('$budget_year', '$period', '$person_id','$course_id', getdate() ) ";
			return $this->sendQuery($sql);
	}
	function getemail_t($a){
			$sql = "	SELECT        email, status, role, agency
						FROM            tbl_userpass
						WHERE        (email IS NOT NULL) AND (role LIKE '$a') AND (role <>'user')" ;
			return $this->selectQuery($sql);
	}	
	function getCourseAdd($person_id,$budget_year,$period){
		$sql = "	SELECT	b.course_id, b.course_name, b.course_agency, b.place, b.fee, b.sdate, b.edate, b.day,
								a.approved_leader, a.approved_leader_date, a.approved_directer, a.approved_directer_date, a.trained, a.trained_price,
								c.course_id AS approved_1m, 
								d.course_id AS approved_3m
					FROM	tbl_training a INNER JOIN
								tbl_course b ON a.course_id = b.course_id LEFT OUTER JOIN
								tbl_follow_1month c ON a.course_id = c.course_id AND a.person_id = c.person_id LEFT OUTER JOIN
								tbl_follow_3month d ON a.course_id = d.course_id AND a.person_id = d.person_id
					WHERE	a.budget_year = $budget_year AND a.period = $period AND a.person_id = '$person_id'";
//			 $sql = "SELECT  c.person_id, c.person_name, b.budget_year, b.period, b.person_id AS person_id2, b.position_id, b.position_name, b.type, b.class, b.agency, b.status, 
//					b.leader_id, b.cap1, b.cap2, b.cap3, b.cap4, b.cap5, a.score, 
//					d.course_id, d.course_name, d.course_agency, d.place, d.fee, d.sdate, d.edate, d.file_path, d.profession, d.day,
//					CASE WHEN d.profession = 'True' THEN 'สายวิชาชีพ' END AS profession, 
//					CASE WHEN d.cap1 = 'True' THEN 'การมุ่งผลสัมฤทธิ์' END AS cap11, 
//					CASE WHEN d.cap2 = 'True' THEN 'บริการที่ดี' END AS cap22, 
//					CASE WHEN d.cap3 = 'True' THEN 'การสั่งสมความเชี่ยวชาญในงานอาชีพ' END AS cap33, 
//					CASE WHEN d.cap4 = 'True' THEN 'การยึดมั่นในความถูกต้องชอบธรรม และจริยธรรม' END AS cap44, 
//					CASE WHEN d.cap5 = 'True' THEN 'การทำงานเป็นทีม' END AS cap55, 
//					d.budget_year AS budget_year_c, d.del_status, d.approve,
//					e.approved_leader, e.approved_leader_date, e.approved_directer, e.approved_directer_date, 
//					e.trained,e.trained_price
//		FROM    dbo.tbl_capacity_score a  INNER JOIN
//					dbo.tbl_capacity b ON a.type = b.type AND a.class = b.class INNER JOIN
//					dbo.tbl_person c ON b.person_id = c.person_id INNER JOIN
//					dbo.tbl_course d ON b.budget_year = d.budget_year INNER JOIN
//					dbo.tbl_training e ON d.course_id = e.course_id AND c.person_id = e.person_id AND b.period = e.period AND b.budget_year = e.budget_year
//		WHERE  (c.person_id = '$person_id') AND (b.budget_year = '$budget_year') AND (b.period = '$period') AND  d.del_status is null AND  d.approve = 1
//		" ;
			return $this->selectQuery($sql);
	}	
	function getCourseTraning($person_id,$budget_year,$period){
			 $sql = "SELECT  c.person_id, c.person_name, b.budget_year, b.period,  b.position_id, b.position_name, b.type, b.class, b.agency, b.status, 
					b.leader_id, b.cap1, b.cap2, b.cap3, b.cap4, b.cap5, a.score, 
					d.course_id, d.course_name, d.course_agency, d.place, d.sdate,d.edate,
					CASE WHEN d.profession = 'True' THEN 'สายวิชาชีพ' END AS profession, 
					CASE WHEN d.cap1 = 'True' THEN 'การมุ่งผลสัมฤทธิ์' END AS cap11, 
					CASE WHEN d.cap2 = 'True' THEN 'บริการที่ดี' END AS cap22, 
					CASE WHEN d.cap3 = 'True' THEN 'การสั่งสมความเชี่ยวชาญในงานอาชีพ' END AS cap33, 
					CASE WHEN d.cap4 = 'True' THEN 'การยึดมั่นในความถูกต้องชอบธรรม และจริยธรรม' END AS cap44, 
					CASE WHEN d.cap5 = 'True' THEN 'การทำงานเป็นทีม' END AS cap55, 
					d.budget_year AS budget_year_c, d.del_status, 
					e.approved_leader, e.approved_leader_date, e.approved_directer, e.approved_directer_date, 
					e.trained
		FROM    dbo.tbl_capacity_score a  INNER JOIN
					dbo.tbl_capacity b ON a.type = b.type AND a.class = b.class INNER JOIN
					dbo.tbl_person c ON b.person_id = c.person_id INNER JOIN
					dbo.tbl_course d ON b.budget_year = d.budget_year INNER JOIN
					dbo.tbl_training e ON d.course_id = e.course_id AND c.person_id = e.person_id AND b.period = e.period AND b.budget_year = e.budget_year
		WHERE  (c.person_id = '$person_id') AND (b.budget_year = '$budget_year') AND (b.period = '$period') AND  d.del_status is null 
					 AND e.approved_leader=1 AND e.approved_directer = 1
		
		" ;
			return $this->selectQuery($sql);
	}	
	function getCourseFollow($person_id,$budget_year,$period){
			 $sql = "SELECT  c.person_id, c.person_name, b.budget_year, b.period,  b.position_id, b.position_name, b.type, b.class, b.agency, b.status, 
					b.leader_id, b.cap1, b.cap2, b.cap3, b.cap4, b.cap5, a.score, 
					d.course_id, d.course_name, d.course_agency, d.place, d.sdate,d.edate,d.day,
					CASE WHEN d.profession = 'True' THEN 'สายวิชาชีพ' END AS profession, 
					CASE WHEN d.cap1 = 'True' THEN 'การมุ่งผลสัมฤทธิ์' END AS cap11, 
					CASE WHEN d.cap2 = 'True' THEN 'บริการที่ดี' END AS cap22, 
					CASE WHEN d.cap3 = 'True' THEN 'การสั่งสมความเชี่ยวชาญในงานอาชีพ' END AS cap33, 
					CASE WHEN d.cap4 = 'True' THEN 'การยึดมั่นในความถูกต้องชอบธรรม และจริยธรรม' END AS cap44, 
					CASE WHEN d.cap5 = 'True' THEN 'การทำงานเป็นทีม' END AS cap55, 
					d.budget_year AS budget_year_c, d.del_status, 
					e.approved_leader, e.approved_leader_date, e.approved_directer, e.approved_directer_date, 
					e.trained
		FROM    dbo.tbl_capacity_score a  INNER JOIN
					dbo.tbl_capacity b ON a.type = b.type AND a.class = b.class INNER JOIN
					dbo.tbl_person c ON b.person_id = c.person_id INNER JOIN
					dbo.tbl_course d ON b.budget_year = d.budget_year INNER JOIN
					dbo.tbl_training e ON d.course_id = e.course_id AND c.person_id = e.person_id AND b.period = e.period AND b.budget_year = e.budget_year
		WHERE  (c.person_id = '$person_id') AND (b.budget_year = '$budget_year') AND (b.period = '$period') AND  d.del_status is null 
					 AND e.approved_leader=1 AND e.approved_directer = 1  AND e.trained = 1
		
		" ;
			return $this->selectQuery($sql);
	}	
	function DeleteTraining($budget_year, $period,$person_id,$course_id){  
			$sql = "DELETE FROM [dbo].[tbl_training] WHERE budget_year = '$budget_year'	 and period = '$period'  and person_id = '$person_id'  and course_id = '$course_id' ";
			return $this->sendQuery($sql);
	}
	function CheckedTraining($budget_year, $period,$person_id, $course_id,$trained){
			$sql = "UPDATE [dbo].[tbl_training] SET trained = '$trained' ,update_datetime = getdate()   
				WHERE budget_year = '$budget_year'	 and period = '$period'  and person_id = '$person_id'  and course_id = '$course_id' ";
			return $this->sendQuery($sql);
	}
	function TrainingPrice($budget_year, $period,$person_id, $course_id,$trained_price){
			$sql = "UPDATE [dbo].[tbl_training] SET trained_price = '$trained_price' ,update_datetime = getdate()   
				WHERE budget_year = '$budget_year'	 and period = '$period'  and person_id = '$person_id'  and course_id = '$course_id' ";
			return $this->sendQuery($sql);
	}
	function getFollow_1month($budget_year, $period,$person_id, $course_id){
			$sql = "SELECT	a.course_id,a.person_id,b.person_name, b.position_name, b.class, b.agency, a.job, 
									c.course_name, c.course_agency, c.sdate, c.edate, c.place, c.fee,
									a.result, a.documentation, a.applied_self, a.applied_org, a.recommend, a.insert_datetime, a.approved,
									CAST(a.insert_datetime AS date) AS date1, CAST(a.leader_datetime AS date) AS date2
						FROM	tbl_follow_1month a INNER JOIN
									tbl_capacity b ON a.person_id=b.person_id AND a.budget_year=b.budget_year AND a.period=b.period INNER JOIN
									tbl_course c ON a.course_id=c.course_id 
						WHERE	a.budget_year = '$budget_year' and a.period = '$period' and a.person_id = '$person_id' and a.course_id = '$course_id' " ;
			return $this->selectQuery($sql);
	}	
	function InsertFollow_1month($budget_year, $period,$person_id, $course_id,$job, $result, $documentation, $applied_self,$applied_org, $recommend){   //
		$sql = "INSERT INTO tbl_follow_1month(budget_year, period, person_id,course_id,job, result, documentation, applied_self,applied_org, recommend, insert_datetime ) 
					VALUES('$budget_year', '$period', '$person_id','$course_id','$job', '$result', '$documentation', '$applied_self','$applied_org', '$recommend', getdate() ) ";
			return $this->sendQuery($sql);
	}
		function UpdateFollow_1month($budget_year, $period,$person_id, $course_id,$job, $result, $documentation, $applied_self,$applied_org, $recommend){   //
		$sql = "	UPDATE	tbl_follow_1month
					SET			job='$job', result='$result', documentation='$documentation', applied_self='$applied_self', applied_org = '$applied_org', recommend = '$recommend', update_datetime=getdate() 
					WHERE		budget_year='$budget_year' AND period='$period' AND person_id='$person_id' AND course_id = '$course_id'  ";
			return $this->sendQuery($sql);
	}
	
	///---------Approve---------------//
	function Approvedata($b,$period,$p,$a){
		 $sql = "SELECT        t.budget_year, t.period, p.person_name, c.course_name, c.sdate, c.edate, t.person_id, t.course_id, ISNULL(cast(t.approved_leader as varchar),3) as approved_leader, ISNULL(cast(t.approved_directer as varchar),3) as approved_directer, ca.agency, ca.leader_id
		 ,ISNULL(cast(t.trained as varchar),3) as trained
FROM            tbl_training AS t INNER JOIN
                         tbl_person AS p ON t.person_id = p.person_id INNER JOIN
                         tbl_course AS c ON t.course_id = c.course_id INNER JOIN
                         tbl_capacity AS ca ON t.person_id = ca.person_id

						 WHERE t.budget_year = '$b'	 and t.period = '$period' and ca.leader_id like '$p' and ca.agency like '$a'  " ;
		return $this->selectQuery($sql);
	}
	
	function Approve($p,$a){
		 $sql = "SELECT        tbl_person.person_name, CASE WHEN tbl_course.cap1 = 'True' THEN 'การมุ่งผลสัมฤทธิ์' END AS cap11, CASE WHEN tbl_course.cap2 = 'True' THEN 'บริการที่ดี' END AS cap22, 
                         CASE WHEN tbl_course.cap3 = 'True' THEN 'การสั่งสมความเชี่ยวชาญในงานอาชีพ' END AS cap33, CASE WHEN tbl_course.cap4 = 'True' THEN 'การยึดมั่นในความถูกต้องชอบธรรม และจริยธรรม' END AS cap44, 
                         CASE WHEN tbl_course.cap5 = 'True' THEN 'การทำงานเป็นทีม' END AS cap55, tbl_course.course_name, tbl_course.sdate, tbl_course.edate, tbl_course.fee, tbl_course.place, tbl_course.course_agency, 
                         tbl_training.approved_leader, tbl_training.approved_directer, tbl_training.approved_leader_date, tbl_training.approved_directer_date
FROM            tbl_training INNER JOIN
                         tbl_person ON tbl_training.person_id = tbl_person.person_id INNER JOIN
                         tbl_course ON tbl_training.course_id = tbl_course.course_id
	
	where approved_leader = 1 and approved_directer = 1 " ;
		return $this->selectQuery($sql);
	}
	function Napprove($p,$a){
		 $sql = "SELECT        tbl_person.person_name, CASE WHEN tbl_course.cap1 = 'True' THEN 'การมุ่งผลสัมฤทธิ์' END AS cap11, CASE WHEN tbl_course.cap2 = 'True' THEN 'บริการที่ดี' END AS cap22, 
                         CASE WHEN tbl_course.cap3 = 'True' THEN 'การสั่งสมความเชี่ยวชาญในงานอาชีพ' END AS cap33, CASE WHEN tbl_course.cap4 = 'True' THEN 'การยึดมั่นในความถูกต้องชอบธรรม และจริยธรรม' END AS cap44, 
                         CASE WHEN tbl_course.cap5 = 'True' THEN 'การทำงานเป็นทีม' END AS cap55, tbl_course.course_name, tbl_course.sdate, tbl_course.edate, tbl_course.fee, tbl_course.place, tbl_course.course_agency, 
                         tbl_training.approved_leader, tbl_training.approved_directer, tbl_training.approved_leader_date, tbl_training.approved_directer_date
FROM            tbl_training INNER JOIN
                         tbl_person ON tbl_training.person_id = tbl_person.person_id INNER JOIN
                         tbl_course ON tbl_training.course_id = tbl_course.course_id
	
	where approved_leader = 0 and approved_directer = 0 " ;
		return $this->selectQuery($sql);
	}
	function getdataApproved_1($budget_year, $period,$person_id, $course_id){
		 $sql = "SELECT *  FROM [test].[dbo].[tbl_follow_1month]
					WHERE		budget_year='$budget_year' AND period='$period' AND person_id='$person_id' AND course_id = '$course_id'  " ;
		return $this->selectQuery($sql);
	}
	function UpdateRegApproved_1($budget_year, $period,$person_id, $course_id,$approved){   //
		 $sql = "	UPDATE	tbl_follow_1month
					SET			approved='1', leader_datetime=getdate() 
					WHERE		budget_year='$budget_year' AND period='$period' AND person_id='$person_id' AND course_id = '$course_id'  ";
			return $this->sendQuery($sql);
	}
	function getdataApproved_3($budget_year, $period,$person_id, $course_id){
		 $sql = "SELECT	*, CAST(insert_datetime AS date) AS date1, CAST(subordinate_datetime AS date) AS date2
		 			FROM 	tbl_follow_3month
					WHERE	budget_year='$budget_year' AND period='$period' AND person_id='$person_id' AND course_id = '$course_id'  " ;
		return $this->selectQuery($sql);
	}
	function InsertApproved_3($budget_year, $period,$person_id, $course_id,$applied_level, $applied_desc, $satisfaction_level, $satisfaction_desc, $recommend){   //
		 $sql = "INSERT INTO tbl_follow_3month(budget_year, period, person_id, course_id, applied_level, applied_desc,satisfaction_level,satisfaction_desc,recommend,insert_datetime) 
		VALUES('$budget_year', '$period', '$person_id', '$course_id', '$applied_level', '$applied_desc', '$satisfaction_level', '$satisfaction_desc', '$recommend', getdate())  ";
			return $this->sendQuery($sql);
	}
		function UpdateApproved_3($budget_year, $period,$person_id, $course_id,$applied_level, $applied_desc, $satisfaction_level, $satisfaction_desc, $recommend){   //
		 $sql = "	UPDATE	tbl_follow_3month
					SET			applied_level='$applied_level', applied_desc='$applied_desc', satisfaction_level='$satisfaction_level', satisfaction_desc='$satisfaction_desc', recommend ='$recommend', update_datetime=getdate() 
					WHERE		budget_year='$budget_year' AND period='$period' AND person_id='$person_id' AND course_id = '$course_id'  ";
			return $this->sendQuery($sql);
	}
	function UpdateRegApproved_3($budget_year, $period,$person_id, $course_id,$approved){   //
		 $sql = "	UPDATE	tbl_follow_3month
					SET			approved='1', subordinate_datetime=getdate() 
					WHERE		budget_year='$budget_year' AND period='$period' AND person_id='$person_id' AND course_id = '$course_id'  ";
			return $this->sendQuery($sql);
	}
	function UpdatePwd($pid, $pwd, $email, $tel){
		$sql = "UPDATE tbl_userpass SET password='$pwd', email='$email', tel='$tel', status='active', update_datetime=getdate() WHERE username='$pid' ";
		return $this->sendQuery($sql);
	}
	
	function UpdateInfo($budget_year, $period, $pid, $agency, $leader){
		$sql = "UPDATE tbl_capacity SET agency='$agency', leader_id='$leader', update_datetime=getdate() WHERE budget_year='$budget_year' AND period='$period' AND person_id='$pid' ";
		return $this->sendQuery($sql);
	}

	function ResetPwd($pid){
		$sql = "UPDATE tbl_userpass SET password='User', status='inactive', update_datetime=getdate() WHERE username='$pid'  ";
		return $this->sendQuery($sql);
	}
	
	function UpdateLeader($pid, $leader){
		$sql = "UPDATE tbl_capacity SET leader_id='$leader' WHERE person_id='$pid' AND budget_year+period=(SELECT MAX(budget_year+period) FROM tbl_capacity) ";
		return $this->sendQuery($sql);
	}
	
	function getBudget_year_periodDESC(){
		$sql = "SELECT		DISTINCT budget_year, period
					FROM		tbl_capacity
					ORDER BY	budget_year DESC, period DESC";
		return $this->selectQuery($sql);
	}
	
	function getBudget_year_periodASC(){
		$sql = "SELECT		DISTINCT budget_year, period
					FROM		tbl_capacity
					ORDER BY	budget_year ASC, period ASC";
		return $this->selectQuery($sql);
	}
	function getBudget_yearDESC(){
		$sql = "SELECT		DISTINCT budget_year
					FROM		tbl_capacity
					ORDER BY	budget_year DESC";
		return $this->selectQuery($sql);
	}
	
	function getBudget_yearASC(){
		$sql = "SELECT		DISTINCT budget_year
					FROM		tbl_capacity
					ORDER BY	budget_year ASC";
		return $this->selectQuery($sql);
	}
	
	function getBudget_yearPms(){
		$sql = "SELECT		DISTINCT budget_year, period
					FROM		Main
					ORDER BY	budget_year ASC, period ASC";
		return $this->selectQuery($sql);
	}
	
	function CntPms($budget_year_period){
		$sql = "SELECT	COUNT(*) AS total
					FROM	Main
					WHERE	budget_year+STR(period,1)='$budget_year_period'";
		return $this->selectQuery($sql);
	}
	
	function CntIdp($budget_year_period){
		$sql = "SELECT	COUNT(*) AS total
					FROM	tbl_capacity
					WHERE	budget_year+STR(period,1)='$budget_year_period'";
		return $this->selectQuery($sql);
	}

	function PmstoIdp($budget_year_period){
		$sql = "INSERT	tbl_capacity(budget_year, period, person_id, person_name, position_id, position_name, type, class, agency, status, capacity_detail, insert_datetime)
					SELECT	a.budget_year, a.period, a.person_id, b.person_name, position_id, position_name, type, class, agency, note, capacity_detail, getdate()
					FROM	Main a INNER JOIN
								Person b ON a.person_id = b.person_id
					WHERE	budget_year+STR(period,1)='$budget_year_period' ";
		return $this->sendQuery($sql);
	}
	
	function UpdatePerson($budget_year_period){
		$sql = "UPDATE	c
					SET		c.person_name = b.person_name, update_datetime = getdate()
					FROM	Main a INNER JOIN
								Person b ON a.person_id = b.person_id LEFT OUTER JOIN
								tbl_person c ON a.person_id = c.person_id
					WHERE	a.budget_year+STR(a.period,1) = '$budget_year_period' AND a.person_id = c.person_id AND b.person_name <> c.person_name";
		return $this->sendQuery($sql);
	}
	
	function InsertPerson($budget_year_period){
		$sql = "INSERT	tbl_person(person_id, person_name, insert_datetime)
					SELECT	a.person_id, b.person_name, getdate()
					FROM	Main a INNER JOIN
								Person b ON a.person_id = b.person_id LEFT OUTER JOIN
								tbl_person c ON a.person_id = c.person_id
					WHERE	a.budget_year+STR(a.period,1)='$budget_year_period' AND c.person_id IS NULL ";
		return $this->sendQuery($sql);
	}

	function InsertUser($budget_year_period){
		$sql = "INSERT	tbl_userpass(username, password, status, role, agency, insert_datetime)
					SELECT	a.person_id, 'User', 'inactive', CASE a.status WHEN 'ผู้ปฏิบัติ' THEN 'user' WHEN 'หัวหน้า' THEN 'poweruser' END, a.agency, getdate()
					FROM	tbl_capacity a LEFT OUTER JOIN
								tbl_userpass c ON a.person_id = c.username
					WHERE	a.budget_year+STR(a.period,1)='$budget_year_period' AND c.username IS NULL ";
		return $this->sendQuery(iconv("tis-620", "utf-8", $sql));
	}
	
	function getPersonDevelop($budget_year, $period, $leader_id, $agency, $trained){
		$sql = "SELECT		a.person_id, a.person_name, a.position_name, a.position_id, a.class, a.capacity_detail, MAX(CAST (b.trained AS int)) AS trained
					FROM		tbl_capacity a LEFT OUTER JOIN
									tbl_training b ON a.budget_year = b.budget_year AND a.period = b.period AND a.person_id = b.person_id
					WHERE		a.budget_year = '$budget_year' and a.period = '$period' and ISNULL(a.leader_id, '') like '$leader_id' and a.agency like '$agency' and ISNULL(b.trained, '') like '$trained'
					GROUP BY	a.person_id, a.person_name, a.position_name, a.position_id, a.class, a.capacity_detail";
//			$sql = "SELECT        p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, c.leader_id, c.cap1, c.cap2, c.cap3, c.cap4, c.cap5, c.insert_datetime, c.update_datetime, 
//                         m.score, SUM(c.cap1 - m.score) AS score1, SUM(c.cap2 - m.score) AS score2, SUM(c.cap3 - m.score) AS score3, SUM(c.cap4 - m.score) AS score4, SUM(c.cap5 - m.score) AS score5, c.position_id AS Expr1, 
//                         u.email
//FROM            tbl_capacity AS c INNER JOIN
//                         tbl_capacity_score AS m ON c.type = m.type AND c.class = m.class INNER JOIN
//                         tbl_person AS p ON c.person_id = p.person_id INNER JOIN
//                         tbl_userpass AS u ON p.person_id = u.username
//WHERE       (c.budget_year = '$budget_year') AND (c.period = '$period')  AND (c.cap1 < m.score) OR
//                         (c.budget_year = '$budget_year') AND (c.period = '$period') AND (c.cap2 < m.score) OR
//                         (c.budget_year = '$budget_year') AND (c.period = '$period') AND (c.cap3 < m.score) OR
//                          (c.budget_year = '$budget_year') AND (c.period = '$period') AND (c.cap4 < m.score) OR
//                          (c.budget_year = '$budget_year') AND (c.period = '$period') AND (c.cap5 < m.score)
//GROUP BY p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, c.leader_id, c.cap1, c.cap2, c.cap3, c.cap4, c.cap5, c.insert_datetime, c.update_datetime, 
//                         m.score, u.email" ;
			return $this->selectQuery($sql);
	}	
	
	function getUDevelop($budget_year,$period){
			$sql = "	SELECT        p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, co.profession, co.cap1, co.cap2, co.cap3, co.cap4, co.cap5
FROM            tbl_capacity AS c INNER JOIN
                         tbl_person AS p ON c.person_id = p.person_id INNER JOIN
                         tbl_training AS t ON c.budget_year = t.budget_year AND c.period = t.period AND c.person_id = t.person_id INNER JOIN
                         tbl_course AS co ON t.budget_year = co.budget_year AND t.course_id = co.course_id
WHERE       (c.budget_year = '$budget_year') AND (c.period = '$period') and t.trained = '1'
GROUP BY p.person_id, p.person_name, c.budget_year, c.period, c.position_id, c.position_name, c.type, c.class, c.agency, c.status, t.person_id, co.profession, co.cap1, co.cap2, co.cap3, co.cap4, co.cap5" ;
			return $this->selectQuery($sql);
	}	
	
	function UpdatePersonById($pid, $name){
		$sql = "UPDATE tbl_person SET person_name='$name', update_datetime=getdate() WHERE person_id='$pid' ";
		return $this->sendQuery($sql);
	}
	function UpdatePersonPeriod($budget_year_period, $pid, $agency, $status, $leader_id){
		$sql = "UPDATE tbl_capacity SET agency='$agency', status='$status', leader_id='$leader_id', update_datetime=getdate() WHERE person_id='$pid' AND budget_year+STR(period,1)='$budget_year_period' ";
		return $this->sendQuery($sql);
	}
	
	function getemail($a){
			$sql = "	SELECT        email, status, role, agency
						FROM            tbl_userpass
						WHERE        (email IS NOT NULL) AND (agency LIKE '$a') and role <> 'admin' " ;
			return $this->selectQuery($sql);
	}	
	
	function getemail_leader($budget_year, $period, $pid){
		$sql = "	SELECT	a.person_name, b.email, c.person_name AS leader_name
					FROM	tbl_capacity a INNER JOIN
								tbl_userpass b ON a.leader_id=b.username  INNER JOIN
								tbl_person c ON b.username=c.person_id
					WHERE	a.budget_year = '$budget_year' AND a.period = '$period' AND a.person_id = '$pid' " ;
		return $this->selectQuery($sql);
	}	
	
	function Cap_PmstoIdp($budget_year_period){
		$sql = "INSERT	tbl_capacity_main(budget_year, period, capacity_name)
					SELECT	budget_year, period, capacity_name
					FROM	Capacity
					WHERE	RTRIM(budget_year)+STR(period,1)='$budget_year_period' ";
		return $this->sendQuery($sql);
		 
	}
	
	function UpdateRole($pid, $role){
		$sql = "UPDATE tbl_userpass SET role='$role' WHERE username='$pid' ";
		return $this->sendQuery($sql);
	}
	
	function getAllAdmin(){
		$sql = "SELECT		a.agency, b.username, b.password
					FROM		(
									SELECT		DISTINCT agency
									FROM		tbl_capacity
									)a LEFT OUTER JOIN
									(
									SELECT	*
									FROM	tbl_userpass
									WHERE	role='superuser'
									)b ON a.agency = b.agency
					ORDER BY	a.agency";
		return $this->selectQuery($sql);
	}
	
	function getAdmin($agency){
		$sql = "	SELECT	*
					FROM	tbl_userpass
					WHERE	role='superuser' AND agency='$agency' ";
		return $this->selectQuery($sql);
	}	
	
	function InsertAdmin($agency, $User, $Pass){
		$sql = "INSERT INTO tbl_userpass(agency, username, password, status, role, insert_datetime) VALUES('$agency', '$User', '$Pass', 'active', 'superuser', getdate()) ";
		return $this->sendQuery($sql);
	}
	
	function UpdateAdmin($agency, $User, $Pass){
		$sql = "UPDATE tbl_userpass SET username='$User', password='$Pass', update_datetime=getdate() WHERE agency='$agency' AND role='superuser' ";
		return $this->sendQuery($sql);
	}
	
	function Approvemail($a){
		$sql = "select		email, b.person_id, b.person_name
					from		tbl_userpass a INNER JOIN
								tbl_person b ON a.username=b.person_id
					where	username = '$a'";
		return $this->selectQuery($sql);
	}
	
	function Rep1($budget_year, $period, $agency, $pid){
		$sql = "	SELECT		*
					FROM		tbl_capacity
					WHERE		budget_year = '$budget_year' and period = '$period' and agency like '$agency' and person_id like '$pid'
					ORDER BY	position_id";
		return $this->selectQuery($sql);
	}
	
	function Rep3($budget_year, $period, $agency, $pid){
		$sql = "	SELECT	a.person_name, a.position_name, a.class, c.course_name, c.capacity, c.skill, c.profession, c.idp, c.fee, b.trained_price
					FROM	tbl_capacity a INNER JOIN
								tbl_training b ON a.budget_year = b.budget_year AND a.period = b.period AND a.person_id = b.person_id INNER JOIN
								tbl_course c ON b.course_id=c.course_id
					WHERE	a.budget_year = '$budget_year' AND a.period = '$period' AND a.agency like '$agency' AND b.trained = 1 and a.person_id like '$pid' ";
		return $this->selectQuery($sql);
	}

	
}
?>