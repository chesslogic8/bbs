
<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msj = filter_input(INPUT_POST, 'msj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $post = dechex(rand());

    // 30 distinct colors
    $colors = ['#aaffff', '#cc99ff', '#ffaaff', '#ffcc00', '#ff6600', '#ffcccc',
               '#ccccff', '#cc6600', '#ff99cc', '#66ccff', '#3399ff', '#ccffcc',
               '#ffccff', '#33cccc', '#99cc00', '#cc3300', '#ff9900', '#ffffaa',
               '#ccff99', '#6600cc', '#ff3366', '#99ff99', '#66ffcc', '#9966cc',
               '#cc0066', '#99ccff', '#336600', '#99cc33', '#663300', '#ff0000'];

    // Cycle through colors in order
    if (isset($_SESSION['color_index'])) {
        $_SESSION['color_index'] = ($_SESSION['color_index'] + 1) % count($colors);
    } else {
        $_SESSION['color_index'] = 0;
    }

    $back = $colors[$_SESSION['color_index']];

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <form method="POST">
            <textarea name="msj" class="post-input"></textarea><br/><br/>
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