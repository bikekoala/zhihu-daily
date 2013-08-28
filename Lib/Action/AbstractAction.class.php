<?PHP
/**
 * AbstractAction
 *
 * @author popfeng <popfeng@yeah.net>
 */
abstract class AbstractAction extends Action
{
    /**
     * curl
     * 封装Curl请求
     *
     * @param string $url
     * @return array
     */
    protected function curl($url)
    {
        $host = array(
            'User-Agent' => 'ZhihuApi/1.0.0-beta (Linux; Android 4.0.4; sdk Build/generic/sdk/generic/MR1/zh_CN) Google-HTTP-Java-Client/1.15.0-rc (gzip) Google-HTTP-Java-Client/1.15.0-rc (gzip)',
            'Host' => 'news.za.zhihu.com',
            'za' => 'OS=Android 4.0.4&Platform=sdk',
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
        $result = curl_exec($ch);
        return json_decode($result, true);
    }
}
