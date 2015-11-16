<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 主逻辑
 * 主要是处理 onMessage onClose 方法
 */

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;
class Event
{
	/**
    * 将整个ip下的所有数据全部发送到客户端
    * 在gateway下，页面刷新或关闭都会导到client_id的失效，为了保证能发送到符合要求的客户端，引入组概念。
    * 每次发送消息，都将向所有同一个ip下所有的客户端发送。
    * @param int $client_id
    * @param string $message
    */
	public static function merge_client_id($group,$data){
        $client_array= array();
        foreach($group as $value){
	        foreach($data as $v){
		        if(in_array($v,$value)){
		        	$client_array = array_merge($client_array,$value);
		        	break;
		        }

	        }
        
        };	
		return $client_array;

	}
   /**
    * 有消息时
    * @param int $client_id
    * @param string $message
    */
   public static function onMessage($client_id, $message)
   {	
   		$db = Db::instance('db');
        // debug
        //echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
 		//$db->query("INSERT INTO `hs_test` (`ip`, `content`) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$client_id."')");
		$select = $db->query("select `content`,`ip` from `hs_test`");
		//var_dump($select);
		foreach($select as $v){
			$clients[$v['ip']][]=$v['content'];
		}

		//var_dump($clients);
		// echo $message;
        ///echo $client_id;
        // 客户端传递的是json数据
        $message_data = json_decode($message, true);
        if(!$message_data)
        {
            return ;
        }
var_export($message_data);
        // 根据类型做相应的业务逻辑
        switch($message_data['type'])
        {
            // 发送数据给用户 message: {type:send, to_client_id:xx, content:xx}
        	case 'login':
        		//$db = Db::instance('db');
				$db->update('hs_craftsman')->cols(array('client_id'=>$client_id))->where('craftsmanid='.$message_data['id'])->query();
				$db->query("INSERT INTO `hs_test` (`ip`, `content`) VALUES ('".$message_data['id']."','".$client_id."')");
				break;
        	case 'group':
        		echo $message_data['id']."\n";
        		$db->query("INSERT INTO `hs_test` (`ip`, `content`) VALUES ('".$message_data['id']."','".$client_id."')");
        		break;
        	case 'order':
        		if(empty($message_data['data'])) return ;
				/*	$send_data = array();
					$send_data['type']  = $message_data['data']['order_type'];
					$send_data['orderid']    = $message_data['data']['orderid'];
					$client_array_id = self::merge_client_id($clients,$message_data['data']['to_client_id']);
					echo "***************************";
					var_export($client_array_id);
					Gateway::sendToAll(json_encode($send_data),$client_array_id);        		
        		*/
				foreach($message_data['data'] as $data){
					$send_data = array();
					echo $send_data['type']         = $data['order_type'];
					 echo "****************\n";
					$send_data['orderid']      = $data['orderid'];
					//var_export($data['to_client_id']);
					//echo ('-----------/n');
					$client_array_id = self::merge_client_id($clients,$data['to_client_id']);
					var_export($client_array_id);
					Gateway::sendToAll(json_encode($send_data),$client_array_id);
				};
				break;
			case 'send':
            	//var_dump($message_data['data']);
            	if(is_array($message_data['data'])){//向群组发
	            	foreach($message_data['data'] as $data){
	                    $new_message = array(
	                            'type'=>'send',
	                            'from_client_id'=>$client_id,
	                            'to_client_id'=>$data['to_client_id'],
	                            'orderid'=>$data['orderid'],
	                            'time'=>date('Y-m-d H:i:s'),
	                    );	
	                   	$client_array_id = self::merge_client_id($clients,$data['to_client_id']);  
	                   //	var_dump($data['to_client_id']);
	                   	//echo "**********".$client_id."************";
	                   	//var_dump($client_array_id);
	            		Gateway::sendToAll(json_encode($new_message),$client_array_id);
	            		//return Gateway::sendToAll(json_encode($new_message),array(97,98,99));
	            		//return Gateway::sendToAll(json_encode($new_message));
	            	}
            	
            	
            	}else if($message_data['to_client_id'] != 'all')//向单个发
                {
                    $new_message = array(
                            'type'=>'send',
                            'from_client_id'=>$client_id,
                            'to_client_id'=>$message_data['to_client_id'],
                            'orderid'=>nl2br($message_data['orderid']),
                            'time'=>date('Y-m-d H:i:s'),
                    );
                    return Gateway::sendToClient($message_data['to_client_id'], json_encode($new_message));
                }else {
	                 // 向所有浏览器发送消息
	                $new_message = array(
	                        'type'=>'send',
	                        'from_client_id'=>$client_id,
	                        'to_client_id'=>'all',
	                        'orderid'=>nl2br($message_data['orderid']),
	                        'time'=>date('Y-m-d H:i:s'),
							'ss'=>'taotao',
	                );
	                return Gateway::sendToAll(json_encode($new_message));               
                }
				
				return true;
				//$db = Db::instance('db');
				//$data = $db->update("SELECT ID,Sex FROM `hs_admin` WHERE userid=1");
				//echo $row_count = $db->update('hs_admin')->cols(array('roleid'=>'10'))->where('userid=1')->query();
				//var_dump($data);
				
				

        }
   }
   
   /**
    * 当用户断开连接时
    * @param integer $client_id 用户id
    */
   public static function onClose($client_id)
   {
       // debug
       echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:{$client_id}\n";
   	//Db::instance('db')->delete('hs_test')->where("`ip`='".$_SERVER['REMOTE_ADDR']."'")->query();
   //Db::instance('db')->lastSQL();
   }
   
   public static function onConnect($client_id)
   {
	//$db = Db::instance('db');
	//$db->query("INSERT INTO `hs_test` (`ip`, `content`) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$client_id."')");
	//$db->query("INSERT INTO `hs_test` (`ip`, `content`) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$client_id."')");
	//$db->select('lastloginip')->from('Persons')->where("sex= 'F' ")->column();
   //	echo"-------------onconnect--------------\n";	
   //	var_export(Gateway::getOnlineStatus());

   		//echo"------------onconnect end---------------\n";	
	   // echo "onConnect---client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id\n";
   }
     
}
