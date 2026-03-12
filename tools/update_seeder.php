<?php
$seeder = 'c:\\Users\\Administrator\\PersonalProjects\\tender_notifications\\database\\seeds\\InitialDataSeeder.php';
$list = 'c:\\Users\\Administrator\\PersonalProjects\\tender_notifications\\tools\\organs_list.txt';

$lines = file($seeder);
$out = [];
$inOrgans = false;
foreach ($lines as $line) {
    if (strpos($line, '// Seed Organs of State') !== false) {
        $out[] = $line;
        // start new static array
        $out[] = "        $organs = [\n";
        // insert list file contents (cleaned of control chars)
        $orgLines = file($list);
        foreach ($orgLines as $orgLine) {
            // strip non-printable characters but leave utf-8 bytes intact
            $clean = preg_replace('/[\x00-\x1F\x7F]/u', '', rtrim($orgLine));
            $out[] = '            ' . $clean . "\n";
        }
        $out[] = "        ];\n";
        $inOrgans = true;
        continue;
    }
    if ($inOrgans) {
        // skip until end of original array
        if (preg_match('/^\s*\];/', $line)) {
            $inOrgans = false;
            // keep this line? we've already added closing bracket
            continue;
        }
        continue;
    }
    $out[] = $line;
}
file_put_contents($seeder, implode('', $out));
echo "Seeder updated\n";
