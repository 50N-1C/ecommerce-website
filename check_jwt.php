<?
if (!(isset($_COOKIE["jwt_token"]))) {
	header("Location:adminLogin.php");
    exit();
}
?>