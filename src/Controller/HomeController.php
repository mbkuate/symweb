<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {

    /**
     * @Route("/hello/{prenom}/age/{age}", name="hello")
     * @Route("/hello/{prenom}", name="hello_prenom")
     * @Route("/hello", name="hello_base")
     * Montre la page qui dit Bonjour...
     * 
     * @return void
     */
    public function hello($prenom = "anonyme", $age = 0){
        //return new Response("Bonjour " . $prenom . ", vous avez " . $age . "ans!");
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
        );
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function home (){
        $prenoms = array('Lior' => 36, 'Joseph' => 55, 'Anne' => 12);
        return $this->render( 
            'home.html.twig',
            ['title' => "Bonjour à tous!",
            'age' => 19,
            'tableau' => $prenoms
            ]
        );
    }

}

?>