<?php

if (isset($_REQUEST["action"])) {
    switch (utf8_decode(@$_REQUEST["action"])) {
        case "login":
            $result = login(utf8_decode(@$_GET['login']), utf8_decode(@$_GET['pass']));
            echo "$result";
            break;
        case "androidlogin":
            $result = login_android(utf8_decode(@$_GET['username']), utf8_decode(@$_GET['password']));
            echo "$result";
            break;
        case "androidsignup":
            $result = signup_android(utf8_decode(@$_GET['username']), utf8_decode(@$_GET['password']));
            echo "$result";
            break;
        case "androidforgot":
            $result = forgot_android(utf8_decode(@$_GET['username']), utf8_decode(@$_GET['password']));
            echo "$result";
            break;
        case "androidnotification":
            $result = notification_android(utf8_decode(@$_GET['username']), utf8_decode(@$_GET['notification']));
            echo "$result";
            break;
        case "androidsendmail":
            $result = sendmail_android(utf8_decode(@$_GET['username']), utf8_decode(@$_GET['email']), utf8_decode(@$_GET['notification']));
            echo "$result";
            break;
        case "pulse":
            $result = login_pulse(utf8_decode(@$_GET['login']), utf8_decode(@$_GET['pass']));
            echo "$result";
            break;
        case "getperson":
            $result = getperson(utf8_decode(@$_GET['login']), utf8_decode(@$_GET['pass']));
            echo "$result";
            break;
    }
} else {
    echo "NULL";
}

function login_pulse($login, $pass) {
    /**
     * Joomla! External authentication script
     *
     * @author vdespa
     * Version 1.0
     *
     * Code adapted from /index.php
     *
     * @package    Joomla.Site
     *
     * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    if (version_compare(PHP_VERSION, '5.3.1', '<')) {
        die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
    }

    /**
     * Constant that is checked in included files to prevent direct access.
     * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
     */
    define('_JEXEC', 1);

    if (file_exists(__DIR__ . '/defines.php')) {
        include_once __DIR__ . '/defines.php';
    }

    if (!defined('_JDEFINES')) {
        define('JPATH_BASE', __DIR__);
        require_once JPATH_BASE . '/includes/defines.php';
    }

    require_once JPATH_BASE . '/includes/framework.php';

// Instantiate the application.
    $app = JFactory::getApplication('site');

// JFactory
    require_once (JPATH_BASE . '/libraries/joomla/factory.php');


// Hardcoded for now
    $credentials['username'] = $login;
    $credentials['password'] = $pass;

    /**
     * Code adapted from plugins/authentication/joomla/joomla.php
     *
     * @package     Joomla.Plugin
     * @subpackage  Authentication.joomla
     *
     * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */
// Get a database object
    $db = JFactory::getDbo();
    $query = $db->getQuery(true)
            ->select('id, password')
            ->from('#__users')
            ->where('username=' . $db->quote($credentials['username']));

    $db->setQuery($query);
    $result = $db->loadObject();

    if ($result) {
        $match = JUserHelper::verifyPassword($credentials['password'], $result->password, $result->id);

        if ($match === true) {
// Bring this in line with the rest of the system
            $user = JUser::getInstance($result->id);
//   var_dump($user);
            return "id=" . $result->id;
        } else {
// Invalid password
// Prmitive error handling
// die('Invalid password');
            return "id=0";
        }
    } else {
// Invalid user
// Prmitive error handling
//die('Cound not find user in the database');
        return "id=0";
    }
}

