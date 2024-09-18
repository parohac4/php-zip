# Zazipování adresáře pomocí PHP


## Zip

**zip.php** zazipuje adersář **/** a poté nabídne stažení zip souboru. Pracuje dávkově po 1000 souborech, aby se počítalo s max_execution_time na 90. Skript běží na základě ajaxového dotazu, na konci po provedení zálohy se stránka reloaduje a nabídně link na stažení zálohy

**delete_backup.php**

slouží pro odstranění zip souboru se zálohou

**index.html**
Obsahuje vstupní stránku a tlačítka na vytvoření zálohy a smazání zálohy

**dump.php**
provede dump SQL databáze v dalším okně. Otevře se formulář pro vložení údajů k db. Po vytvoření zálohy nabídne link na stažení db