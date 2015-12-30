<?PHP

/**
 * 开始调用
 *
 * @return void
 */
function start()
{
    $controller = 'Controller\\' . ucfirst( ! empty($_GET['c']) ? $_GET['c'] : 'index');
    $action     = $_GET['a'] ?? 'index';

    (new $controller)->$action($_GET);
}

/**
 * 自动加载
 *
 * @param string $class_name
 * @return void
 */
function autoload(string $class_name)
{
    $class_name = ltrim($class_name, '\\');
    $file_name  = '';
    $namespace = '';
    if ($last_ns_pos = strrpos($class_name, '\\')) {
        $namespace = substr($class_name, 0, $last_ns_pos);
        $class_name = substr($class_name, $last_ns_pos + 1);
        $file_name  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    // choose work directory
    foreach (AUTOLOAD_PATH as $base_dir) {
        $file = $base_dir . $file_name . str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
        if (file_exists($file)) {
            return require $file;
        }
    }
}
