<?PHP
if (empty($_GET['url'])) {
    exit('Invalid url.');
}
$url = trim($_GET['url']);
if ('http' !== substr($url, 0, 4)) {
    $url = 'http://' . $url;
}
$urlInfo = parse_url($url);
$referer = $urlInfo['scheme'] . '://' . $urlInfo['host'] . '/';

// Create a stream
$opts = array(
    'http'=>array(
        'method'  => 'GET',
        'timeout' => 30,
        'header'  => 
            "referer:{$referer}\r\n" .
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36"
    )
);
$ctx = stream_context_create($opts);
// Open the file using the HTTP headers set above
$file = file_get_contents($url, false, $ctx);
if ( ! $file) {
    exit('can not get image.');
}
// output
header('Content-type: image/jpeg');
exit($file);
