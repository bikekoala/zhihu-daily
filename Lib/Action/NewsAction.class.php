<?PHP
/**
 * IndexAction
 * 知乎日报新闻列表页面
 *
 * @author popfeng <popfeng@yeah.net>
 */
class NewsAction extends AbstractAction
{
    private $_apiLatest = 'http://news.at.zhihu.com/api/1.1/news/latest';
    private $_apiBefore = 'http://news.at.zhihu.com/api/1.1/news/before';

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $this->display();
    }

    /**
     * latest
     * 今天新闻列表api
     *
     * @return void
     */
    public function latest()
    {
        $list = $this->curl($this->_apiLatest);
        $list = $this->_replaceImageUrl($list);
        $stat = isset($list);
        $msg = '今天的新闻列表';
        $this->ajaxReturn($list, $msg, $stat);
    }

    /**
     * before
     * 之前新闻列表api
     *
     * @param int $date
     * @return void
     */
    public function before($date)
    {
        if (8 !== strlen((int) $date)) {
            $this->ajaxReturn(null, '无效的查询时间', false);
        }
        $list = $this->curl($this->_apiBefore . '/' . $date);
        $list = $this->_replaceImageUrl($list);
        $stat = isset($list);
        $msg = '之前的新闻列表';
        $this->ajaxReturn($list, $msg, $stat);
    }

    /**
     * _replaceImageUrl
     * 替换图片地址
     *
     * @param array $list
     * @return array
     */
    private function _replaceImageUrl($list)
    {
        $api = C('IMAGE_PROXY_API');
        foreach ($list as $cate => &$data) {
            if ('news' === $cate) {
                foreach ($data as &$news) {
                    $news['thumbnail'] =  $api . str_replace('http://', '', $news['thumbnail']);
                }
            }
        }
        return $list;
    }
}
