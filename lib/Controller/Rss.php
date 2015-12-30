<?PHP

namespace Controller;

/**
 * RSS订阅类
 *
 * @author popfeng <popfeng@yeah.net>
 */
class Rss extends News
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // 获取当日新闻列表
        $list = $this->curl($this->apiLatest);
        $list = $this->replaceImageUrl($list);

        // 输出RSS XML
        $params = [
            'channelTitle'       => '知乎日报',
            'channelLink'        => 'http://daily.bikethru.com',
            'channelDescrīption' => '知乎日报 - 满足你的好奇心',
            'copyright'          => '树袋大熊'
        ];
        $rss = new \Rss($params);
        foreach ($list['stories'] as $v) {
            $rss->AddItem(
                $v['title'],
                'http://daily.zhihu.com/story/' . $v['id']
            );
        }
        $this->show($rss->content(), 'text/xml');
    }
}
