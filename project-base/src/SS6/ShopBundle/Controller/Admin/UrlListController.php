<?php

namespace SS6\ShopBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SS6\ShopBundle\Form\UrlListNewUrlType;
use SS6\ShopBundle\Model\Domain\Domain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UrlListController extends Controller {

	/**
	 * @var \SS6\ShopBundle\Model\Domain\Domain
	 */
	private $domain;

	public function __construct(Domain $domain) {
		$this->domain = $domain;
	}

	/**
	 * @Route("/url-list/new-url-form/")
	 */
	public function newUrlFormAction() {
		$form = $this->createForm(new UrlListNewUrlType($this->domain));

		return $this->render('@SS6Shop/Admin/Form/urlListNewUrlForm.html.twig', [
			'form' => $form->createView(),
		]);
	}

}