<?php

namespace App\Models\Admin\DukunganAplikasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'url',
        'category',
        'icon',
        'active',
        'orders',
        'main_menu_id',
        'route',
    ];

    protected $casts = [
        'active' => 'boolean',
        'orders' => 'integer',
    ];

    /**
     * Parent menu relation
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'main_menu_id');
    }

    /**
     * Sub-menus relation
     */
    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'main_menu_id')->orderBy('orders', 'asc');
    }

    /**
     * Alias for subMenus relation to keep children() compatibility
     */
    public function children()
    {
        return $this->subMenus();
    }

    /**
     * Many-to-Many relation with Spatie Permission model via menu_permission pivot table
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'menu_permission');
    }

    /**
     * Scope for active menus
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope for top-level (parent) menus
     */
    public function scopeParents($query)
    {
        return $query->whereNull('main_menu_id');
    }

    /**
     * Compute clean permission target string.
     * Example:
     * - Route: admin.manajemenpengguna.user.index -> 'manajemenpengguna/user'
     * - Route: admin.manajemenpengguna.reset-password -> 'manajemenpengguna/reset-password'
     * - URL: admin/manajemenpengguna/reset-password -> 'manajemenpengguna/reset-password'
     */
    public function getPermissionTarget(): string
    {
        if (!empty($this->route)) {
            $route = $this->route;
            $route = preg_replace('/^admin\./i', '', $route);
            $route = preg_replace('/\.index$/i', '', $route);
            $route = preg_replace('/\.\*$/i', '', $route);
            return str_replace('.', '/', $route);
        }

        if (!empty($this->url)) {
            $url = trim($this->url, '/');
            $url = preg_replace('/^admin\//i', '', $url);
            return $url;
        }

        if (!empty($this->category)) {
            return Str::slug($this->category) . '/' . Str::slug($this->name);
        }

        return Str::slug($this->name);
    }

    /**
     * Check if user is permitted to see this menu
     */
    public function isPermittedFor($user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            return false;
        }

        // Superadmin bypassed via Gate::before or role check
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // If specific permissions attached via pivot table
        if ($this->relationLoaded('permissions') ? $this->permissions->isNotEmpty() : $this->permissions()->exists()) {
            foreach ($this->permissions as $perm) {
                if ($user->can($perm->name)) {
                    return true;
                }
            }
            return false;
        }

        // If no permissions attached, menu is public for authenticated users
        return true;
    }

    /**
     * Get actual URL path string for this menu.
     */
    public function getRealUrl(): string
    {
        if (!empty($this->url)) {
            return '/' . ltrim($this->url, '/');
        }
        if (!empty($this->route) && \Illuminate\Support\Facades\Route::has($this->route)) {
            return route($this->route, [], false);
        }
        if (!empty($this->route)) {
            $r = preg_replace('/\.index$/i', '', $this->route);
            $r = preg_replace('/^admin\./i', 'admin/', $r);
            return '/' . str_replace('.', '/', $r);
        }
        return '';
    }
}
