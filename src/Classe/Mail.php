<?php

namespace App\Classe;

use \Mailjet\Resources;
use \Mailjet\Client;



class Mail
{

    public function send($to_email, $to_name, $subject, $template, $variables = null)
    {

        // template
        $content = file_get_contents(dirname(__DIR__ ).$template);

        // variable facultatives
        if ($variables) {
            foreach ($variables as $key => $variable) {
               $content = str_replace('{' . $key . '}', $variable, $content);
            }
        }

        $mj = new Client(
            $_ENV['MJ_APIKEY_PUBLIC'],
            $_ENV['MJ_APIKEY_PRIVATE'],
            true,
            ['version' => 'v3.1']
        );

        
        
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "tournieraurore@orange.fr",
                        'Name' => "Restaurant The District"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID'=> 6848821,
                    'TemplateLanguage' =>true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];
        
        
       $response = $mj->post(Resources::$Email, ['body' => $body]);

    
    }

}