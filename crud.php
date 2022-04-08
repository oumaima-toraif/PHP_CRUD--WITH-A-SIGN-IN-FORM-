<?php
require('connection.php');
function image_upload($img){
    $tmp_loc = $img['tmp_name'];
    $new_name = random_int(11111,99999).$img['name'];
    $new_loc=UPLOAD_SRC.$new_name;
    if(!move_uploaded_file($tmp_loc,$new_loc)){
        header("location:products.php?alert=img_upload");
        exit;
    }else
     return $new_name; 
}
function image_remove($img){
    
    if(!unlink(UPLOAD_SRC. $img)){
    
     header("location:products.php?alert=img_rem_fail");
       exit;
    }
  
   
}
if(isset($_POST['addproduct']))
{
  foreach($_POST as $key=>$value){
   $_POST[$key] = mysqli_real_escape_string($con, $value);
  }
$imgpath=image_upload($_FILES['image']);
$query="INSERT INTO `products`(`name`, `price`, `image`) VALUES ('$_POST[name]','$_POST[price]','$imgpath')";
if(mysqli_query($con,$query))
    header("location:products.php?success=added");
else
    header("location:products.php?alert=add_failed");
}
if(isset($_GET['rem']) && $_GET['rem']>0){

    $query1="SELECT * FROM `products`  WHERE `id_product`='$_GET[rem]'";
    $result1=mysqli_query($con,$query1);
    $fetch=mysqli_fetch_assoc($result1);
    $img=$fetch['image'];
    $query2="DELETE FROM `products` WHERE `id_product`='$_GET[rem]'";
    $result2=$con->query($query2) or die($con->error);
    image_remove($img);
     if(mysqli_query($con,$query2))
     header("location:products.php?success=removed");
 else
     header("location:products.php?alert=remove_failed");

    }

if(isset($_POST[ 'editproduct']))
{
    
 foreach($_POST as $key => $value){
    $_POST[$key] = mysqli_real_escape_string($con, $value);
 }
 $intprice=intval($_POST['price']);
  if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])){
    $query="SELECT * FROM `products` WHERE `id_product`='$_POST[id_product]'";
    $result=mysqli_query($con, $query);
    $fetch=mysqli_fetch_assoc($result);
    image_remove($fetch['image']);
    $imgpath=image_upload($_FILES['image']);
    $update="UPDATE `products` SET `name`='$_POST[name]',`price`='$intprice',`image`='$imgpath' WHERE `id_product`='$_POST[id_product]'";  
}

else{
    
    $update="UPDATE `products` SET `name`='$_POST[name]',`price`='$intprice' WHERE `id_product`='$_POST[id_product]'";      
    
}
if(mysqli_query($con,$update)){
    header("location:products.php?success=updated");
}
else{
    header("location:products.php?alert=update_failed");
}
}
?>