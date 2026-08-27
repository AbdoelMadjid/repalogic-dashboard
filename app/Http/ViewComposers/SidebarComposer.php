<?php

namespace App\Http\ViewComposers;

use App\Models\Admin\DukunganAplikasi\Menu;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $user = auth()->user();

        // Fetch top-level active menus with their active children recursively
        $menus = Menu::with([
            'permissions',
            'subMenus' => function ($query) {
                $query->active()->with([
                    'permissions',
                    'subMenus' => function ($subQuery) {
                        $subQuery->active()->with('permissions')->orderBy('orders', 'asc');
                    }
                ])->orderBy('orders', 'asc');
            }
        ])
        ->active()
        ->parents()
        ->orderBy('orders', 'asc')
        ->get();

        $groupedMenus = [];

        foreach ($menus as $menu) {
            $processedMenu = $this->processMenu($menu, $user, false);
            if ($processedMenu !== null) {
                $groupKey = $menu->category ?: 'APLIKASI';

                if (!isset($groupedMenus[$groupKey])) {
                    $groupedMenus[$groupKey] = [
                        'title' => $groupKey,
                        'data_lang' => Str::slug($groupKey),
                        'items' => [],
                    ];
                }

                $groupedMenus[$groupKey]['items'][] = $processedMenu;
            }
        }

        $view->with('dbMenuGroups', array_values($groupedMenus));
    }

    /**
     * Recursively process menu item and its children.
     */
    private function processMenu(Menu $menu, $user, bool $isChild = false): ?array
    {
        if (!$menu->isPermittedFor($user)) {
            return null;
        }

        $permittedChildren = [];
        foreach ($menu->subMenus as $child) {
            $processedChild = $this->processMenu($child, $user, true);
            if ($processedChild !== null) {
                $permittedChildren[] = $processedChild;
            }
        }

        // If it has no route/url and no visible children, don't show container parent
        if (empty($menu->route) && empty($menu->url) && empty($permittedChildren)) {
            return null;
        }

        $item = [
            'id' => 'db-menu-' . $menu->id,
            'title' => $menu->name,
            'data_lang' => $menu->data_lang ?: Str::slug($menu->name),
            'icon' => $isChild ? null : $menu->icon,
            'route' => $menu->route,
            'url' => $menu->url,
            'target' => '_self',
        ];

        if (!empty($permittedChildren)) {
            $item['children'] = $permittedChildren;
        }

        return $item;
    }
}
