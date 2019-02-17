<?php

namespace Ichynul\IframeTabs\Http\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;
use Ichynul\IframeTabs\IframeTabs;

class IframeTabsController extends Controller
{
    public function index(Content $content)
    {
        if (\Request::route()->getName() == 'admin.dashboard') {
            $this->script();
        }

        $items = [
            'header' => config('admin.name'),
            'trans' => [
                'oprations' => trans('admin.iframe_tabss.oprations'),
                'refresh_current' => trans('admin.iframe_tabss.refresh_current'),
                'close_current' => trans('admin.iframe_tabss.close_current'),
                'close_all' => trans('admin.iframe_tabss.close_all'),
                'close_other' => trans('admin.iframe_tabss.close_other'),
            ]
        ];
        return view('iframe-tabs::index', $items);
    }

    protected function script()
    {
        $call_back = admin_base_path('configx/sort');
        $refresh_current = trans('admin.iframe_tabss.refresh_current');
        $open_in_new = trans('admin.iframe_tabss.open_in_new');
        $home_uri = IframeTabs::config('home_uri', '/admin');
        $home_title = IframeTabs::config('home_title', 'Index');
        $home_icon = IframeTabs::config('home_icon', 'fa-home');
        $use_icon = IframeTabs::config('use_icon', true) ? 'true' : 'false';

        $script = <<<EOT
        window.refresh_current = '{$refresh_current}';
        window.open_in_new = '{$open_in_new}';
        window.use_icon = {$use_icon};

        $('body').on('click', '.sidebar-menu li a', function () {
            var url = $(this).attr('href');
            var index = $('.sidebar-menu li a').index(this);
            if (!url || url == '#') {
                return;
            }
            var icon = $(this).find('i.fa').prop("outerHTML");
            addTabs({
                id: url.replace(/\W/g,'_'),
                title: $(this).find('span').text(),
                close: index!= 0,
                url: url,
                urlType: 'absolute',
                icon : icon
            });
            return false;
        });
        
        if (window == top) {
            var url = '{$home_uri}';
            addTabs({
                id: url.replace(/\W/g,'_'),
                title: '{$home_title}',
                close: false,
                url: url,
                urlType: 'absolute',
                icon : '<i class="fa {$home_icon}"></i>'
            });
        }
EOT;
        Admin::script($script);
    }
}