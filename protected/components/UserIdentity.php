<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user using the User data model.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = User::model()->findByPk($this->username);
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->password !== $user->encrypt($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return !$this->errorCode;
    }
}