function login($login, $pass) {
    /**
     * Joomla! External authentication script
     *
     * @author vdespa
     * Version 1.0
     *
     * Code adapted from /index.php
     *
     * @package    Joomla.Site
     *
     * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    if (version_compare(PHP_VERSION, '5.3.1', '<')) {
        die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
    }

    /**
     * Constant that is checked in included files to prevent direct access.
     * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
     */
    define('_JEXEC', 1);

    if (file_exists(__DIR__ . '/defines.php')) {
        include_once __DIR__ . '/defines.php';
    }

    if (!defined('_JDEFINES')) {
        define('JPATH_BASE', __DIR__);
        require_once JPATH_BASE . '/includes/defines.php';
    }

    require_once JPATH_BASE . '/includes/framework.php';

// Instantiate the application.
    $app = JFactory::getApplication('site');

// JFactory
    require_once (JPATH_BASE . '/libraries/joomla/factory.php');


// Hardcoded for now
    $credentials['username'] = $login;
    $credentials['password'] = $pass;

    /**
     * Code adapted from plugins/authentication/joomla/joomla.php
     *
     * @package     Joomla.Plugin
     * @subpackage  Authentication.joomla
     *
     * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */
// Get a database object
    $db = JFactory::getDbo();
    $query = $db->getQuery(true)
            ->select('id, password')
            ->from('#__users')
            ->where('username=' . $db->quote($credentials['username']));

    $db->setQuery($query);
    $result = $db->loadObject();

    if ($result) {
        $match = JUserHelper::verifyPassword($credentials['password'], $result->password, $result->id);

        if ($match === true) {
// Bring this in line with the rest of the system
            $user = JUser::getInstance($result->id);
//   var_dump($user);
            return $result->id;
        } else {
// Invalid password
// Prmitive error handling
            die('Invalid password');
        }
    } else {
// Invalid user
// Prmitive error handling
        die('Cound not find user in the database');
    }
}

function getperson($login, $pass) {

    /**
     * Joomla! External authentication script
     *
     * @author vdespa
     * Version 1.0
     *
     * Code adapted from /index.php
     *
     * @package    Joomla.Site
     *
     * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    if (version_compare(PHP_VERSION, '5.3.1', '<')) {
        die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
    }

    /**
     * Constant that is checked in included files to prevent direct access.
     * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
     */
    define('_JEXEC', 1);

    if (file_exists(__DIR__ . '/defines.php')) {
        include_once __DIR__ . '/defines.php';
    }

    if (!defined('_JDEFINES')) {
        define('JPATH_BASE', __DIR__);
        require_once JPATH_BASE . '/includes/defines.php';
    }

    require_once JPATH_BASE . '/includes/framework.php';

// Instantiate the application.
    $app = JFactory::getApplication('site');

// JFactory
    require_once (JPATH_BASE . '/libraries/joomla/factory.php');


// Hardcoded for now
    $credentials['username'] = $login;
    $credentials['password'] = $pass;

    /**
     * Code adapted from plugins/authentication/joomla/joomla.php
     *
     * @package     Joomla.Plugin
     * @subpackage  Authentication.joomla
     *
     * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */
// Get a database object
    $db = JFactory::getDbo();
    $query = $db->getQuery(true)
            ->select('id, password')
            ->from('#__users')
            ->where('username=' . $db->quote($credentials['username']));

    $db->setQuery($query);
    $result = $db->loadObject();

    if ($result) {
        $match = JUserHelper::verifyPassword($credentials['password'], $result->password, $result->id);

        if ($match === true) {
// Bring this in line with the rest of the system
            $user = JUser::getInstance($result->id);
//  var_dump($user);
            $response = '<People><Person Name="' . $user->username . '"  Id="' . $user->id . '"  > <Group> ';
            $response .= json_encode($user->groups);
            $response .= "</Group> </Person> </People>";
            $xml = new SimpleXMLElement($response);

            echo $xml->asXML(); //The entire XML tree as a string 
        } else {
// Invalid password
// Prmitive error handling
            die('Invalid password');
        }
    } else {
// Invalid user
// Prmitive error handling
        die('Cound not find user in the database');
    }
}

