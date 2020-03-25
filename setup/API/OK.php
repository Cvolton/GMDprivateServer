<?php
echo "ready";

ob_flush();
flush();

sleep(3);
function deleteDir($path) {
    if (is_dir($path)) {
        $dirs = scandir($path);
        foreach ($dirs as $dir) {
            if ($dir != '.' && $dir != '..') {
                $sonDir = $path.'/'.$dir;
                if (is_dir($sonDir)) {
                    deleteDir($sonDir);
                    @rmdir($sonDir);
                } else {
                    @unlink($sonDir);
                }
            }
        }
        @rmdir($path);
    }
}
deleteDir("../../setup");
file_put_contents("../../index.php", "<?php".PHP_EOL."header(\"location: /dashboard\");".PHP_EOL."?>")
?>
