<?php
//Superglobal
$querySent = true;
if(isset($_GET['q'])){
    $query = htmlspecialchars($_GET['q']);
} else {
    $querySent = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="search-container">

    <?php
    if($querySent){
        echo "<div class='search-result'><h2>You are searching for <span style='color:#6a11cb;'>". $query ."</span>
        </h2> </div>";
    } else {
        echo "<div class='search-error'><h2 style='color: red;'>Missing query parameter</h2></div>";
    }
    ?>
 <div class="search-text">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Facere ex commodi, aliquid amet adipisci perspiciatis quam, unde, 
        nemo quos ipsa est voluptatibus harum.
    </div>

</div>
<?php
include "components/footer.php";
?>
</body>
</html>