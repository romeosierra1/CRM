<?php

namespace SBCamp\CRMBundle\CRMFields;

use SBCamp\CRMBundle\Entity\LeadCustomField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

class CreateSearchForm
{
    /**
     * @var LeadCustomField[]
     */
    private $userFields;

    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * CreateForm constructor.
     * @param array $userFields
     * @param FormBuilderInterface $formBuilder
     */
    public function __construct(array $userFields, FormBuilderInterface $formBuilder)
    {
        $this->userFields = $userFields;
        $this->formBuilder = $formBuilder;
    }

    /**
     * @return FormInterface
     */
    public function create()
    {
        $this->formBuilder->add('term', TextType::class);

        foreach ($this->userFields as $userField) {
            if ($userField->getDataType() == "text") {
                $this->formBuilder->add($userField->getColumnName(), CheckboxType::class, array("value" => $userField->getColumnName(), "required" => false));
            }

        }

        foreach ($this->userFields as $userField) {
            $this->formBuilder->add($userField->getColumnName(), CheckboxType::class, array("value" => $userField->getColumnName(), "required" => false));
            if ($userField->getDataType() == "date") {
                $this->formBuilder->add($userField->getColumnName() . "_gte", DateType::class, array("required" => false));
                $this->formBuilder->add($userField->getColumnName() . "_lte", DateType::class, array("required" => false));
            } elseif ($userField->getDataType() == "double") {
                $this->formBuilder->add($userField->getColumnName() . "_gte", NumberType::class, array("required" => false));
                $this->formBuilder->add($userField->getColumnName() . "_lte", NumberType::class, array("required" => false));
            }
        }

        $form = $this->formBuilder->add('save', SubmitType::class, array('label' => 'Search Lead'))
            ->getForm();

        return $form;
    }
}