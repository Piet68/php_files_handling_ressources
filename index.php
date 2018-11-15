<?php include('inc/head.php'); ?>

    C'est ici que tu vas devoir afficher le contenu de tes repertoires et fichiers.

<?php

if (isset($_GET['type'])){
    if ($_GET['type'] == 'delete') {
        if (isset($_GET['var1'])) {
            if (is_dir($_GET['var1'])) {
                rmdir($_GET['var1']);
            }else{
                unlink($_GET['var1']);
            }
        }
    }
}

if (isset($_POST['contenu'])){
    $file = fopen($_POST['file'],"w");
    fwrite($file, $_POST['contenu']);
    fclose($file);
}

$dir = 'files/';
$niveau1 = scandir($dir);
foreach ($niveau1 as $value){
    if ($value == '.' or $value == '..'){
    }else{
        $type1 = mime_content_type('files/'.$value);
        if ($type1 == 'text/plain' or $type1 == 'text/html') {
            echo $value . ' -' . '<a href="index.php?type=delete&var1=files/' . $value . '">(delete)</a>' . '<a href="index.php?type=edit&var1=files/' . $value . '&var2='.$value.'">(edit)</a>'.'<br>';

        }else{
            echo $value . ' -' . '<a href="index.php?type=delete&var1=files/' . $value . '">(delete)</a>' . '<br>';
        }

        if (is_dir('files/'.$value)){
            $dir2 = 'files/'. $value;
            $niveau2 = scandir($dir2);
            foreach ($niveau2 as $value2) {
                if ($value2 == '.' or $value2 == '..') {
                } else {
                    $type2 = mime_content_type('files/'.$value.'/'.$value2);
                    if ($type2 == 'text/plain' or $type2 == 'text/html') {
                        echo ' - '.$value2 . ' -' . '<a href="index.php?type=delete&var1=files/' . $value .'/'. $value2 . '">(delete)</a>' . '<a href="index.php?type=edit&var1=files/' . $value .'/'. $value2 . '&var2='.$value2.'">(edit)</a>'.'<br>';
                    }else{
                        echo ' - '.$value2 . ' -' . '<a href="index.php?type=delete&var1=files/' . $value.'/'.$value2 . '">(delete)</a>' . '<br>';
                    }

                    if (is_dir('files/'.$value.'/'.$value2)){
                        $dir3 = 'files/'. $value . '/' . $value2;
                        $niveau3 = scandir($dir3);
                        foreach ($niveau3 as $value3) {
                            if ($value3 == '.' or $value3 == '..') {
                            } else {
                                $type3 = mime_content_type('files/'.$value.'/'.$value2.'/'.$value3);
                                if ($type3 == 'text/plain' or $type3 == 'text/html') {
                                    echo ' ----- '.$value3 . ' -' . '<a href="index.php?type=delete&var1=files/' . $value .'/'. $value2 .'/'.$value3. '">(delete)</a>' . '<a href="index.php?type=edit&var1=files/' . $value .'/'. $value2 .'/'.$value3. '&var2='.$value3.'">(edit)</a>'.'<br>';
                                }else{
                                    echo ' ----- '.$value3 . ' -' . '<a href="index.php?type=delete&var1=files/' . $value .'/'. $value2 .'/'.$value3. '">(delete)</a>' . '<br>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}



if (isset($_GET['type'])){
    if ($_GET['type'] == 'edit') {

        echo '<form method="POST" action="index.php">';
        echo '<br><br>'.'Edit file : '.$_GET['var2'].'<br>';
        $contenu = file_get_contents($_GET['var1']);
        echo '<textarea name="contenu" style="width:70%; height: 250px">'.$contenu.'</textarea>';
        echo '<input name="file" type="hidden" value="'.$_GET['var1'].'"/>';
        echo '<input type="submit" value="Save changes"/>';
        echo'</form>';
    }
}
?>
<?php include('inc/foot.php'); ?>


