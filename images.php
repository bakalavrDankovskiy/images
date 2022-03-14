<?php
//Вывод ошибок
function uploadError(array $errorArray)
{
    foreach ($errorArray as &$i) {
        echo '<pre>';
        echo 'Произошла ошибка:' . $i;
    }
    unset($i);
}

//МАССИВ ОШИБОК
$errorArray = [];
//ПУТЬ ДЛЯ ФАЙЛОВ
$uploadPath = 'uploads/';

//ПРОВЕРКА НА СУЩЕСТВ. КЛЮЧА $_FILES['myfile']['name']
if (isset($_FILES['myfile']['name'])) {
    if (array_filter($_FILES['myfile']['name']) == array()) {
        echo 'Вы не загрузили картинку(и)';
    } else {
//МАССИВ ИМЕН
        $uplImgName = $_FILES['myfile']['name'];
//МАССИВ ТИПОВ
        $uplImgType = $_FILES['myfile']['type'];
//РАЗМЕР ФАЙЛА
        $uplImgSize = $_FILES['myfile']['size'];
//ПУТЬ К ВРЕМЕННОМУ ФАЙЛУ
        $uplImgTmp = $_FILES['myfile']['tmp_name'];
//РАЗРЕШЕННЫЕ ФОРМАТЫ ФАЙЛОВ
        $appliedFormat = ['image/jpg', 'image/jpeg', 'image/png'];

        //ПРОВЕРКА НА РАСШИРЕНИЕ
        for ($i = 0, $arrSize = count($uplImgName); $i < $arrSize; $i++) {

            if (!(in_array($uplImgType[$i], $appliedFormat))) {
                array_push($errorArray, 'Файл ' . $uplImgName[$i] . ' имеет неверное расширение!');
                unset($uplImgName[$i]);
                unset($uplImgType[$i]);
                unset($uplImgSize[$i]);
                unset($uplImgTmp[$i]);
            }
        }
        unset($i);

        //ПРРОВЕРКА НА РАЗМЕР ФАЙЛА
        foreach ($uplImgName as $key => $value) {
            if ($uplImgSize[$key] > 5242880) {
                array_push($errorArray, 'Размер файла ' . $uplImgName[$key] . ' превышает 5МБ!');
                unset($uplImgName[$key]);
                unset($uplImgType[$key]);
                unset($uplImgSize[$key]);
                unset($uplImgTmp[$key]);
            }
        }
        unset($key);
        unset($value);

        //ПРОВЕРКА НА КОЛИЧЕСТВО ФАЙЛОВ
        while (count($uplImgName) > 5) {
            array_push($errorArray, 'Файл ' . $uplImgName[array_key_last($uplImgName)] . ' был лишним');
            unset($uplImgName[array_key_last($uplImgName)]);
            unset($uplImgType[array_key_last($uplImgType)]);
            unset($uplImgSize[array_key_last($uplImgSize)]);
            unset($uplImgTmp[array_key_last($uplImgTmp)]);
        }

        //НАЗНАЧЕНИЕ НОВОГО РАСШИРЕНИЯ В ИМЕНИ ЕСЛИ РЕГИСТР ВЫСОКИЙ ИЛИ НЕ СООТВ-ЕТ $uplImgType
        foreach ($uplImgName as $key => $value) {
            if ((substr($uplImgName[$key], strpos($uplImgName[$key], '.') + 1) !==
                substr($uplImgType[$key], strpos($uplImgType[$key], '/') + 1))) {
                $subStr = substr($uplImgType[$key], strpos($uplImgType[$key], '/') + 1);
                $strPos = strpos($uplImgName[$key], '.') + 1;
                $uplImgName[$key] = substr_replace($uplImgName[$key], $subStr, $strPos);
                //УДАЛЕНИЕ ВСЕХ ПРОБЕЛОВ ИЗ ИМЕНИ
                $uplImgName[$key] = str_replace(' ', '', $uplImgName[$key]);
            }
        }
        unset($key);
        unset($value);

        //ЕСЛИ ЕСТЬ ОШИБКИ ВЫВЕСТИ
        if (isset($errorArray[array_key_first($errorArray)])) {
            uploadError($errorArray);
        }
        //Отправить картинки на сервер
        foreach ($uplImgName as $key => $value) {
            move_uploaded_file($uplImgTmp[$key], $uploadPath . $value);
        }
        unset($key);
        unset($value);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Load Images</title>
</head>
<body>
<form enctype="multipart/form-data" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <span> Загрузите файл(ы): </span>
    <input type="file" multiple accept="image/jpeg,image/png,image/jpg" name="myfile[]"/>
    <br/>
    <br/>
    <input type="submit" name="upload" value="Загрузить"/>
</form>
<button><a href="loadedImages.php">Страница с вашими картинками</a></button>
</body>
</html>
