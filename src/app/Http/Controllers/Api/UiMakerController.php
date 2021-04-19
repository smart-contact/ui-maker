<?php

namespace SmartContact\UiMaker\app\Http\Controllers\Api;

use App\Models\Permission;
use SmartContact\UiMaker\modules\UIBaseContract;
use App\Http\Controllers\Controller;

class UiMakerController extends ApiBaseController
{
    public function retrieveUi(UIBaseContract $UIBase)
    {
        $ui = $UIBase->retrieveUi();

        if (!request()->is_final_microservice || request()->microservice == 'api-gateway') {

            $UIBase->setMircroservicePermissions(request()->microservice, request()->resource);
            return array_merge($ui, ['permissions' => [
                'create' => $UIBase->can('create'),
                'view' => $UIBase->can('view'),
                'update' => $UIBase->can('update'),
                'delete' => $UIBase->can('delete'),
                'destroy' => $UIBase->can('destroy'),
                'trash' => $UIBase->can('trash'),
                'restore' => $UIBase->can('restore'),
                'import' => $UIBase->can('import')
            ]]);
        }

        return $ui;
    }

}
