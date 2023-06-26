<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdController extends AbstractController
{
    /**
     * Permet d'afficher la liste complète des annonces
     * 
     * @Route("/ads", name="ads_index")
     *
     * @param AdRepository $repo
     * @return Response
     */
    //public function index(ManagerRegistry $doctrine): Response
    public function index(AdRepository $repo): Response
    {
        //$repo = $doctrine->getRepository(Ad::class);
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet de créer une nouvelle annonce
     * 
     * @Route("/ads/new", name="ads_creat")
     * 
     * @return Response
     */
    public function create(Request $request, ManagerRegistry $managerRegistry) : Response
    {
        $ad = new Ad();

        /*
        $form = $this->createFormBuilder($ad)
                    ->add('title')
                    ->add('introduction')
                    ->add('content')
                    ->add('rooms')
                    ->add('price')
                    ->add('coverImage')
                    ->add('save', SubmitType::class; [
                        'label' => 'Create new appartment',
                        'attr' => [
                            'class' => 'btn btn-primary'
                        ]
                    ])
                    ->getForm();
        */

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $managerRegistry->getManager();

            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $em->persist($image);
            }

            $em->persist($ad);
            $em->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet d'afficher le formulaire d'édition (pour la modification d'une annonce)
     *
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ManagerRegistry $managerRegistry): Response
    {

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $managerRegistry->getManager();

            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $em->persist($image);
            }

            $em->persist($ad);
            $em->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong>
                ont bien été enregistrées"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }

    /**
     * Permet d'afficher une seule annonce
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */
    //public function show($slug, AdRepository $repo) 
    public function show(Ad $ad): Response
    {
        //je récupère l'annonce qui correspond su slug !
        //$ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }

    #[Route('/ads3', name: 'ads_show_details')]
    public function show2()
    {
        return $this->render('ad/show2.html.twig');
    }
}
