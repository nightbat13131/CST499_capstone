<?php
    require_once 'config.php';
class UserEntity
{


    public static function process_new_registraiton(array $post): array {
        //echo '<class UserEntity-process_new_registraiton:';
        //if (IS_DEBUG) {echo '<class UserEntity-process_new_registraiton: '.var_dump($post).'}>';}


        // valudate that data is usable

        $output = ['y','z'];
        $params = [];
        global $registration_req_headers;

        foreach ($registration_req_headers as $_key => $reqkey) {
            if (array_key_exists($reqkey, $post)) {
                $output += ['true'];
            }
        }


        //$output += $post;
        return $output;
    }
}