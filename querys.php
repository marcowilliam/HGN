<?php

	function get_hours_category($conn, $user_id, $category) {
		$sql = "SELECT t.category_id, SUM(s.sub_task_time) AS hours_category 
				FROM sub_task AS s
					LEFT JOIN user_task AS ut ON s.user_task_id = ut.user_task_id
					LEFT JOIN user AS u ON ut.user_id = u.user_id
					LEFT JOIN task AS t ON ut.task_id = t.task_id
				WHERE u.user_id = {$user_id} AND t.category_id = {$category} AND s.sub_task_type_id = 1
				GROUP BY t.category_id";
		$result = mysqli_query($conn, $sql);
		return $result;
	}

	function get_hours($conn, $user_id, $yearweek_get_hours) {
		$sql = "SELECT YEARWEEK(s.sub_task_date) AS yearweek, SUM(s.sub_task_time) AS hours
				FROM sub_task AS s
					LEFT JOIN user_task AS ut ON s.user_task_id = ut.user_task_id
					LEFT JOIN user AS u ON ut.user_id = u.user_id
				WHERE u.user_id = {$user_id} AND YEARWEEK(s.sub_task_date) = {$yearweek_get_hours} AND s.sub_task_type_id = 1
				GROUP BY YEARWEEK(s.sub_task_date)";
		$result = mysqli_query($conn, $sql);
		return $result;
	}

	function get_quant_lead($conn, $user_id) {
		$sql = "SELECT COUNT(ut.user_id) AS quant_lead
				FROM user_team AS ut
					LEFT JOIN team AS t ON t.team_id = ut.team_id
					LEFT JOIN user AS u ON u.user_id = ut.user_id
				WHERE t.manager = {$user_id} AND t.visibility = 1 AND u.visibility = 1
				GROUP BY ut.user_id";
		$result = mysqli_query($conn, $sql);
		return $result;
	}

	function get_quant_cat($year, $week, $conn, $user_id) {
		$sql = "SELECT COUNT(t.category_id) AS quant_cat 
				FROM task AS t
					RIGHT JOIN user_task AS ut ON ut.task_id = t.task_id
					RIGHT JOIN sub_task AS s ON ut.user_task_id = s.user_task_id
					LEFT JOIN user AS u ON ut.user_id = u.user_id
				WHERE u.user_id = {$user_id} AND YEAR(s.sub_task_date) = {$year} AND WEEK(s.sub_task_date) = {$week}
				GROUP BY t.category_id";
		$result = mysqli_query($conn, $sql);
		return $result;
	}
	
	function get_quant_users_manager($conn, $user_id){
		
		$countTeams = 0;
		$countUsers = 0;
		
		$sql = "SELECT  team_id, visibility
				FROM user_team 
				WHERE user_id = {$user_id} AND visibility = 1";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($result)){
		
			$sql2 = "SELECT team_manager, visibility
					FROM team
					WHERE team_id = {$row['team_id']} AND visibility = 1";
			$result2 = mysqli_query($conn, $sql2);
			while($row2 = mysqli_fetch_assoc($result2)){
			
				if($row2['team_manager'] == $user_id){
				
					$sql3 = "SELECT user_id, visibility
							FROM user_team
							WHERE team_id = {$row['team_id']} AND visibility = 1
							GROUP BY user_id";
					$result3 = mysqli_query($conn, $sql3);
					while($row3 = mysqli_fetch_assoc($result3)){
						$countUsers++;
					}
				}
			}
			
			$teams[$countTeams] = $countUsers;
			$countTeams++;
			$countUsers = 0;
			
		}
		
		return max($teams);
	}
		
	/*
	function number_blue_squares($conn, $user_id, $yearweek_max, $yearweek_min) {
	
		$count = 0;
		
		$sqlExHr = "SELECT user_week_hrs FROM user WHERE user_id = {$user_id}";
		$resultExHr = mysqli_query($conn, $sqlExHr);
		$row = mysqli_fetch_assoc($resultExHr);
		$exHr = $row["user_week_hrs"];
		
		while ($yearweek_max > $yearweek_min) {
			
			if ($yearweek_max%100 == 0){
				$yearweek_max = $yearweek_max - 100 + 53;
			}
			
		
			$result = get_hours($conn, $user_id, $yearweek_max);
			$row = mysqli_fetch_assoc($result);
			$hours = $row["hours"];
			
			if ($hours < $exHr) {
				$count++;
			}
			
			$yearweek_max--;
		}
		
		return $count;
	}



*/
	?>