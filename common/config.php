<?PHP
/**
 * 基本配置
 */
define('APP_PATH', realpath(__DIR__ . '/../'));
const AUTOLOAD_PATH = [APP_PATH . '/lib/', APP_PATH . '/addons/'];

/**
 * 项目自定义配置
 */
const CONFIG = [
    'IMAGE_PROXY_API' => 'img/', // 图片代理程序地址
];
