<?php 

namespace Core;

defined('ROOTPATH') OR exit('Access Denied!');

class Session
{
    public $mainkey = 'APP';
    public $userkey = 'USER';

    /** starts the session **/
    private function start_session(): int
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        return 1;
    }

    /** puts data into the session **/
    public function set(mixed $keyOnArray, mixed $value = ' '): int
    {
        $this->start_session();

        if(is_array($keyOnArray))
        {
            foreach ($keyOnArray as $key => $value)
            {
                $_SESSION[$this->mainkey][$key] = $value;
            }

            return 1;
        }

        $_SESSION[$this->mainkey][$keyOnArray] = $value;

        return 1;
    }

    /** gets data from the session, return default if data is not found **/
    public function get(string $key, mixed $default = ''): mixed
    {
        $this->start_session();

        if (isset($_SESSION[$this->mainkey][$key]))
        {
            return $_SESSION[$this->mainkey][$key];
        }

        return $default;
    }

    /** saves the user row data after login **/
    public function auth(mixed $user_row): int
    {
        $this->start_session();

        $_SESSION[$this->userkey] = $user_row;

        return 0;
    }

    /** removes user row data from the session **/
    public function logout(): int
    {
        $this->start_session();

        if (!empty($_SESSION[$this->userkey]))
        {
            unset($_SESSION[$this->userkey]);
        }

        return 0;
    }

    /** checks if the user is logged in **/
    public function is_logged_in(): bool
    {
        $this->start_session();

        if (!empty($_SESSION[$this->userkey]))
        {
            return true;
        }

        return false;
    }

    /** gets data from a column in the user data session **/
    public function user(string $key = '', mixed $default = ''): mixed
    {
        $this->start_session();

        if (empty($key) && !empty($_SESSION[$this->userkey]))
        {
            return $_SESSION[$this->userkey];
        }
        else if (!empty($_SESSION[$this->userkey]->$key))
        {
            return $_SESSION[$this->userkey]->$key;
        }

        return $default;
    }

    /** gets data from a key and deletes it **/
    public function pop(string $key = '', mixed $default = ''): mixed
    {
        $this->start_session();

        if (!empty($_SESSION[$this->mainkey][$key]))
        {
            $value = $_SESSION[$this->mainkey][$key];

            unset($_SESSION[$this->mainkey][$key]);
            return $value;
        }

        return $default;
    }

    /** returns all data from the app **/
    public function get_all(): mixed
    {
        $this->start_session();

        if (isset($_SESSION[$this->mainkey]))
        {
            return $_SESSION[$this->mainkey];
        }

        return [];
    }
}
