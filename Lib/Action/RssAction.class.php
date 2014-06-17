<?PHP
/**
 * RssAction
 * RSS订阅类
 *
 * @author popfeng <popfeng@yeah.net>
 */
class RssAction extends NewsAction {

    /**
     * index
     *
     * @return void
     */
    public function index() {
        // 获取当日新闻列表
        $list = $this->curl($this->_apiLatest);
        $list = $this->_replaceImageUrl($list);

        // 输出RSS XML
        $params = array(
            'channelTitle'      => '知乎日报',
            'channelLink'       => 'http://daily.bikethru.com',
            'channelDescrīption'=> '知乎日报 - 满足你的好奇心',
            'copyright'         => '树袋大熊'
        );
        import('@.Common.Rss');
        $rss = new Rss($params);
        foreach ($list['news'] as $v) {
            $rss->AddItem($v['title'], $v['share_url']);
        }
        $this->show($rss->content(), 'utf-8', 'text/xml');
    }
}
