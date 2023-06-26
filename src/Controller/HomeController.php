<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {

    /**
     * @Route("/hello/{prenom}/age/{age}", name="hello_prenom_age")
     * @Route("/hello/{prenom}", name="hello_prenom")
     * @Route("/hello", name="hello_base")
     * Montre la page qui dit Bonjour...
     * 
     * @return void
     */
    public function hello($prenom = "anonyme", $age = 0){
        //return new Response("Bonjour " . $prenom . ", vous avez " . $age . "ans!");
        $visitor = array('lastname' => 'Lior', 'firstname' => 'Joesph', 'age' => 33);
        return $this->render(
            'hello.html.twig',
            [
                'title' => "Hello world!",
                'user' => $visitor
            ]
        );
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function home (){
        return $this->render( 
            'home.html.twig'
        );
    }
    /**
     * @Route("/home2", name="homepage2")
     */
    public function home2 (){
        return $this->render( 
            'home2.html.twig'
        );
    }

}

?>