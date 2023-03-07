<?php

/**
 * @file      get message from db (NEW API)
 * @author    KARL
 * @date      2023/02
 * @version   69
 * @note      
 */

namespace App\Controller\MlWebApi;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\MlCommon\CommonComponent;

class GetMessageAPIController extends AppController
{
    /*
         * 
         *
         */
    public function beforeFilter(EventInterface $event)
    {

        parent::beforeFilter($event);

        // '_cake_core_' のキャッシュを削除
        Cache::clear('_cake_core_');

        // 'default' のキャッシュを削除
        Cache::clear();

        // ajaxでPOSTするFunctionのみ許可
        $this->Security->setConfig('unlockedActions', ['ajaxShow', 'index']);
    }

    public function index($user_cd = null, $room_id = null, $shop_cd = null)
    {

        // 共通のComponentを呼び出す
        $common = new CommonComponent();

        // urlからユーザーコードを取得する
        $user_cd = $this->request->getQuery('user_cd'); //check if USER_CD ある？
        $shop_cd = $this->request->getQuery('shop_cd');  //check if SHOPC＿D ある？
        $room_id = $this->request->getQuery('room_cd');

        //if room_cd NOT NULL
        if ($room_id) {

            //add check for user_cd and shop_cd MATCH
            //$roomVal = $common->roomUsersCheck($room_id);
            //if($user_cd=roomVal[0]['user_cd'] || $shop_cd=roomVal[0]['shop_cd'] )

            $msgData = $common->getMessageData($room_id);
            if ($msgData) {
                foreach ($msgData as $data) {
                    $aryAddRow =  array(
                        'room_id'        => $data['room_id'],
                        'user_cd'        => $data['user_cd'],
                        'shop_cd'        => $data['shop_cd'],
                        'datesent'       => $data['datesent'],
                        'content'        => $data['content'],
                        'seen'           => $data['seen'],
                        'sender'         => $data['sender'],
                    );
                    $json_array[] = $aryAddRow;
                }
            }
            else{
                //IF msgData is NUll
                $roomInfo = $common->getRoomInfo($room_id);

                //user_cd, room_id, shop_cd to LOAD MESSAGE 
                foreach ($roomInfo as $data) {
                    $aryAddRow =  array(
                        'room_id'        => $data['room_id'],
                        'user_cd'        => $data['user_cd'],
                        'shop_cd'        => $data['shop_cd'],
                        'datesent'       => "",
                        'content'        => "",
                        'seen'           => "",
                        'sender'         => "",
                    );
                    $json_array[] = $aryAddRow;
                }


            }
        } else { //if room_cd IS NULL
            $json_array[] = ""; //return nothing MF!
        }

        //  $json_array[] = $msg_shopInfo;


        //index.php に投げる
        $this->set(compact('json_array', 'msgData'));

        //JSON で出力
        $this->viewBuilder()
            ->setClassName('Json')
            ->setOption('serialize', 'json_array');
    }
}
