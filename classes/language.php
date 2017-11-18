<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class language extends application
{
    function getLangText($sessionLang)
    {
        if ($sessionLang == 0) {
            $text = array(
                # form placeholders
                'email-adress' => 'Email adress',
                'password' => 'Password',
                # form statements
                'forgot-password' => 'Forgot your password?',
                'create-account' => 'Create your account',
                'new' => 'New?',
                # buttons
                'continue' => 'Continue',
                'back' => 'Back',
                'register' => 'Register'
            );
            return $text;
        } else {
            $text = array(
                # form placeholders
                'email-adress' => 'Epost adress',
                'password' => 'Lösenord',
                # form questions
                'forgot-password' => 'Glömt ditt lösenord?',
                'create-account' => 'Skapa ditt konto',
                'new' => 'Ny?',
                # buttons
                'continue' => 'Fortsätt',
                'back' => 'Tillbaka',
                'register' => 'Registrera'
            );
            return $text;
        }
    }
} ?>