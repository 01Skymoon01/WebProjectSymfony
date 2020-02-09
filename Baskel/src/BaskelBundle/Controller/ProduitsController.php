<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Categories;
use BaskelBundle\Entity\Produits;
use BaskelBundle\Form\CategoriesType;
use BaskelBundle\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class ProduitsController extends Controller
{
    public function afficherProduitsAction()
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> FindAllProducts();

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
        $em -> remove($categorie);
        $em -> flush();

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

        }

        return $this -> render('@Baskel/Produits/ajouterProduit.html.twig',
            array('form' => $form -> createView()));
    }





}
