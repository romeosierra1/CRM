<?php

namespace SBCamp\CRMBundle\CRMFields;


use SBCamp\CRMBundle\Entity\LeadCustomField;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

class CreateForm
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
     * @return LeadCustomField[]
     */
    public function getUserFields(): array
    {
        return $this->userFields;
    }

    /**
     * @param LeadCustomField[] $userFields
     */
    public function setUserFields(array $userFields)
    {
        $this->userFields = $userFields;
    }


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
        foreach ($this->userFields as $userField) {
            $this->formBuilder->add($userField->getColumnName(), TextType::class);
        }
        $form = $this->formBuilder->add('save', SubmitType::class, array('label' => 'Create Lead'))
            ->getForm();

        return $form;
    }
}