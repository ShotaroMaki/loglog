<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Core\Configure;
use DateTime;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Security');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
        
        // ------------------------
        // グローバル変数
        // ------------------------
        $loginUserName = null;
        $sessionAuthClass = null;


        $sessionCompanyId = null;
        $sessionUserId = null;
        $sessionSecurityId = null;
        
////////   あくまでも仮 2021.11.22 tas ///////////////////////////////////
		$sessionCompanyId = 'shiguma';
		$sessionUserId = 1;
		$sessionSecurityId = 1;
////////   あくまでも仮 2021.11.22 tas ///////////////////////////////////
                
        $this->request->getSession()->write('sessionCompanyId', $sessionCompanyId);
        $this->request->getSession()->write('sessionUserId', $sessionUserId);
        $this->request->getSession()->write('sessionSecurityId', $sessionSecurityId);
        
    }
    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter(EventInterface $event)
	{
		// セッションタイムアウト変更する
		Configure::write('Session', [
				'defaults' => 'php',
				// 3時間もあれば十分か（ココは分指定）
				'timeout'=> 60*3,
				// 上記のみでは効かないので指定追加
				// 一部のページだけ有効期間を延ばしても同一サーバに有効期間の短いセッションがあると消されるため
				'ini' => [
						'session.gc_divisor'	=> 60*60*3,      // gc_probability 0 なので何でもよい
						'session.gc_maxlifetime'=> 60*60*3,  // 3 Hours(ココは秒指定)
						'session.gc_probability'=> 0,
				]
		]);

	}
    /**
     * checkSession method
     *
     * @return void
     */
	public function checkSession() {
	    if (!$this->request->getSession()->check("LOGIN")) {
			$this->redirect(
			            		['controller' => '/MlLogin/Login', 'action' => 'index']
				        	);
	        exit();
	    }
	}
}