function login_android($username, $password) {
    /**
     * Joomla! External authentication script
     *
     * @author vdespa
     * Version 1.0
     *
     * Code adapted from /index.php
     *
     * @package    Joomla.Site
     *
     * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    if (version_compare(PHP_VERSION, '5.3.1', '<')) {
        die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
    }

    /**
     * Constant that is checked in included files to prevent direct access.
     * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
     */
    define('_JEXEC', 1);

    if (file_exists(__DIR__ . '/defines.php')) {
        include_once __DIR__ . '/defines.php';
    }

    if (!defined('_JDEFINES')) {
        define('JPATH_BASE', __DIR__);
        require_once JPATH_BASE . '/includes/defines.php';
    }

    require_once JPATH_BASE . '/includes/framework.php';

// Instantiate the application.
    $app = JFactory::getApplication('site');

// JFactory
    require_once (JPATH_BASE . '/libraries/joomla/factory.php');


// Hardcoded for now
    $credentials['username'] = $username;
    $credentials['password'] = $password;

    /**
     * Code adapted from plugins/authentication/joomla/joomla.php
     *
     * @package     Joomla.Plugin
     * @subpackage  Authentication.joomla
     *
     * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license     GNU General Public License version 2 or later; see LICENSE.txt
     */
// Get a database object
    $db = JFactory::getDbo();
    $query = $db->getQuery(true)
            ->select('id, password')
            ->from('#__users')
            ->where('username=' . $db->quote($credentials['username']));

    $db->setQuery($query);
    $result = $db->loadObject();

    if ($result) {
        $match = JUserHelper::verifyPassword($credentials['password'], $result->password, $result->id);

        if ($match === true) {
// Bring this in line with the rest of the system
            $user = JUser::getInstance($result->id);
//            //   var_dump($user);
//            return $result->id;
            $response["username"] = $user->username;
            $response["name"] = $user->username;
            $response["email"] = $user->email;
            $response["message"] = "Welcome, " . $user->username;
            die(json_encode($response));
        } else {
            $response["username"] = "";
            $response["name"] = "";
            $response["email"] = "";
            $response["message"] = "User or Pass invalid.";
            die(json_encode($response));
        }
    } else {
        $response["username"] = "";
        $response["email"] = "";
        $response["name"] = "";
        $response["message"] = "Well, something is wrong!";
        die(json_encode($response));
    }
}

function signup_android($username, $password) {
    /**
     * Joomla! External authentication script
     *
     * @author vdespa
     * Version 1.0
     *
     * Code adapted from /index.php
     *
     * @package    Joomla.Site
     *
     * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    if (version_compare(PHP_VERSION, '5.3.1', '<')) {
        die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
    }

    /**
     * Constant that is checked in included files to prevent direct access.
     * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
     */
    define('_JEXEC', 1);

    if (file_exists(__DIR__ . '/defines.php')) {
        include_once __DIR__ . '/defines.php';
    }

    if (!defined('_JDEFINES')) {
        define('JPATH_BASE', __DIR__);
        require_once JPATH_BASE . '/includes/defines.php';
    }

    require_once JPATH_BASE . '/includes/framework.php';

// Instantiate the application.
    $app = JFactory::getApplication('site');

// JFactory
    require_once (JPATH_BASE . '/libraries/joomla/factory.php');

    require_once (JPATH_BASE . '/components/com_users/models/registration.php');

    $app->initialise();

    $language = & JFactory::getLanguage();
    $extension = 'mod_login';
    $extension = 'com_users';
    $base_dir = dirname(__FILE__);
    $language_tag = $language->getTag(); // loads the current language-tag
    $language->load($extension, $base_dir, $language_tag, true);

    $model = new UsersModelRegistration();
    jimport('joomla.mail.helper');
    jimport('joomla.user.helper');


    $name = $username;
    $email = $username;

    $data = array('username' => $username,
        'name' => $name,
        'email1' => $email,
        'password1' => $password, // First password field
        'password2' => $password, // Confirm password field
        'block' => 0);


    if ($model->register($data)) {
        $response['username'] = $username; // add username
        $response['name'] = $username; // add username
        $response['email'] = $email; // add email
        $response["message"] = JText::sprintf(JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));

        die(json_encode($response));
    } else {
        $response['username'] = $username; // add username
        $response['name'] = $username; // add username
        $response['email'] = $email; // add email

        $response["message"] = JText::sprintf(JText::_('COM_USERS_REGISTER_EMAIL1_MESSAGE'));
        die(json_encode($response));
    }
}

