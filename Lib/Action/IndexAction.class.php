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

        $this->assign('start', $info);
        $this->display();
    }
}
