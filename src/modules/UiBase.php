<?php


namespace SmartContact\UiMaker\modules;

use Illuminate\Support\Str;

class UiBase implements UIBaseContract
{
    protected $permissions;
    protected $resource;
    protected $sort;
    protected $routes;
    protected $formCreate;
    protected $columns;
    protected $import;
    protected $advancedFilter;

    protected static $advancedFilterTypes = [
        'TEXT' => 'text',
        'SELECT' => 'select',
        'DATE' => 'date',
    ];

    public function __construct()
    {

    }

    public function retrieveUi(): array
    {
        return [
            'create' => $this->retrieveFormCreate(),
            'routes' => $this->retrieveRoutes(),
            'import' => $this->retrieveImport(),
            'table' => [
                'sort' => $this->sort,
                'columns' => $this->retrieveColumns(),
                'per_page' => 100
            ],
            'advancedFilter' => $this->retrieveAdvancedFilter()
        ];
    }

    public function can($action): bool
    {
        return in_array($action, $this->permissions);
    }

    public function setMircroservicePermissions($microservice, $resource)
    {
        $resource = $resource ?? $this->resource;
        $this->permissions = auth()->user()->retrievePermissions()
            ->where('microservice', Str::singular($microservice))
            ->where('resource', Str::singular($resource))
            ->pluck('action')
            ->toArray();
    }

    protected function retrieveColumns(): array
    {
        return $this->columns;
    }

    protected function retrieveRoutes(): array
    {
        return collect($this->routes)->map(function ($route,$key){
            return "$route?resource={$this->resource}&action=$key";
        })->toArray();
    }

    protected function retrieveFormCreate(): array
    {
        return $this->formCreate;
    }

    protected function retrieveImport(): array
    {
        return $this->import ?? [];
    }

    protected function retrieveAdvancedFilter(): array
    {
        return $this->advancedFilter ?? [];
    }

    protected function retrieveOperatorsByFilterType($filterType)
    {
        switch($filterType) {
            case "date": {
                return [
                    [ "value" => "=", "label" => "uguale", "kind" => "single" ],
                    [ "value" => "!=", "label" => "diverso", "kind" => "single" ],
                    [ "value" => ">", "label" => "maggiore di", "kind" => "single" ],
                    [ "value" => "<", "label" => "minore di", "kind" => "single" ],
                    [ "value" => "between", "label" => "compreso tra", "kind" => "range" ],
                    [ "value" => "not between", "label" => "non compreso tra", "kind" => "range" ],
                ];
                break;
            }
            case "select": {
                return [
                    [ "value" => "=", "label" => "uguale", "kind" => "single" ],
                    [ "value" => "!=", "label" => "diverso", "kind" => "single" ],
                    [ "value" => ">", "label" => "maggiore di", "kind" => "single" ],
                    [ "value" => "in", "label" => "In", "kind" => "multiple" ],
                ];
                break;
            }
            default: {
                return [
                    [ "value" => "=", "label" => "uguale", "kind" => "single" ],
                    [ "value" => ">", "label" => "maggiore di", "kind" => "single" ],
                    [ "value" => "!=", "label" => "diverso", "kind" => "single" ],
                    [ "value" => "<", "label" => "minore di", "kind" => "single" ],
                    [ "value" => "between", "label" => "compreso tra", "kind" => "range" ],
                ];
            }
        }
    }
}