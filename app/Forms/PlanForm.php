<?php

namespace CodeFlix\Forms;

use CodeFlix\Models\Plan;
use Kris\LaravelFormBuilder\Form;

class PlanForm extends Form
{
    public function buildForm()
    {
        $durations = [
            Plan::DURATION_MOTHLY => 'Mensalmente',
            Plan::DURATION_YEARLY => 'Anualmente'
        ];

        $this
            ->add('duration','select',[
                'choices' => $durations,
                'rules' => 'required|in:' . implode(',',array_keys($durations))
            ])
            ->add('name', 'text',[
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('description', 'text',[
                'label' => 'Descrição',
                'rules' => 'required|max:255'
            ])
            ->add('value', 'text',[
                'label' => 'Valor',
                'rules' => 'required|numeric'
            ]);
    }
}
