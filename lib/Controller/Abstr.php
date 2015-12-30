<?PHP

namespace Controller;

/**
 * 抽象类
 *
 * @author popfeng <popfeng@yeah.net>
 */
abstract class Abstr
{
    /**
     * 模板对象
     *
     * @var Plates\Engine object
     */
    protected $templates;

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct()
    {
        $this->templates = new \Plates\Engine(APP_PATH . '/lib/View', 'html');
    }

    /**
     * 渲染页面
     *
     * @param string $template
     * @param array $data
     * @return void
     */
    protected function render(string $template, array $data = [])
    {
        echo $this->templates->render($template, $data);
        exit;
    }

    /**
     * 输出json字符串
     *
     * @param array $data
     * @param string $info
     * @param bool $status
     * @return void
     */
    protected function ajax(array $data, string $info, bool $status = true)
    {
        echo json_encode(compact('data', 'info', 'status'), JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 输出内容
     *
     * @param string $content
     * @param string $type
     * @param string $charset
     * @return void
     */
    protected function show(
        string $content,
        string $type = 'text/html',
        string $charset = 'utf-8'
    ) {
        header("Content-type: {$type}; charset={$charset}"); 
        echo $content;
        exit;
    }

    /**
     * 封装Curl请求
     *
     * @param string $url
     * @return array
     */
    protected function curl(string $url) : array
    {
        $host = [ 
            'User-Agent' => 'ZhihuApi/1.0.0-beta (Linux; Android 4.0.4; sdk Build/generic/sdk/generic/MR1/zh_CN) Google-HTTP-Java-Client/1.15.0-rc (gzip) Google-HTTP-Java-Client/1.15.0-rc (gzip)',
            'Host'       => 'news.za.zhihu.com',
            'za'         => 'OS=Android 4.0.4&Platform=sdk',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
        $result = curl_exec($ch);

        return json_decode($result, true) ? : [];
    }
}
