<?php


namespace SmartContact\UiMaker\modules;

use Illuminate\Support\Facades\Http;

class ToMicroservice implements UIBaseContract
{
    private $url;

    public function __construct($url, $microservice, $resource)
    {
        $this->url = "$url/api/ui/retrieve/$microservice/$resource?is_final_microservice=true";
    }

    public function retrieveUi(): array
    {
        $response = Http::get($this->url);

        return $response->json();
    }
}