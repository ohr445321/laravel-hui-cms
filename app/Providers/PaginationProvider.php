<?php
/**
 * author: ouhanrong
 * Created by PhpStorm.
 * User: ohr445321
 * Date: 2017/2/22
 * Time: 09:35
 */

namespace App\Providers;

use App\Http\Controllers\Pagination\NewPaginationPresenter;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\ServiceProvider;

class PaginationProvider extends ServiceProvider
{
    /**
     * 功能：自定义分页
     * author: ouhanrong
     */
    public function boot()
    {
        //使用自定义分页模板
        Paginator::presenter(function(AbstractPaginator $paginator) {
            return new NewPaginationPresenter($paginator);
        });
    }

    public function register()
    {

    }
}