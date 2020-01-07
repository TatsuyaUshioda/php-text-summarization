<?php

/*
 * Copyright 2019 TatsuyaUshioda
 * This software is released under Apache License Version 2.0, see LICENSE.
 */

require_once "lib/txt2sumally.php";

$textarea = "";
$sumally_num_per = "";
$sumally_texts = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $textarea = (string)filter_input(INPUT_POST,'textarea');
    if ($_POST['sumally_num'] > 0) {
        $sumally_num_per = intval($_POST['sumally_num']);
        $sumally_texts = txt2sumally($textarea, $sumally_num_per);
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>文章要約フォーム</title>
</head>
<body>
<h2>文章要約フォーム</h2>
<form action="index.php" method="POST">
    <h4>要約対象</h4>
    <textarea type="text" name="textarea" maxlength="10000" placeholder="要約したい文章を入力してください" cols="100"
              rows="50" required><?php echo $textarea ? hsc($textarea) : ""; ?></textarea>
    <h4>要約割合(%)</h4>
    <input type="number" name="sumally_num" required>%
    <input type="submit" value="submit">
</form>

<?php
if ($textarea && $sumally_texts) {
    echo "<h2>要約結果(" . hsc($sumally_num_per) . "%)</h2>";
    foreach ($sumally_texts as $text) {
        echo "<p>" . hsc($text) . "</p>";
    }
} else {
    echo "<h2>要約結果</h2>";
    echo "<p>ここに文章の要約結果が表示されます</p>";
}
?>
</body>
</html>
