<?php

namespace SmartContact\UiMaker\app\Http\Controllers\Api;

use SmartContact\UiMaker\modules\UIBaseContract;
use App\Http\Controllers\Controller;

class UiMakerController extends ApiBaseController
{
    public function retrieveUi(UIBaseContract $UIBase)
    {
        return $UIBase->retrieveUi();
    }
}
