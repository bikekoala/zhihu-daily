<?PHP

namespace Controller;

/**
 * 知乎日报新闻列表页面
 *
 * @author popfeng <popfeng@yeah.net>
 */
class News extends Abstr
{
    protected $apiLatest = 'http://news-at.zhihu.com/api/4/stories/latest';
    protected $apiBefore = 'http://news-at.zhihu.com/api/4/stories/before';

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $this->render('news');
    }

    /**
     * 今天新闻列表api
     *
     * @return void
     */
    public function latest()
    {
        $list = $this->curl($this->apiLatest);
        $list = $this->replaceImageUrl($list);

        $this->ajax($list, '今天的新闻列表', ! empty($list));
    }

    /**
     * 之前新闻列表api
     *
     * @param int $date
     * @return void
     */
    public function before($params)
    {
        $date = (int) $params['date'];
        if (8 !== strlen($date)) {
            $this->ajax([], '无效的查询时间', false);
        }

        $list = $this->curl($this->apiBefore . '/' . $date);
        $list = $this->replaceImageUrl($list);

        $this->ajax($list, '之前的新闻列表', ! empty($list));
    }

    /**
     * 替换图片地址
     *
     * @param array $list
     * @return array
     */
    protected function replaceImageUrl($list)
    {
        foreach ($list as $cate => &$data) {
            if ('stories' === $cate) {
                foreach ($data as &$news) {
                    $news['thumbnail'] =  CONFIG['IMAGE_PROXY_API'] .
                        str_replace('http://', '', $news['images'][0]);
                }
            }
        }

        return $list;
    }
}
