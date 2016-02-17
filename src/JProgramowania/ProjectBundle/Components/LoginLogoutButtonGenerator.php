<?php

namespace JProgramowania\ProjectBundle\Components;

class LoginLogoutButtonGenerator
{
    public static function generateButton($controller, $login_form, $logout_form)
    {
        if($controller->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $loginlogout = $controller->createForm($logout_form, array());
        }
        else
        {
            return $loginlogout = $controller->createForm($login_form, array());
        }
    }

    public static function generateMessage($controller)
    {
        if($controller->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $login_message = $controller->get('security.context')->getToken()->getUser()->getUsername();
        }
        else
        {
            return $login_message = "";
        }
    }
}