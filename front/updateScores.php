<?php 
	require_once 'teacherheader.php';

	$username = $_SESSION["username"];
	$role = $_SESSION["role"];
	$URL= 'https://afsaccess4.njit.edu/~nk82/middle_pullGrades.php';
	$post_params="username=$username&role=$role";
	$ch = curl_init();
	$options = array(CURLOPT_URL => $URL,
				         CURLOPT_HTTPHEADER =>
	array('Content-type:application/x-www-form-urlencoded'),
					 CURLOPT_RETURNTRANSFER => TRUE,
					 CURLOPT_POST => TRUE,
					 CURLOPT_POSTFIELDS => $post_params);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	$decodedData = json_decode($result, true);
	#echo $result;

	if (isset($_POST['submit']))
	{
		$_SESSION['examID'] = $_POST['id'];
		$_SESSION['Susername'] = $_POST['username'];

		echo "<script type=\"text/javascript\">
		window.location.href = 'updates.php';
		</script>";

	}

	echo "<table>";
	
		echo "<tr>";
			echo "<th> Username </th>";
			echo "<th> Exam ID </th>";
			echo "<th> Test Name </th>";
			/*
			echo "<th> Earned Points </th>";
			echo "<th> Updated Points </th>";
			echo "<th> Grade </th>";
			echo "<th> Comments </th>";
			*/
		echo "</tr>";

	for ($i = 0; $i < sizeof($decodedData['examID']); $i++){
		echo "<tr>";
		echo "<form action=\"\" method=\"post\">";
			echo "<td>";
				echo $decodedData['username'][$i];
			echo "</td>";

			echo "<td>";
				echo $decodedData['examID'][$i];
			echo "</td>";

			echo "<td>";
				echo $decodedData['testName'][$i];
			echo "</td>";

			echo "<td>";
				echo "<input type=\"hidden\" id=\"id\" name=\"id\" value='".$decodedData['examID'][$i]."'>";
				echo "<input type=\"hidden\" id=\"username\" name=\"username\" value='".$decodedData['username'][$i]."'>";
				echo "<input name=\"submit\" type=\"submit\" value='Update Exam'>";
			echo "</td>";
			/*
			$response = explode("?", $decodedData['earnedPoints'][$i]);
			echo "<td style=\"height:100px;width:150px;text-align:center;\">";
			foreach ($response as $ans){
			  echo $ans;
			  echo "</br>";
			}
			echo "</td>";

			$response = explode("?", $decodedData['updatedPoints'][$i]);
			echo "<td style=\"style=\"height:100px;width:150px;text-align:center;\">";
			foreach ($response as $ans){
			  echo $ans;
			  echo "</br>";
			}
			echo "</td>";

			echo "<td>";
				echo $decodedData['grade'][$i];
			echo "</td>";

			echo "<td>";
				echo $decodedData['comments'][$i];
			echo "</td>";
			*/
			echo "</form>";
		echo "</tr>";
	}
	
	echo "</table>";
?>

<head>
	<title>Update Scores</title>
</head>