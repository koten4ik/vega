<?php

class LoginWidget extends CWidget
{


	public  function run()
	{ ?>
        <div id="user_login_block">
        <?$this->render('_loginFormMain', array('model'=>new User('login')));?>
        </div>
        <?
	}
}