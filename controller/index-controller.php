<?php
$customDirectory = str_replace("/controller", "", __DIR__);
$workpath = $customDirectory . '/assets/tempFiles';
$command = $customDirectory . '/nexrender-cli-macos --file ../main.json --workpath ' . $workpath;
$arrayParameters = array();
$destinationDirectory = null;
$output = $customDirectory . '/assets/video.mp4';

function getJson($customDirectory)
{
    try {
        if (file_exists($customDirectory . "/main.json")) {
            $filename = $customDirectory . '/main.json';
            $data = file_get_contents($filename);
            $json = json_decode($data, false, 512, JSON_THROW_ON_ERROR);
        }
    } catch (JsonException $e) {
        echo $e->getMessage();
    }
    return $json;
}

$json = getJson($customDirectory);
/**
 * @throws JsonException
 */
function jsonUpdate($json, $output, $customDirectory)
{
    if (isset($_POST) && !empty($_POST)) {
        uploadFile();
        $arrayParameters['text'] = isset($_POST['text']) ? htmlspecialchars($_POST['text'], ENT_DISALLOWED, "UTF-8") : '';
        $arrayParameters['image'] = isset($_FILES['image']['name']) ? 'file://' . $customDirectory . '/assets/img/imgRender/' . htmlspecialchars($_FILES['image']['name']) : '';
        $arrayParameters['text'] = htmlspecialchars_decode($arrayParameters['text']);
        $json->assets[0]->src = $arrayParameters['image'];
        $json->assets[1]->value = $arrayParameters['text'];
        $json->actions->postrender[1]->output = $output;
        $pushOutput = json_encode($json, JSON_THROW_ON_ERROR);
        file_put_contents('../main.json', $pushOutput);
        return $arrayParameters;
    }
}

/**
 * @param $command
 * @return false|string|null
 */

/**
 * @param $commandResult
 * @param $renamedFile
 * @param $destinationDirectory
 * @param $customDirectory
 * @return string
 */

function uploadFile()
{
    if (isset($_FILES) && !empty($_FILES['image'])) {
//        var_dump($_FILES);
        $imageDir = $_FILES['image']['tmp_name'];
        $imagetype = $_FILES['image']['type'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        //   var_dump($_FILES);
        if (!mkdir('/Users/theoricherol/Desktop/Nexrender/assets/img/imgRender', 0777, true) && !is_dir('/Users/theoricherol/Desktop/Nexrender/assets/img/imgRender')) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', '/Users/theoricherol/Desktop/Nexrender/assets/img/imgRender'));
        }
        move_uploaded_file($imageDir , '/Users/theoricherol/Desktop/Nexrender/assets/img/imgRender/' . $imageName);
    }
}


function getFile($commandResult, $customDirectory)
{
    if (strpos($commandResult, "job rendering successfully finished")) {
        $fileName = '/Users/theoricherol/Desktop/Nexrender/assets/render/';
        $folderName = date("Y");
        $folderScan = scandir($fileName);
        $folderScanLast = end($folderScan);
        $folderCount = str_replace("2023", "", $folderScanLast);
        if ($folderCount === ".DS_Store") {
            $folderCount = 1;
        }
        if (file_exists($fileName . $folderName . str_pad($folderCount, 4, "0", STR_PAD_LEFT))) {
            $folderCount++;
            if (!mkdir($concurrentDirectory = $fileName . $folderName . str_pad($folderCount, 4, "0", STR_PAD_LEFT)) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        } else if (!file_exists($fileName . $folderName . str_pad($folderCount, 4, "0", STR_PAD_LEFT)) && !mkdir($concurrentDirectory = $fileName . $folderName . str_pad($folderCount, 4, "0", STR_PAD_LEFT)) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        $generatedFolder = $fileName . $folderName . str_pad($folderCount, 4, "0", STR_PAD_LEFT);
        rename(($customDirectory . "/assets/video.mp4") , $generatedFolder . "/video.mp4");
        rename( $customDirectory . "/assets/img/imgRender" , $generatedFolder . "/imgRender" );

    }
}

function generateRenderer($command, $customDirectory): void
{
    if (isset($_POST['text']) && !empty($_POST) && !empty($_POST['text'])) {
        $commandResult = shell_exec($command);
        $directory = getFile($commandResult, $customDirectory);
    }
}

/**
 * @throws JsonException
 */

try {

    jsonUpdate($json, $output, $customDirectory);
    generateRenderer($command, $customDirectory);
} catch (JsonException $e) {
    echo $e->getMessage();
}