function signup_android2($username, $password) {
    /**
     * Joomla! External authentication script
     *
     * @author vdespa
     * Version 1.0
     *
     * Code adapted from /index.php
     *
     * @package    Joomla.Site
     *
     * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later; see LICENSE.txt
     */
    if (version_compare(PHP_VERSION, '5.3.1', '<')) {
        die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
    }

    /**
     * Constant that is checked in included files to prevent direct access.
     * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
     */
    define('_JEXEC', 1);

    if (file_exists(__DIR__ . '/defines.php')) {
        include_once __DIR__ . '/defines.php';
    }

    if (!defined('_JDEFINES')) {
        define('JPATH_BASE', __DIR__);
        require_once JPATH_BASE . '/includes/defines.php';
    }

    require_once JPATH_BASE . '/includes/framework.php';

    $mainframe = & JFactory::getApplication('site');
    $mainframe->initialise();
    $user = clone(JFactory::getUser());
    $pathway = & $mainframe->getPathway();
    $config = & JFactory::getConfig();
    $db = JFactory::getDBO();
    $authorize = & JFactory::getACL();
    $document = & JFactory::getDocument();

    $email = $username;
    $response = array();
    $usersConfig = & JComponentHelper::getParams('com_users');

    $language = & JFactory::getLanguage();
    $extension = 'mod_login';
    $extension = 'com_users';
    $base_dir = dirname(__FILE__);
    $language_tag = $language->getTag(); // loads the current language-tag
    $language->load($extension, $base_dir, $language_tag, true);
    //$language->load('com_users', JPATH_BASE);

    if ($usersConfig->get('allowUserRegistration') == '1') {
        // Initialize new usertype setting
        jimport('joomla.user.user');
        jimport('joomla.application.component.helper');
        $useractivation = $usersConfig->get('useractivation');
        // Default group, 2=registered
        $defaultUserGroup = 2;

        jimport('joomla.user.helper');
        $salt = JUserHelper::genRandomPassword(32);
        $password_clear = $password;

        $crypted = JUserHelper::getCryptedPassword($password_clear, $salt);
        $password = $crypted . ':' . $salt;
        $instance = JUser::getInstance();
        $instance->set('id', 0);
        $instance->set('name', $username);
        $instance->set('username', $username);
        $instance->set('password', $password);
        $instance->set('password_clear', $password_clear);
        $instance->set('email', $email);
        $instance->set('usertype', 'deprecated');
        $instance->set('groups', array($defaultUserGroup));
        // Here is possible set user profile details
        // $instance->set('profile', array('gender' => $gender));
        // Email with activation link
        if ($useractivation == 1) {
            $instance->set('block', 1);
            $instance->set('activation', JApplication::getHash(JUserHelper::genRandomPassword()));
        }

        if (!$instance->save()) {
            $response['username'] = $username; // add username
            $response['email'] = $email; // add email
            $response["message"] = "E-mail alread exist.";
            $emailSubject = JText::sprintf(JText::_('COM_USERS_EMAIL_ACCOUNT_DETAILS'), $data['name'], $data['sitename']);

            die(json_encode($emailSubject));
        } else {
            $db->setQuery("update #__users set email='$email' where username='$username'");
            $db->query();

            $db->setQuery("SELECT id FROM #__users WHERE email='$email'");
            $db->query();
            $newUserID = $db->loadResult();

            $user = & JFactory::getUser($newUserID);
            $config = & JFactory::getConfig();

            // Compile the notification mail values.
            $data = $user->getProperties();
            $data['fromname'] = $config->get('fromname');
            $data['mailfrom'] = $config->get('mailfrom');
            $data['sitename'] = $config->get('sitename');
            $data['siteurl'] = JUri::root();
            // Everything OK!               
            if ($user->id != 0) {
                // Auto registration
                if ($useractivation == 0) {

                    $emailSubject = 'Email Subject for registration successfully';
                    $emailBody = 'Email body for registration successfully';
                    $uri = JUri::getInstance();
                    $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
                    $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

                    $emailSubject = JText::sprintf('COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']);

                    if ($sendpassword) {
                        $emailBody = JText::sprintf('COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']);
                    } else {
                        $emailBody = JText::sprintf('COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']);
                    }
                    //$return = JFactory::getMailer()->sendMail('sender email', 'sender name', $user->email, $emailSubject, $emailBody);
                    // $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

                    $response['username'] = $username; // add username
                    $response['email'] = $email; // add email
                    $response["message"] = "Your account has been created and a verification link has been sent to the email address you entered. Note that you must verify the account by clicking on the verification link when you get the email and then an administrator will activate your account before you can login." . $user_activation_url;
                    die(json_encode($emailBody));
                } else if ($useractivation == 1) {
//                    $emailSubject = 'Email Subject for activate the account';
//                    $emailBody = 'Email body for for activate the account \n <br>'.$user_activation_url;
                    $user_activation_url = JURI::base() . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $user->activation, false);  // Append this URL in your email body
//                    $emailBody = 'Email body for for activate the account \n <br>'.$user_activation_url;
//                    $return = JFactory::getMailer()->sendMail('sender email', 'sender name', $user->email, $emailSubject, $emailBody);
                    $uri = JUri::getInstance();
                    $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
                    $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

                    $emailSubject = JText::sprintf('COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']);

                    if ($sendpassword) {
                        $emailBody = JText::sprintf('COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']);
                    } else {
                        $emailBody = JText::sprintf('COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']);
                    }
                    // $return = JFactory::getMailer()->sendMail('sender email', 'sender name', $user->email, $emailSubject, $emailBody);
                    //  $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);
                    $response['name'] = $username; // add username
                    $response['username'] = $username; // add username
                    $response['email'] = $email; // add email
                    $response["message"] = "Your account has been created and a verification link has been sent to the email address you entered. Note that you must verify the account by clicking on the verification link when you get the email and then an administrator will activate your account before you can login.";
                    die(json_encode($emailBody));
                }
            }
        }
    } else {
        $response['name'] = $username; // add username
        $response['username'] = $username; // add username
        $response['email'] = $email; // add email
        $response["message"] = "allowUserRegistration=false";
        die(json_encode($response));
    }
}

