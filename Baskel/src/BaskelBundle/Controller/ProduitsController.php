<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Categories;
use BaskelBundle\Entity\Produits;
use BaskelBundle\Form\CategoriesType;
use BaskelBundle\Form\ProduitsModifType;
use BaskelBundle\Form\ProduitsType;
use BaskelBundle\Form\rechercherProdBackType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class ProduitsController extends Controller
{

    public function alertAction()
    {

        return $this -> render('@Baskel/Produits/alert.html.twig');
    }

    public function afficherProduitsAction()
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->findAll();

        return $this -> render('@Baskel/Produits/afficherProduits.html.twig', array('produit' => $produit));
    }

    public function ajouterCategorieAction(Request $request)
    {
        $categorie = new Categories();
        $form = $this -> createForm(CategoriesType::class, $categorie) -> handleRequest($request);
        $em = $this -> getDoctrine() -> getManager();

        if ($form -> isSubmitted() and $form -> isValid()) {
            $em -> persist($categorie);
            $em -> flush();

            return $this -> redirectToRoute('afficherCategories');

        }

        return $this -> render('@Baskel/Produits/ajouterCategorie.html.twig',
            array('form' => $form -> createView()));
    }

    public function afficherCategoriesAction()
    {
        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();

        return $this -> render('@Baskel/Produits/afficherCategories.html.twig', array('categorie' => $categorie));
    }

    function supprimerCategorieAction($ref_c)
    {
        $em = $this -> getDoctrine() -> getManager();
        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            -> find($ref_c);
        try {
            $em -> remove($categorie);
            $em -> flush();


        } catch (ForeignKeyConstraintViolationException $e){
            $this->addFlash('error',"Vous ne pouvez pas supprimer une catégorie pleine.");
        }

        return $this -> redirectToRoute('afficherCategories');
    }


    public function ajouterProduitAction(Request $request)
    {
        $produit = new Produits();
        $form = $this -> createForm(ProduitsType::class, $produit) -> handleRequest($request);
        $em = $this -> getDoctrine() -> getManager();

        if ($form -> isSubmitted() and $form -> isValid()) {
            /**
             * @var UploadedFile $file
             */

            $file = $produit->getImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $produit->setImage($fileName);

            $em -> persist($produit);
            $em -> flush();

            return $this -> redirectToRoute('afficherProduitsBack');

        }

        return $this -> render('@Baskel/Produits/ajouterProduit.html.twig',
            array('form' => $form -> createView()));
    }


    public function afficherProduitsBackAction()
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->findAll();

        return $this -> render('@Baskel/Produits/afficherProduitsBack.html.twig', array('produits' => $produit));
    }


    function supprimerProduitAction($ref_p)
    {

        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($ref_p);

        $image=$produit->getImage();
        $path=$this->getParameter('image_directory').'/'.$image;
        $fs=new Filesystem();
        $fs->remove(array($path));
        $em = $this -> getDoctrine() -> getManager();
        $em -> remove($produit);
        $em -> flush();

        return $this -> redirectToRoute('afficherProduitsBack');

    }


    function modifierCategorieAction(Request $request, $ref_c)
    {
        $em = $this -> getDoctrine() -> getManager();
        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            -> find($ref_c);
        $form = $this -> createForm(CategoriesType::class, $categorie);
        $form -> handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()) {

            $categorie->setRefC($ref_c);
            $em -> flush();
            return $this -> redirectToRoute('afficherCategories');
        }
        return $this->render('@Baskel/Produits/modififerCategorie.html.twig',
            array('form'=>$form->createView()));
    }

    function modifierProduitAction(Request $request, $ref_p)
    {
        $em = $this -> getDoctrine() -> getManager();
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($ref_p);

        $form = $this -> createForm(ProduitsModifType::class, $produit);
        $form -> handleRequest($request);

        if ($form -> isSubmitted()) {

            /*------------------------------------------------------------------------------------------------------------*/


            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image'] -> getData();
            if ($uploadedFile) {
                $destination = $this -> getParameter('image_directory');
                $originalFilename = pathinfo($uploadedFile -> getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $produit -> getImage($originalFilename) . '-' . uniqid() . '.' . $uploadedFile -> guessExtension();
                $uploadedFile -> move(
                    $destination,
                    $newFilename
                );
                $produit -> setImage($newFilename);
            }


            /*------------------------------------------------------------------------------------------------------------*/


            $em -> flush();

            return $this -> redirectToRoute('afficherProduitsBack');
        }

        return $this->render('@Baskel/Produits/modifierProduit.html.twig',
            array('form'=>$form->createView()));
    }




    /*public function modalContentAction($refP)
    {
        $em = $this -> getDoctrine() -> getManager();
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($refP);

        return $this -> render('@Baskel/Produits/modalContent.html.twig', array('produit' => $produit));
    }*/


    /**
     * @Route("/", name="modalContent")
     */
    public function modalContentAction( Request $request ){
        $id = $request->query->get('id');

        return $this -> render('@Baskel/Produits/modalContent.html.twig', array('id' => $id));

    }


    public function rechercherProdBackAction(Request $request)
    {

        $produit= new Produits();
        $Form=$this->createForm(rechercherProdBackType::class,$produit);
        $em = $this->getDoctrine()->getManager();
        $Form->handleRequest($request);
        if($Form->isSubmitted()){
            $produit = $this
                ->getDoctrine()
                ->getRepository(Produits::class)
                ->findBy(array('ref_p'=>$produit->getRefP()));
        } else {
            $produit = $em->getRepository("BaskelBundle:Produits")->findAll();
        }


        return $this->render('@Baskel/Produits/afficherProduitsBack.html.twig',
            array('form' => $Form->createView() ,
                'prod'=>$produit));

    }


}
