<?php

namespace Shopsys\ShopBundle\Form\Admin\Transport;

use Shopsys\ShopBundle\Form\FormType;
use Shopsys\ShopBundle\Model\Transport\TransportEditData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;

class TransportEditFormType extends AbstractType {

	/**
	 * @var \Shopsys\ShopBundle\Form\Admin\Transport\TransportFormTypeFactory
	 */
	private $transportFormTypeFactory;

	/**
	 * @var \Shopsys\ShopBundle\Model\Pricing\Currency\Currency[]
	 */
	private $currencies;

	/**
	 * @param \Shopsys\ShopBundle\Form\Admin\Transport\TransportFormTypeFactory $transportFormTypeFactory
	 * @param \Shopsys\ShopBundle\Model\Pricing\Currency\Currency[] $currencies
	 */
	public function __construct(TransportFormTypeFactory $transportFormTypeFactory, array $currencies) {
		$this->transportFormTypeFactory = $transportFormTypeFactory;
		$this->currencies = $currencies;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'transport_edit_form';
	}

	/**
	 * @param \Symfony\Component\Form\FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('transportData', $this->transportFormTypeFactory->create())
			->add($this->getPricesBuilder($builder))
			->add('save', FormType::SUBMIT);
	}

	/**
	 * @param \Symfony\Component\Form\FormBuilderInterface $builder
	 * @return \Symfony\Component\Form\FormBuilderInterface
	 */
	private function getPricesBuilder(FormBuilderInterface $builder) {
		$pricesBuilder = $builder->create('prices', null, [
			'compound' => true,
		]);
		foreach ($this->currencies as $currency) {
			$pricesBuilder
				->add($currency->getId(), FormType::MONEY, [
					'currency' => false,
					'precision' => 6,
					'required' => true,
					'invalid_message' => 'Please enter price in correct format (positive number with decimal separator)',
					'constraints' => [
						new Constraints\NotBlank(['message' => 'Please enter price']),
						new Constraints\GreaterThanOrEqual([
							'value' => 0,
							'message' => 'Price must be greater or equal to {{ compared_value }}',
						]),

					],
				]);
		}

		return $pricesBuilder;
	}

	/**
	 * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults([
			'data_class' => TransportEditData::class,
			'attr' => ['novalidate' => 'novalidate'],
		]);
	}
}