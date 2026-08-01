<?php

namespace App\Http\ViewComposers;

use App\Models\Admin\ManajemenSistem\Menu;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $user = auth()->user();

        // Fetch top-level active menus with their active children and attached permissions
        $menus = Menu::with([
            'permissions',
            'subMenus' => function ($query) {
                $query->active()->with('permissions')->orderBy('orders', 'asc');
            }
        ])
        ->active()
        ->parents()
        ->orderBy('orders', 'asc')
        ->get();

        $groupedMenus = [];

        foreach ($menus as $menu) {
            // Permission check for parent
            if (!$menu->isPermittedFor($user)) {
                continue;
            }

            // Filter permitted children
            $permittedChildren = [];
            foreach ($menu->subMenus as $child) {
                if ($child->isPermittedFor($user)) {
                    $permittedChildren[] = $this->formatMenuItem($child, [], true);
                }
            }

            // If it has no route/url and no visible children, don't show header parent
            if (empty($menu->route) && empty($menu->url) && empty($permittedChildren)) {
                continue;
            }

            $formattedParent = $this->formatMenuItem($menu, $permittedChildren, false);
            $groupKey = $menu->category ?: 'APLIKASI';

            if (!isset($groupedMenus[$groupKey])) {
                $groupedMenus[$groupKey] = [
                    'title' => $groupKey,
                    'items' => [],
                ];
            }

            $groupedMenus[$groupKey]['items'][] = $formattedParent;
        }

        $view->with('dbMenuGroups', array_values($groupedMenus));
    }

    /**
     * Format menu model into array compatible with template mainmenu partials.
     * Submenus ($isChild = true) do not render icons to match template aesthetics.
     */
    private function formatMenuItem(Menu $menu, array $children = [], bool $isChild = false): array
    {
        $item = [
            'id' => 'db-menu-' . $menu->id,
            'title' => $menu->name,
            'icon' => $isChild ? null : $menu->icon,
            'route' => $menu->route,
            'url' => $menu->url,
            'target' => '_self',
        ];

        if (!empty($children)) {
            $item['children'] = $children;
        }

        return $item;
    }
}
