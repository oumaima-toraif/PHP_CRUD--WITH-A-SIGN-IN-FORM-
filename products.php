<?php
require("connection.php");
session_start();
if (!isset($_SESSION['email'])){
header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <title> Product Store</title>
 
</head>
<body class="bg-light">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <div class="container bg-primary text-light p-3 rounded my-4 ">
    <div class="d-flex flex-row  justify-content-between align-items-center px-3">
    <h2><a href="index.php"></a><i class="bi bi-bar-chart-fill"></i>Product Store</h2>
    <div>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addproduct"><i class="bi bi-plus"></i>Add Product</button>
    <button onclick="window.location.href='logout.php'" type="button" class="btn btn-secondary"><i class="bi bi-box-arrow-right"></i>Logout</button>
  </div>
  </div>
  </div>
  <div class="container mt-5 p-0">
  <table class="table table-hover text-center">
  <thead class="bg-secondary text-light">
        <tr>
        <th width="10%" scope="col" class="rouned-start">Sr. No.</th>
        <th width="15%" scope="col">Image</th>
        <th width="10%" scope="col">Name</th>
        <th width="10%" scope="col">Price</th>
        <th width="20%" scope="col" class="rounded-end">Action</th>
        </tr>
  </thead>
        <tbody class="bg-white">
            <?php
            $query="SELECT * FROM `products` ";
            $result=mysqli_query($con,$query);
            $i=1;
            $fetch_src=FETCH_SRC;
            while($fetch=mysqli_fetch_assoc($result)){
              echo<<<product
                <tr class="align-middle">
                  <th scope="row">$i</th>
                  <td style="display:none;">$fetch[id_product]</td>
                  <td style="display:none;">$fetch_src$fetch[image]</td>
                  <td><img src="$fetch_src$fetch[image]" width="100px"></td>
                  <td>$fetch[name]</td>
                  <td>$fetch[price] MAD</td>
                  <td>
                  <button class="btn btn-warning me-2 editbtn"><i class="bi bi-pencil-square"></i></button>
                  <button onclick="remove($fetch[id_product])" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                  </td>
                  <input type="hidden" name="del_image" value="$fetch_src$fetch[image]">

                </tr>
                
              product;
              $i++;
            }
            ?>
        </tbody>
</table>
<!--MODAL FOR ADDING NEW PRODUCTS-->
<div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="crud.php" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-secondary">Add Product</h5>
      </div>
      <div class="modal-body">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Name</span>
        </div>
        <input type="text" class="form-control" name="name" required>
        </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Price</span>
        </div>
        <input type="number" class="form-control" name="price" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Image</span>
        </div>
        <input type="file" class="form-control" name="image" accept=".png,.jpg,.svg,.jpeg" required>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" name="addproduct">Add</button>
      </div>
     </div>
     </div>
    </form>
  </div>
</div>
<!--MODAL FOR UPDATING PRODUCTS-->
<div class="modal fade" id="editproduct"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="crud.php" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-secondary">Edit Product</h5>
      </div>
      <div class="modal-body">
      <input type="hidden"  name="id_product" id="id_product">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Name</span>
        </div>
        <input type="text" class="form-control" id="editname" name="name" required>
        </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Price</span>
        </div>
        <input type="text" class="form-control" id="editprice" name="price" required>
      </div>
      <img src="" id="editimg" width="100%" class="mb-3"><br/>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Image</span>
        </div>
        <input type="file" class="form-control" name="image" accept=".png,.jpg,.svg,.jpeg">
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" name="editproduct">Edit</button>
      </div>
     </div>
    </div>
    </form>
  </div>
</div>
 
<script>
function remove(id){

    if(confirm("Are you sure, you want to delete this item ?")){

      window.location.href="crud.php?rem="+id;
       
     }
    }
  $(document).ready(function(){
    $('.editbtn').on('click',function(){
      $('#editproduct').modal('show');
      $tr=$(this).closest('tr');
      var data=$tr.children("td").map(function(){
        return $(this).text();
      }).get();
      //console.log(data);
      $('#id_product').val(data[0]);
      $('#editimg').attr('src',data[1]);
      $('#editname').val(data[3]);
      $('#editprice').val(data[4]);
    
    });
  });
 </script>
</body>
</html>