
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msj = filter_input(INPUT_POST, 'msj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $post = dechex(rand());
    $color = rand(0, 6);
    $colors = ['#aaffff', '#ffaaff', '#ffaaff', '#ccccff', '#ffcccc', '#ffccff', '#ffffaa'];
    $back = $colors[$color];

    $msj = str_replace("[[", "<a href=\"#", $msj);
    $msj = str_replace("]]", "\">otro post</a>", $msj);
    $newPost = '<div style="background-color:' . $back . ';"><a name="' . $post . '"><b>' . $post . '</b></a> - ' . $msj . '</div><hr>';
    
    $bbs = $newPost . file_get_contents('bbs.htm');
    file_put_contents('bbs.htm', $bbs);
    header("Location: ./");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message Board</title>
</head>
<body>
    <center>
        <form method="POST">
            <textarea name="msj"></textarea><br/><br/>
            <input type="submit" value="Send">
        </form>
    </center>
    <br/>

    <?php
    if (!file_exists("bbs.htm")) {
        file_put_contents("bbs.htm", '');
    }

    $file = fopen("bbs.htm", "r");
    while (!feof($file)) {
        echo fgets($file) . "<br />";
    }
    fclose($file);
    ?>
</body>
</html>
