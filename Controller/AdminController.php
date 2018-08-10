<?php

namespace Navalex\ConfigBundle\Controller;

use Navalex\ConfigBundle\Entity\Category;
use Navalex\ConfigBundle\Entity\Configuration;
use Navalex\ConfigBundle\Entity\Fieldset;
use Navalex\ConfigBundle\Form\CategoryType;
use Navalex\ConfigBundle\Form\ConfigurationType;
use Navalex\ConfigBundle\Form\FieldsetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoryList = $em->getRepository('NavalexConfigBundle:Category')->findAll();

        return $this->render('NavalexConfigBundle:Admin:home.html.twig', [
            'categoryList' => $categoryList,
        ]);
    }
    public function listAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $categoryList = $em->getRepository('NavalexConfigBundle:Category')->findAll();

        $category = $em->getRepository('NavalexConfigBundle:Category')->find($id);

        if($request->isMethod('POST')) {
            foreach ($request->request->all() as $key => $value) {
                $config = $em->getRepository('NavalexConfigBundle:Configuration')->find($key);
                $config->setValue($value);

                $em->persist($config);
            }

            $em->flush();
        }

        return $this->render('NavalexConfigBundle:Admin:list.html.twig', [
            'categoryList' => $categoryList,
            'category' => $category,
            'post' => $request->request->all()
        ]);
    }

    public function listCatAction(Request $request, $mode, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryList = $em->getRepository('NavalexConfigBundle:Category')->findAll();

        switch ($mode) {
            case "cat":
                $form_data = new Category();
                $form = $this->createForm(CategoryType::class, $form_data);
                $query = $em->getRepository('NavalexConfigBundle:Category')->createQueryBuilder('p')->getQuery();
                break;
            case "field":
                $form_data = new Fieldset();
                $form = $this->createForm(FieldsetType::class, $form_data);
                $query = $em->getRepository('NavalexConfigBundle:Fieldset')->createQueryBuilder('p')->getQuery();
                break;
            case "conf":
                $form_data = new Configuration();
                $form = $this->createForm(ConfigurationType::class, $form_data);
                $query = $em->getRepository('NavalexConfigBundle:Configuration')->createQueryBuilder('p')->getQuery();
                break;
        }

        if($request->isXmlHttpRequest() && $request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($form_data);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Element ajouté.');

            return $this->redirectToRoute('navalex.config.admin.list-cat', ['mode' => $mode, 'page' => $page]);
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page,
            35
        );
        $pagination->setTemplate('@NavalexConfig/admin-pagination.html.twig');
        $pagination->setCustomParameters(['align' => 'center', 'size' => 'small']);

        return $this->render('NavalexConfigBundle:Admin:list_cat.html.twig', [
            'categoryList' => $categoryList,
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }

    public function removeCatAction(Request $request, $mode, $id)
    {
        if (!$request->isXmlHttpRequest())

        $em = $this->getDoctrine()->getManager();

        switch ($mode) {
            case "cat":
                $item = $em->getRepository('NavalexConfigBundle:Category')->find($id);
                break;
            case "field":
                $item = $em->getRepository('NavalexConfigBundle:Fieldset')->find($id);
                break;
            case "conf":
                $item = $em->getRepository('NavalexConfigBundle:Configuration')->find($id);
                break;
        }

        $em->remove($item);
        $em->flush();

        return JsonResponse::create(['valid' => true]);
    }

    public function editCatAction(Request $request, $mode, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $action = $this->generateUrl('navalex.config.admin.edit-cat', ['mode' => $mode, 'id' => $id]);

        switch ($mode) {
            case "cat":
                $item = $em->getRepository('NavalexConfigBundle:Category')->find($id);
                $form = $this->createForm(CategoryType::class, $item, [
                    'action' => $action
                ]);
                break;
            case "field":
                $item = $em->getRepository('NavalexConfigBundle:Fieldset')->find($id);
                $form = $this->createForm(FieldsetType::class, $item, [
                    'action' => $action
                ]);
                break;
            case "conf":
                $item = $em->getRepository('NavalexConfigBundle:Configuration')->find($id);
                $form = $this->createForm(ConfigurationType::class, $item, [
                    'action' => $action
                ]);
                break;
        }

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($item);
            $em->flush();

            return $this->render('NavalexConfigBundle:Admin/Sample:cat_table.html.twig', [
                'item' => $item
            ]);
        }

        return $this->render('NavalexConfigBundle:Admin/Form:category_form.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    public function getCatAction($mode, $id)
    {
        $em = $this->getDoctrine()->getManager();

        switch ($mode) {
            case "cat":
                $item = $em->getRepository('NavalexConfigBundle:Category')->find($id);
                break;
            case "field":
                $item = $em->getRepository('NavalexConfigBundle:Fieldset')->find($id);
                break;
            case "conf":
                $item = $em->getRepository('NavalexConfigBundle:Configuration')->find($id);
                break;
        }

        return $this->render('NavalexConfigBundle:Admin/Sample:cat_table.html.twig', [
            'item' => $item
        ]);
    }
}
