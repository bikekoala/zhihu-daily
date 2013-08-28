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
            $this->ajaxReturn(null, '无效的查询时间按', false);
        }
        $list = $this->curl($this->_apiBefore . '/' . $date);
        $stat = isset($list);
        $msg = '之前的新闻列表';
        $this->ajaxReturn($list, $msg, $stat);
    }
}
