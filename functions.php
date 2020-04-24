<?php 
// helper function

function redirect($location){

return header("Location: $location ");


}

function last_id(){

global $connection;

return mysqli_insert_id($connection);


}

function query($sql) {

global $connection;

return mysqli_query($connection, $sql);


}


function confirm($result){

global $connection;

if(!$result) {

die("QUERY FAILED " . mysqli_error($connection));


	}


}

function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }



}






function escape_string($string){

global $connection;

return mysqli_real_escape_string($connection, $string);


}



function fetch_array($result){

return mysqli_fetch_array($result);


}

function set_message($msg){

if(!empty($msg)) {

$_SESSION['message'] = $msg;

} 
    else
{
    
$msg = "";

    }

}



function display_image($picture) {

global $upload_directory;

return $upload_directory  . $picture;



}

function show_product_category_title($p_category_id){

$category_query = query("SELECT * FROM category WHERE c_id = '{$p_category_id}' ");
confirm($category_query);

while($category_row = fetch_array($category_query)) {

return $category_row['c_title'];
}


}


function add_product() 
{    
if(isset($_POST['publish'])) 
{
$p_title  = escape_string($_POST['p_title']);
$p_category_id  = escape_string($_POST['p_category_id']);
$p_price          = escape_string($_POST['p_price']);
$p_description    = escape_string($_POST['p_description']);
$desc = escape_string($_POST['desc']);
$p_quantity       = escape_string($_POST['p_quantity']);
$p_image = escape_string($_FILES['file']['name']);
$image_temp_location    = escape_string($_FILES['file']['tmp_name']);

move_uploaded_file($image_temp_location  , img . "$p_image" );

$query = query("INSERT INTO product(p_title, p_category_id, p_price, p_description, desc, p_quantity, p_image) VALUES('{$p_title}', '{$p_category_id}', '{$p_price}', '{$p_description}', '{$desc}', '{$p_quantity}', '{$p_image}')");
$last_id = last_id();
confirm($query);
set_message("New Product with id {$last_id} was Added");
redirect("allproducts.php?products");


        }


}


function show_categories_add_product_page(){


$query = query("SELECT * FROM category");
confirm($query);

while($row = fetch_array($query)) {


$categories_options = <<<DELIMETER

 <option value="{$row['c_id']}">{$row['c_title']}</option>


DELIMETER;

echo $categories_options;

     }



}


function get_products_in_admin() {


$query = query(" SELECT * FROM product");
confirm($query);

while($row = fetch_array($query)) {

$category = show_product_category_title($row['p_category_id']);

$p_image = display_image($row['p_image']);

$product = <<<DELIMETER

        <tr>
            <td>{$row['p_id']}</td>

            <td>

            <div class="thumbnail" style="height:auto" >
                    <img style ="width:20%;height:20%" src="img/{$p_image}" alt="" >
                        
                </div>


            </td>


            <td>{$category}</td>
            <td>{$row['p_price']}</td>
            <td>{$row['p_quantity']}</td>
             <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['p_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

echo $product;


        }





}




 ?>






