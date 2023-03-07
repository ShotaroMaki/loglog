<?php

/**
 * @file      send message to db (NEW API)
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

class SendMessageAPIController extends AppController
{

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
    /*
         *
         *
         */
    public function index($room_id = null, $content = null)
    {

        // 共通のComponentを呼び出す
        $common = new CommonComponent();

        // urlからユーザーコードを取得する
        $user_cd = $this->request->getQuery('user_cd'); //check if USER_CD ある？
        $shop_cd = $this->request->getQuery('shop_cd');  //check if SHOP_CD ある？
        $room_id = $this->request->getQuery('room_cd');
        $content = $this->request->getQuery('content'); //messsage thru URL (not safe)

      

        //if room_cd NOT NULL
        if ($room_id) {
            $roomCheck = $common->getShopRoomID($user_cd);
            $checkShop_cd = $roomCheck[0]['shop_cd'];
            $checkUser_cd = $roomCheck[0]['user_cd'];

            //check if URL have user_cd
            if ($user_cd) {

                $sendMSGData = $common->sendUserMessageData($room_id, $user_cd, $checkShop_cd, $content);

                sleep(15); //sleep

                //AUTORESPONSE 機能まだありません
                //REMOVE THIS WHEN MESSAGE INTERFACE in WEB OKAY 2023/02/22
                $common->sendShopMessageData($room_id, $user_cd, $checkShop_cd, "メッセージありがとうございます。申し訳ございませんが、現在はチャットに対応できる状態ではありません");
                

                foreach ($sendMSGData as $data) {
                    $aryAddRow =  array(
                        'room_id'        => strval($data['room_id']),
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
            //check if URL have shop_cd, 
            //SHOP message cannot be sent first
            else if ($shop_cd) {

                $sendMSGData = $common->sendShopMessageData($room_id, $checkUser_cd, $shop_cd, $content);

                foreach ($sendMSGData as $data) {
                    $aryAddRow =  array(
                        'room_id'        => strval($data['room_id']),
                        'user_cd'        => $data['user_cd'],
                        'shop_cd'        => $data['shop_cd'],
                        'datesent'       => $data['datesent'],
                        'content'        => $data['content'],
                        'seen'           => $data['seen'],
                        'sender'         => $data['sender'],
                    );
                    $json_array[] = $aryAddRow;
                }
            } else { //if room_cdかuser_cdかshop_cd IS NULL
                $json_array[] = ""; //return nothing MF!
            }
        } else {

            //No ROOM ID, Yes user_cd
            if ($user_cd) {
                //make room ID here and pass the message
                $roomData = $common->createRoomID($user_cd, $shop_cd);
                $newRoom_id = $roomData[0]['room_id'];

                //if ($user_cd) {
                $sendMSGData = $common->sendUserMessageData($newRoom_id, $user_cd, $shop_cd, $content);

                foreach ($sendMSGData as $data) {
                    $aryAddRow =  array(
                        'room_id'        => strval($data['room_id']),
                        'user_cd'        => $data['user_cd'],
                        'shop_cd'        => $data['shop_cd'],
                        'datesent'       => $data['datesent'],
                        'content'        => $data['content'],
                        'seen'           => $data['seen'],
                        'sender'         => $data['sender'],
                    );
                    $json_array[] = $aryAddRow;
                }
                //}

                //ONLY USERS can send first message-------------------------------------------------------

                // if ($shop_cd) {

                //     $sendMSGData = $common->sendShopMessageData($newRoom_id, $user_cd, $shop_cd, $content);

                //     foreach ($sendMSGData as $data) {
                //         $aryAddRow =  array(
                //             'room_id'        => $data['room_id'],
                //             'user_cd'           => $data['user_cd'],
                //             'shop_cd'        => $data['shop_cd'],
                //             'datesent'       => $data['datesent'],
                //             'content'        => $data['content'],
                //             'seen'           => $data['seen'],
                //             'sender'           => $data['sender'],
                //         );
                //         $json_array[] = $aryAddRow;
                //     }
                // }
            } else {
                $json_array[] = "";
            }
        }

        //index.php に投げる
        $this->set(compact('json_array', 'sendMSGData'));

        // JSON で出力
        $this->viewBuilder()
            ->setClassName('Json')
            ->setOption('serialize', 'json_array');
    }
}
