<?php
$baseDir = dirname(__DIR__) . '/public/assets/fontawesome';
@mkdir($baseDir . '/css', 0755, true);
@mkdir($baseDir . '/webfonts', 0755, true);

$files = [
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' => 'css/all.min.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-solid-900.woff2' => 'webfonts/fa-solid-900.woff2',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-solid-900.ttf' => 'webfonts/fa-solid-900.ttf',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-brands-400.woff2' => 'webfonts/fa-brands-400.woff2',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-brands-400.ttf' => 'webfonts/fa-brands-400.ttf',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-regular-400.woff2' => 'webfonts/fa-regular-400.woff2',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-regular-400.ttf' => 'webfonts/fa-regular-400.ttf'
];

$ctx = stream_context_create([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ]
]);

foreach ($files as $url => $path) {
    $dest = $baseDir . '/' . $path;
    echo "Downloading {$url} -> {$dest}...\n";
    $content = @file_get_contents($url, false, $ctx);
    if ($content !== false) {
        file_put_contents($dest, $content);
        echo "Success!\n";
    } else {
        echo "FAILED to download {$url}\n";
    }
}
