<?php
// Soubor k smazání
$filename = 'backup.zip';

// Kontrola, zda soubor existuje
if (file_exists($filename)) {
    // Smaž soubor
    if (unlink($filename)) {
        echo "Soubor '$filename' byl úspěšně smazán.";
    } else {
        echo "Soubor '$filename' se nepodařilo smazat.";
    }
} else {
    echo "Soubor '$filename' neexistuje.";
}
?>
