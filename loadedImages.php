<?php
$uploadPath = 'uploads/';
$uploadArray = glob("$uploadPath*.{jpeg,jpg,png,JPEG,JPG,PNG}", GLOB_BRACE);
$home = $_SERVER['DOCUMENT_ROOT'] . "/";

if (isset($_GET['cBox'])) {
    foreach ($_GET['cBox'] as &$i) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $uploadArray[($i)]);
    }
    header('Location: /loadedImages.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Loaded Images</title>
</head>
<body>
<h1>Страница с вашими картинками</h1>
<div>
    <form id="deleteForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <?php for ($i = 0, $countArray = count($uploadArray); $i < $countArray; $i++) { ?>
            <pre>
           <div class="imgPost">
            <img src=<?php echo $uploadArray[$i] ?>>

<p><?php echo 'Название картинки: ' . str_replace($uploadPath, '', $uploadArray[$i]); ?></p>
<span>Удалить картинку:</span><input
                       type="checkbox"
                       name="cBox[<?php echo $i; ?>]"
                       value="<?php echo $i; ?>">
           </div>
         </pre>
        <?php }
        unset($i); ?>
        <input type="submit" value="Удалить картинки">
        <button><a href="/images.php">Вернуться обратно к загрузкам</a></button>
    </form>
</div>
</body>
</html>



