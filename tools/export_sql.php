<?php
// generate SQL inserts for categories and organs from seeder
$seeder = __DIR__ . '/../database/seeds/InitialDataSeeder.php';
$contents = file_get_contents($seeder);
// categories
if (preg_match('/\$categories\s*=\s*\[(.*?)\];/s', $contents, $m)) {
    $vals = $m[1];
    preg_match_all("/\['name' => '([^']*)', 'slug' => '([^']*)', 'description' => '([^']*)'\]/", $vals, $catm, PREG_SET_ORDER);
    echo "-- categories\nINSERT INTO categories (name, slug, description) VALUES\n";
    foreach ($catm as $i => $c) {
        echo "('" . addslashes($c[1]) . "','" . addslashes($c[2]) . "','" . addslashes($c[3]) . "')";
        echo $i === count($catm) - 1 ? ";\n" : " ,\n";
    }
}

// organs
if (preg_match('/\$organs\s*=\s*\[(.*?)\];/s', $contents, $o)) {
    $ov = $o[1];
    preg_match_all("/\['name' => '([^']*)', 'slug' => '([^']*)', 'description' => '([^']*)', 'contact_email' => '([^']*)'\]/", $ov, $orm, PREG_SET_ORDER);
    echo "\n-- organs\nINSERT INTO organs_of_state (name, slug, description, contact_email) VALUES\n";
    foreach ($orm as $i => $c) {
        echo "('" . addslashes($c[1]) . "','" . addslashes($c[2]) . "','" . addslashes($c[3]) . "','" . addslashes($c[4]) . "')";
        echo $i === count($orm) - 1 ? ";\n" : " ,\n";
    }
}