function forgot_android($username, $password) {
    $response["username"] = $username;
    $response['name'] = $username; // add username
    $response["email"] = $password;
    $response["message"] = "Message will be send to you.";
    die(json_encode($response));
}

function notification_android($username, $notification) {
    $response["username"] = $username;
    $response['name'] = $username; // add username
    $response["notification"] = $notification;
    $response["message"] = "Message will be send to you.";
    die(json_encode($response));
}

function sendmail_android($username, $email, $notification) {
    $response["username"] = $username;
    $response['email'] = $email; // add username
    $response["notification"] = $notification;

    define('EMAIL_DEFAULT_FROM_NAME', 'Myself');
    define('FORM_BLOCK_SENDER_EMAIL', EMAIL_DEFAULT_FROM_ADDRESS);
    $to = 'contato@neovu.com.br'; //please put ours.
    $from = 'webmaster@neovu.com.br'; //please put ours.

    $names = filter_var($username, FILTER_SANITIZE_STRING);
    $emails = filter_var($email, FILTER_SANITIZE_EMAIL);
    $subjects = filter_var($email, FILTER_SANITIZE_STRING);
    $messages = filter_var($notification, FILTER_SANITIZE_STRING);


    $subject = 'From: ' . $emails . ' : ' . $subjects;
    if (mail($to, $subject, $messages, 'From: ' . $from)) {
        $response["message"] = 'success|Obrigado, ' . $names . '. Retornaremos em assim que possível.';
    } else {
        $response["message"] = 'error|Opa, ' . $names . ' aconteceu algum problema no envio. Tente direto pelo email contato@neovu.com.br!';
    }
        
    die(json_encode($response));
}
