<?php 
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");
require_once("connect.php");


    if(isset($_GET['image']) && $_GET['image'] == "yes"){
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz'; //random file name

    $Image = $_FILES['files']['name'][0];
    $Type = $_FILES['files']['type'][0];
    $Temp = $_FILES['files']['tmp_name'][0];
    $size = $_FILES['files']['size'][0];


    $ImageExt = explode('.',$Image);
    $ImgCorrectExt = strtolower(end($ImageExt));
    $Allow = array('jpg','jpeg','png');
    $Image = substr(str_shuffle($permitted_chars), 0, 10) . '.' . $ImgCorrectExt; // random string de 10 chars
    $target = "../images/".$Image;
   

    $result['responseCode'] = 200;
    $result['imgName'] = $Image;

    if(in_array($ImgCorrectExt, $Allow)){
    if($size<2097152)
        move_uploaded_file($Temp,$target);
    else $result['responseCode']=400;}
    else $result['responseCode']=400;

    
    
    echo json_encode($result);
    }
    else {

    if ((isset($_GET['name']) && $_GET['name']!="") && (isset($_GET['description']) && $_GET['description']!="")
    && (isset($_GET['country']) && $_GET['country']!="") &&(isset($_GET['type']) && $_GET['type']!="") 
    &&(isset($_GET['category']) && $_GET['category']!="") &&(isset($_GET['price']) && $_GET['price']!="") 
    &&(isset($_GET['img']) && $_GET['img']!="")) {

        


    $stmt = mysqli_prepare($conn, "INSERT INTO items (name, description, country, type, category, price, img) VALUES
    (?,?,?,?,?,?,?) ");

    mysqli_stmt_bind_param($stmt, 'sssssss',$_GET['name'],$_GET['description'], $_GET['country'], $_GET['type'], $_GET['category'],
    $_GET['price'], $_GET['img']);

    if(mysqli_stmt_execute($stmt) == true)
        $response['responseCode'] = 200;
    else
        $response['responseCode'] = 400;
    mysqli_stmt_close($stmt);
    echo json_encode($response);
    // echo "ok";
    // echo base64_decode($_GET['img']);

    }
    else {
        $response['responseCode'] = 404;
        echo json_encode($response);
    }}
?>