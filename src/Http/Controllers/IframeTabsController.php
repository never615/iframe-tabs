<?php

namespace Ichynul\IframeTabs\Http\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Ichynul\IframeTabs\IframeTabs;
use Illuminate\Routing\Controller;

class IframeTabsController extends Controller
{
    public function index()
    {
        $items = [
            'header' => '',
            'trans' => [
                'oprations' => trans('admin.iframe_tabs.oprations'),
                'refresh_current' => trans('admin.iframe_tabs.refresh_current'),
                'close_current' => trans('admin.iframe_tabs.close_current'),
                'close_all' => trans('admin.iframe_tabs.close_all'),
                'close_other' => trans('admin.iframe_tabs.close_other'),
                'open_in_new' => trans('admin.iframe_tabs.open_in_new'),
                'open_in_pop' => trans('admin.iframe_tabs.open_in_pop'),
                'scroll_left' => trans('admin.iframe_tabs.scroll_left'),
                'scroll_right' => trans('admin.iframe_tabs.scroll_right'),
                'scroll_current' => trans('admin.iframe_tabs.scroll_current'),
            ],
            'home_uri' => IframeTabs::config('home_uri', '/admin/dashboard'),
            'home_title' => IframeTabs::config('home_title', 'Index'),
            'home_icon' => IframeTabs::config('home_icon', 'fa-home'),
            'use_icon' => IframeTabs::config('use_icon', true) ? '1' : '',
            'pass_urls' => implode(',', IframeTabs::config('pass_urls', ['/admin/auth/logout'])),
            'iframes_index' => admin_url(),
            'tabs_left' => IframeTabs::config('tabs_left', '42')
        ];

        Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) use ($items) {
            $navbar->left(view('iframe-tabs::ext.tabs'));
            $navbar->right(view('iframe-tabs::ext.options', $items));
        });

        return view('iframe-tabs::ext.index', $items);
    }

    public function dashboard(Content $content)
    {
        return $content
            ->header('Defautl page')
            ->description('Defautl page')
            ->body('Defautl page have not seted ,place edit config in `config/admin.php`'
                . "<pre>'extensions' => [
                'iframe-tabs' => [
                     // Set to `false` if you want to disable this extension
                    'enable' => true,
                    // Default page controller
                    'home_action' => App\Admin\Controllers\HomeController::class . '@index',//edit here
                    // Default page uir after user login success
                    'home_uri' => '/admin/dashboard',
                    // Default page tab-title
                    'home_title' => 'Home',
                    // Default page tab-title icon
                    'home_icon' => 'fa-home',
                    // wheath show icon befor titles for all tab
                    'use_icon' => true,
                    // layer.js path , if you do not user laravel-admin-ext\cropper , set another one
                    'layer_path' => '/vendor/laravel-admin-ext/cropper/layer/layer.js',
                    //href links do not open in tab .
                    'pass_urls' => ['/admin/auth/logout', '/admin/auth/lock'],
                    //When login session state of a tab-page was expired , force top-level window goto login page .
                    'force_login_in_top' => true,
                    //tabs left offset
                    'tabs_left'  => 42,
                ]
            ],</pre>");
    }
}
