<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace PrestaShopBundle\Form\Admin\Sell\Product;

use PrestaShop\PrestaShop\Adapter\Carrier\CarrierDataProvider;
use PrestaShopBundle\Form\Admin\Type\TranslateType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Form type containing product shipping information
 */
class ShippingType extends TranslatorAwareType
{
    /**
     * @var string
     */
    private $currencyIsoCode;

    /**
     * @var CarrierDataProvider
     */
    private $carrierDataProvider;

    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        string $currencyIsoCode,
        CarrierDataProvider $carrierDataProvider
    ) {
        parent::__construct($translator, $locales);
        $this->currencyIsoCode = $currencyIsoCode;
        $this->carrierDataProvider = $carrierDataProvider;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('width', NumberType::class, [
                'required' => false,
                'label' => $this->trans('Width', 'Admin.Catalog.Feature'),
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'numeric']),
                ],
            ])->add('height', NumberType::class, [
                'required' => false,
                'label' => $this->trans('Height', 'Admin.Catalog.Feature'),
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'numeric']),
                ],
            ])->add('depth', NumberType::class, [
                'required' => false,
                'label' => $this->trans('Depth', 'Admin.Catalog.Feature'),
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'numeric']),
                ],
            ])->add('weight', NumberType::class, [
                'required' => false,
                'label' => $this->trans('Weight', 'Admin.Catalog.Feature'),
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'numeric']),
                ],
            ])->add('additional_delivery_times', ChoiceType::class, [
                'choices' => [
                    $this->trans('None', 'Admin.Catalog.Feature') => 0,
                    $this->trans('Default delivery time', 'Admin.Catalog.Feature') => 1,
                    $this->trans('Specific delivery time to this product', 'Admin.Catalog.Feature') => 2,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
                'preferred_choices' => ['default'],
                'label' => $this->trans('Delivery Time', 'Admin.Catalog.Feature'),
            ])->add('delivery_in_stock', TranslateType::class, [
                'type' => TextType::class,
                'options' => [
                    'attr' => [
                        'placeholder' => $this->trans('Delivered within 3-4 days', 'Admin.Catalog.Feature'),
                    ],
                ],
                'locales' => $this->locales,
                'hideTabs' => true,
                'required' => false,
                'label' => $this->trans('Delivery time of in-stock products:', 'Admin.Catalog.Feature'),
            ])->add('delivery_out_stock', TranslateType::class, [
                'type' => TextType::class,
                'options' => [
                    'attr' => [
                        'placeholder' => $this->trans('Delivered within 5-7 days', 'Admin.Catalog.Feature'),
                    ],
                ],
                'locales' => $this->locales,
                'hideTabs' => true,
                'required' => false,
                'label' => $this->trans(
                    'Delivery time of out-of-stock products with allowed orders:',
                    'Admin.Catalog.Feature'
                ),
            ])->add('additional_shipping_cost', MoneyType::class, [
                'required' => false,
                'label' => $this->trans('Shipping fees', 'Admin.Catalog.Feature'),
                'currency' => $this->currencyIsoCode,
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'float']),
                ],
            ])->add('selectedCarriers', ChoiceType::class, [
                'choices' => $this->getCarrierChoices(),
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'label' => $this->trans('Available carriers', 'Admin.Catalog.Feature'),
            ])
        ;
    }

    //@todo; move to separate choices provider. Its copied from ProductShipping.php can be optimized
    private function getCarrierChoices(): array
    {
        $carriers = $this->carrierDataProvider->getCarriers(
            $this->locales[0]['id_lang'],
            false,
            false,
            false,
            null,
            $this->carrierDataProvider->getAllCarriersConstant()
        );
        $carrierChoices = [];
        foreach ($carriers as $carrier) {
            $choiceId = $carrier['id_carrier'] . ' - ' . $carrier['name'];
            if ($carrier['name']) {
                $choiceId .= ' (' . $carrier['delay'] . ')';
            }

            $carrierChoices[$choiceId] = $carrier['id_reference'];
        }

        return $carrierChoices;
    }
}
