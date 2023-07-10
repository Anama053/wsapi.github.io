<?php
include 'conexion.php';

$pdo=new Conexion();
 if($_SERVER['REQUEST_METHOD']== 'GET'){
    $sql = $pdo->prepare("SELECT * FROM peliculast");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header ("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit;
 }

 if($_SERVER['REQUEST_METHOD']=='POST'){
    $sql = "INSERT INTO  peliculast (nombre, lanzamiento, duracion) VALUES (:nombre, :lanzamiento, :duracion)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':nombre', $_POST['nombre']);
    $stmt->bindValue(':lanzamiento', $_POST['lanzamiento']);
    $stmt->bindValue(':duracion', $_POST['duracion']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();
    if($idPost){
        header("HTTP/1.1 200 OK");
        echo json_encode($idPost);
        exit;
    }
 }

 if($_SERVER['REQUEST_METHOD']=='PUT'){
    $sql = "UPDATE peliculast SET nombre=:nombre, lanzamiento=:lanzamiento, duracion=:duracion WHERE id=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->bindValue(':nombre', $_GET['nombre']);
    $stmt->bindValue(':lanzamiento', $_GET['lanzamiento']);
    $stmt->bindValue(':duracion', $_GET['duracion']);
    //$stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    header("HTTP/1.1 200 OK");  
    exit;
 }

 if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	{
		$sql = "DELETE FROM peliculast WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	header("HTTP/1.1 400 Bad Request");
?>
