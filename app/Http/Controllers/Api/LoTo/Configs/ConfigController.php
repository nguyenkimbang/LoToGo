<?php
namespace App\Http\Controllers\Api\LoTo\Configs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * 
 */
class ConfigController extends Controller
{
	
	public function __construct()
    {
        $this->_getApi();
        $this->_getToken();
    }


    /**
     * [store description]
     * @author [nguyen kim bang] <[<nguyenkimbang208@gmail.com>]>
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {

        $dataReq = self::configDataReq($request->all());

        $url = $this->API . 'setting';

        //call postAPI_v2 function from parent Controller
        $resultRep = $this->postAPI_v2($url, $dataReq);

        return new JsonResponse($resultRep);
    }

    public function removeConfig(Request $request)
    {
    	return new JsonResponse(['status'=>true]);
        $url = $this->API . 'setting?mod=delete_config&code=' . $request->Code;

        //call postAPI_v2 function from parent Controller
        $resultRep = $this->postAPI_v2($url, [], 'DELETE');

        return new JsonResponse($resultRep);
    }

    /**
     * [configDataReq description]
     * @author [nguyen kim bang] <[<nguyenkimbang208@gail.com>]>
     * @param  array  $dataReq [description]
     * @return [type]          [description]
     */
    public function configDataReq($dataReq = [])
    {
        if (!empty($dataReq)) {
        	return [
        		'mod'			=>'update_config',
                'code'			=>isset($dataReq['Code']) ? $dataReq['Code'] : '',
                'type'			=>isset($dataReq['Type']) ? $dataReq['Type'] : '',
                'value'			=>isset($dataReq['Value']) ? $dataReq['Value'] : '',
                'status'		=>isset($dataReq['Status']) ? $dataReq['Status'] : '',
                'game_code'		=>isset($dataReq['Game_Code']) ? $dataReq['Game_Code'] : '',
                'parent_code'	=>isset($dataReq['Parent_Code']) ? $dataReq['Parent_Code'] : '',
                'ETH_address'	=>isset($dataReq['ETH_Address']) ? $dataReq['ETH_Address'] : '',
                'description'	=>isset($dataReq['Description']) ? $dataReq['Description'] : ''
        	];
        }

        return [];
    }

    public function checkFileRequest(Request $request)
    {
    	if ($request->hasFile('image')) {
            $file = $request->image;

            if ($file->getClientSize() > 0) {

                $time = time();

                return [
                    'name' => 'image',
                    'originalname' => $time . $file->getClientOriginalName(),
                    'filename' => $time . $file->getClientOriginalName(),
                    'mimetype' => $file->getMimeType(),
                    'contents' => !empty($file->getPathName()) ? file_get_contents($file->getPathName()) : '',
                ];
            }
        }

        return [];
    }
}