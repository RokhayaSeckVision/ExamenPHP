<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['course_name']) &&
    isset($_POST['course_code']) && 
    isset($_POST['grade'])) {
    
    include '../../DB_connection.php';

    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $grade = $_POST['grade'];

  if (empty($course_name)) {
		$em  = "Matière à remplir";
		header("Location: ../course-add.php?error=$em");
		exit;
	}else if(empty($course_code)) {
    $em  = "Code de la Matière à remplir";
    header("Location: ../course-add.php?error=$em");
    exit;
  }else if (empty($grade)) {
		$em  = "Niveau à remplir";
		header("Location: ../course-add.php?error=$em");
		exit;
	}else {
        // check if the class already exists
        $sql_check = "SELECT * FROM subjects 
                      WHERE grade=? AND subject_code=?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$grade, $course_code]);
        if ($stmt_check->rowCount() > 0) {
           $em  = "Matière deja existant";
           header("Location: ../course-add.php?error=$em");
           exit;
        }else {
          $sql  = "INSERT INTO
                 subjects(grade, subject, subject_code)
                 VALUES(?,?,?)";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$grade, $course_name, $course_code]);
          $sm = "Nouvelle matière crée";
          header("Location: ../course-add.php?success=$sm");
          exit;
        } 
	}
    
  }else {
  	$em = "Erreur durant l'execution";
    header("Location: ../course-add.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 
