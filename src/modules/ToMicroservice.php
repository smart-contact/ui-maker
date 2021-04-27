<?php


namespace SmartContact\UiMaker\modules;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ToMicroservice implements UIBaseContract
{
    private $url;
    private $permissions;

    public function __construct($url, $microservice, $resource)
    {
        $parameters = http_build_query(array_merge(request()->all()));
        $this->url = "$url/api/ui/retrieve/$microservice/$resource?is_final_microservice=true&$parameters";
    }

    public function retrieveUi(): array
    {
        $response = Http::get($this->url);

        return $response->json();
    }

    public function setMircroservicePermissions($microservice, $resource)
    {
        $this->permissions = auth()->user()->retrievePermissions()
            ->where('microservice', Str::singular($microservice))
            ->where('resource', Str::singular($resource))
            ->pluck('action')
            ->toArray();
    }

    public function can($action): bool
    {
        return in_array($action, $this->permissions);
    }
}