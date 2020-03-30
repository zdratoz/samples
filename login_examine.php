<?php
session_start();
// Λαμβανω βηματα πίσω για να βρεθώ στο root $_POST['myUrl']
include_once ( $_SESSION["ROOT_PATH"] .  '/config.php'); 
include_once ( ROOT_PATH . '/BSP/php/BspFunctions.php'); 

    error_log("Login Info:" . $_POST['username']     ,0);

    $username=esc($_POST['username']);
    $password=esc($_POST['pass']);

    $errors=array();
    if (empty($username))   {array_push($errors,"Username required");}
    if (empty($password))   {array_push($errors,"Password required");}
    $xx=getRecordCollection("SELECT users.* , hotels.name FROM users LEFT JOIN hotels ON hotel_ID = hotels.ID   WHERE UPPER(UserName)='@01' AND `Password`='@02' AND `SUPER_USER`=1 AND  `Active`=1 ", 
                            array(
                                    strtoupper($username),
                                    ($password)
                                )
                            );


    if(!empty($xx)){
        
        echo json_encode(array(
            'UserID'    =>$xx[0]['ID'],
            'UserName'  =>$xx[0]['FirstName']." ".$xx[0]['LastName'],
            'WorkPlace'=>$xx[0]['name'],
            'WorkID'=> $xx[0]['Hotel_ID'],   
            'success'   =>1
        ));
        
    }else{
        echo json_encode(array(
            'success'   =>0
        ));    
    }
//End of code


?>



