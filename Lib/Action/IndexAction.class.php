<?PHP
/**
 * IndexAction
 * 知乎日报页面
 *
 * @author popfeng <popfeng@yeah.net>
 */
class IndexAction extends AbstractAction
{
    private $_apiStart = 'http://news.at.zhihu.com/api/1.1/start-image/480*800';

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $info = $this->curl($this->_apiStart);
        $info = $this->_replaceImageUrl($info);

        $this->assign('start', $info);
        $this->display();
    }

    /**
     * _replaceImageUrl
     * 替换图片地址
     *
     * @param array $info
     * @return array
     */
    private function _replaceImageUrl($info)
    {
        $info['img'] = C('IMAGE_PROXY_API') . '?url=' . $info['img'];
        return $info;
    }
}
