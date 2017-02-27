<?php
/**
 * author: ouhanrong
 * Created by PhpStorm.
 * User: ohr445321
 * Date: 2017/2/22
 * Time: 09:27
 */

namespace App\Http\Controllers\Pagination;

use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;
use Illuminate\Pagination\UrlWindowPresenterTrait;
use Illuminate\Pagination\UrlWindow;

class NewPaginationPresenter implements PresenterContract
{
    use BootstrapThreeNextPreviousButtonRendererTrait, UrlWindowPresenterTrait;

    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;

    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;

    /**
     * Create a new Bootstrap presenter instance.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator  $paginator
     * @param  \Illuminate\Pagination\UrlWindow|null  $window
     * @return void
     */
    public function __construct(PaginatorContract $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    /**
     * 功能：自定义分页模板
     * author: ouhanrong
     * @return HtmlString|string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<div class="pagination"><ul>%s %s %s %s %s</ul><span class="record">当前第%s页，共%s页，%s条记录</span></div>',
                $this->getPageLinkWrapper($this->paginator->url(1), '首页'),
                $this->getPreviousButton('上一页'),
                $this->getLinks(),
                $this->getNextButton('下一页'),
                $this->getPageLinkWrapper($this->paginator->url($this->lastPage()), '尾页'),
                $this->currentPage(),
                $this->paginator->total(),
                $this->lastPage()
            ));
        }

        return '';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        return '<li><a href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a></li>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><span>'.$text.'</span></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="active"><span>'.$text.'</span></li>';
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 功能：当前页数
     * author: ouhanrong
     * @return int
     */
    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * 功能：总页数
     * author: ouhanrong
     * @return mixed
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }

    /**
     * 功能：总记录数
     * author: ouhanrong
     * @return mixed
     */
    protected function total()
    {
        return $this->paginator->total();
    }
}
