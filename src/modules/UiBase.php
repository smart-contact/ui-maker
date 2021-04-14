<?php


namespace SmartContact\UiMaker\modules;

use Illuminate\Support\Str;

class UiBase implements UIBaseContract
{
    protected $resource;
    protected $permissions;
    protected $create;
    protected $view;
    protected $update;
    protected $delete;
    protected $destroy;
    protected $restore;
    protected $trash;
    protected $sort;
    protected $routes;
    protected $formCreate;
    protected $columns;
    protected $import;


    public function __construct()
    {
        $this->permissions = $this->retrieveResourcePermissions();
    }

    public function retrieveUi(): array
    {
        return [
            'permissions' => [
                'create' => $this->can('create'),
                'view' => $this->can('view'),
                'update' => $this->can('update'),
                'delete' => $this->can('delete'),
                'destroy' => $this->can('destroy'),
                'trash' => $this->can('trash'),
                'restore' => $this->can('restore'),
                'import' => $this->can('import')
            ],
            'create' => $this->retrieveFormCreate(),
            'routes' => $this->retrieveRoutes(),
            'import' => $this->retrieveImport(),
            'table' => [
                'sort' => $this->sort,
                'columns' => $this->retrieveColumns(),
                'per_page' => 100
            ]
        ];
    }

    protected function can($action): bool
    {
        return in_array($action, $this->permissions);
    }

    protected function retrieveResourcePermissions(): array
    {
        return auth()->user()->retrievePermissions()
            ->where('resource', Str::singular($this->resource))
            ->pluck('action')
            ->toArray();
    }

    protected function retrieveColumns(): array
    {
        return $this->columns;
    }

    protected function retrieveRoutes(): array
    {
        return $this->routes;
    }

    protected function retrieveFormCreate(): array
    {
        return $this->formCreate;
    }

    protected function retrieveImport(): array
    {
        return $this->import ?? [];
    }
}