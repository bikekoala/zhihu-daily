<?PHP

namespace Controller;

/**
 * 知乎日报页面
 *
 * @author popfeng <popfeng@yeah.net>
 */
class Index extends Abstr
{
    private $apiStart = 'http://news.at.zhihu.com/api/1.1/start-image/480*800';

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $info = $this->curl($this->apiStart);
        $info = $this->replaceImageUrl($info);

        $this->render('index', $info);
    }

    /**
     * 替换图片地址
     *
     * @param array $info
     * @return array
     */
    private function replaceImageUrl($info)
    {
        $info['img'] = CONFIG['IMAGE_PROXY_API'] .
            str_replace('http://', '', $info['img']);

        return $info;
    }
}
