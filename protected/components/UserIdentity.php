<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    /**
     * Authenticates a user using the User data model.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = User::model()->findByPk($this->username);
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            echo 'INVALID';
        } else {
            if ($user->password !== $user->encrypt($this->password)) {
                echo $user->password ."<br/>" . $user->encrypt($this->password);
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->_id = $user->username;
                $this->errorCode = self::ERROR_NONE;
                $u = Userid::model()->findByAttributes(array('username' => $user->username));
                $id = Userid::model()->findByAttributes(array('userid' => $_POST['userid']));
                if($u !== $id || $u === null){
	                if($u === null && $id === null){
	               		$uid = new Userid;
	               		$uid->attributes = array('username' => $user->username, 'userid' => $_POST['userid']);
	               		$uid->save();
	                }else if($u === null){
	                	$id->username = $user->username;
	                	$id->save();
	                }else{
	                	$id->delete();
	                	$u->userid = $_POST['userid'];
	                	$u->save();
	                }
                }
            }
        }
        return !$this->errorCode;
    }
    
    public function getId(){
        return $this->_id;
    }
}