<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        

if (isset($_POST['fname'])      &&
    isset($_POST['lname'])      &&
    isset($_POST['username'])   &&
    isset($_POST['student_id']) &&
    isset($_POST['address'])    &&
    isset($_POST['email_address']) &&
    isset($_POST['gender'])        &&
    isset($_POST['date_of_birth'])    &&
    isset($_POST['parent_fname'])  &&
    isset($_POST['parent_lname']) &&
    isset($_POST['grade'])) {
    
    include '../../DB_connection.php';
    include "../data/student.php";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['username'];

    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $email_address = $_POST['email_address'];
    $date_of_birth = $_POST['date_of_birth'];
    $parent_fname = $_POST['parent_fname'];
    $parent_lname = $_POST['parent_lname'];

    $student_id = $_POST['student_id'];
    
    $grade = $_POST['grade'];

    $data = 'student_id='.$student_id;

    if (empty($fname)) {
        $em  = "Prénom à remplir";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Nom à remplir";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($uname)) {
        $em  = "Nom d'utilisateur à remplir";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (!unameIsUnique($uname, $conn, $student_id)) {
        $em  = "Déja approprié";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($address)) {
        $em  = "Addresse à remplir";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($gender)) {
        $em  = "Sexe à remplir";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($email_address)) {
        $em  = "Email à remplir";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($date_of_birth)) {
        $em  = "Date de naissance obligatoire";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($parent_fname)) {
        $em  = "Prénom du parent obligatoire";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($parent_lname)) {
        $em  = "Nom du parent obliagtoire";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else {
        $sql = "UPDATE students SET
                username = ?, fname=?, lname=?, grade=?, address=?,gender = ?, section=?, email_address=?, date_of_birth=?, parent_fname=?,parent_lname=?,parent_phone_number=?
                WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname,$fname, $lname, $grade, $address, $gender,$section, $email_address, $date_of_birth, $parent_fname, $parent_lname,$parent_phone_number, $student_id]);
        $sm = "Bien Modifier";
        header("Location: ../student-edit.php?success=$sm&$data");
        exit;
    }
    
  }else {
    $em = "Une erreur est survenu";
    header("Location: ../student.php?error=$em");
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
