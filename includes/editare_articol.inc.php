<?php

$id = (int) $_GET['id'];

$json = file_get_contents('../articles.json');
$data = json_decode($json, true);

print_r($data);

$text_preview = strtok($_POST["text"], "\n");
$data['articles'][$id]['title'] = $_POST['titlu'];
$data['articles'][$id]['image'] = ".\/articles_images\/".$_POST['image'];
$data['articles'][$id]['text preview'] = $text_preview;
$data['articles'][$id]['text'] = $_POST['text'];

$newJsonString = json_encode($data);
file_put_contents('../articles.json', $newJsonString);

echo "<script> location.href='../index.php'; </script>";
exit;