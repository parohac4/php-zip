<?php
session_start();
error_log("Zahájení zálohování");

$zip = new ZipArchive();
$zipFilename = "backup.zip";  // Uložení ZIP souboru ve stejném adresáři jako skript

// Zadání relativní cesty k adresáři, který chcete zkomprimovat
$rootPath = realpath('../../../..');  

if ($rootPath === false) {
    error_log("Zadaná cesta neexistuje: " . $rootPath);
    die('Zadaná cesta neexistuje. Zkontrolujte cestu a oprávnění.');
}

if (!isset($_SESSION['files'])) {
    $iterator = new RecursiveDirectoryIterator($rootPath, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::LEAVES_ONLY);

    $_SESSION['files'] = [];
    foreach ($files as $file) {
        if (!$file->isDir()) {
            $_SESSION['files'][] = $file->getRealPath();
        }
    }
    $_SESSION['index'] = 0;

    if ($zip->open($zipFilename, ZipArchive::CREATE) !== TRUE) {
        error_log("Nelze vytvořit ZIP soubor: " . $zipFilename);
        die("Nelze otevřít ZIP soubor pro zápis.");
    }
} else {
    if ($zip->open($zipFilename) !== TRUE) {
        error_log("Nelze otevřít existující ZIP soubor: " . $zipFilename);
        die("Nelze otevřít existující ZIP soubor.");
    }
}

$filesPerBatch = 1000;
$files = $_SESSION['files'];
$index = &$_SESSION['index'];

for ($i = 0; $i < $filesPerBatch && $index < count($files); $i++, $index++) {
    $filePath = $files[$index];
    $relativePath = substr($filePath, strlen($rootPath) + 1);
    if (!$zip->addFile($filePath, $relativePath)) {
        error_log("Nelze přidat soubor do ZIP: " . $filePath);
    }
}

if ($index >= count($files)) {
    $zip->close();
    unset($_SESSION['files']);
    unset($_SESSION['index']);
    error_log("Záloha byla úspěšně dokončena a archiv vytvořen.");
    echo "Archiv byl úspěšně vytvořen. <a href='$zipFilename'>Stáhnout ZIP</a>";
} else {
    $zip->close();
    error_log("Záloha stále probíhá, zpracováno $index z " . count($files));
    echo "Zpracováno $index/" . count($files) . ". Prosím čekejte, stránka se obnoví...";
}
?>
