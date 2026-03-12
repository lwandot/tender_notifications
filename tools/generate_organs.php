<?php
$html = file_get_contents('c:\\Users\\Administrator\\Desktop\\organ-of-state.xml');
// ensure proper UTF-8 handling, convert to HTML entities so DOMDocument preserves accents
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dom = new DOMDocument();
// suppress warnings from malformed HTML
@$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

foreach ($dom->getElementsByTagName('li') as $li) {
    // the nodeValue should now be valid UTF-8
    $name = trim($li->nodeValue);
    if (!$name) continue;
    $slug = strtolower(preg_replace('/[^a-z0-9]+/','-',$name));
    $slug = trim($slug,'-');
    $email = preg_replace('/[^a-z0-9]/','',$slug) . '@example.com';
    // escape single quotes properly for PHP strings
    printf("    ['name' => '%s', 'slug' => '%s', 'description' => '%s', 'contact_email' => '%s'],\n",
        addslashes($name), addslashes($slug), addslashes($name), addslashes($email));
}
