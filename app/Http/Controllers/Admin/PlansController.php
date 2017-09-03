<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Models\Plan;

use CodeFlix\Forms\PlanForm;
use CodeFlix\Repositories\PlanRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class PlansController extends Controller
{
    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $plans =  $this->repository->paginate();

        return view('admin.plans.index',compact('plans'));
    }

    public function create()
    {
        $form = \FormBuilder::create(PlanForm::class,[
            'url' => route('admin.plans.store'),
            'method' => 'POST'
        ]);

        return view('admin.plans.create',compact('form'));
    }

    public function store(Request $request)
    {
        $form = \FormBuilder::create(PlanForm::class);

        if(!$form->isValid()){

            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->create($data);
        $request->session()->flash('message','Plano '.$data['name']. ' criado com sucesso.');
        return redirect()->route('admin.plans.index');
    }

    public function show(Plan $plan)
    {
        return view('admin.plans.show',compact('plan'));
    }


    public function edit(Plan $plan)
    {
        $form = \FormBuilder::create(PlanForm::class,[
            'url' => route('admin.plans.update', ['user' => $plan->id ]),
            'method' => 'PUT',
            'model' => $plan
        ]);

        return view('admin.plans.edit',compact('form'));
    }


    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(PlanForm::class,[
            'data'=> ['id' => $id ]
        ]);

        if(!$form->isValid()){

            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->update($data, $id);

        $request->session()->flash('message','Plano atualizado com sucesso.');
        return redirect()->route('admin.plans.index');
    }

    public function destroy(Request $request,$id)
    {
        $this->repository->delete($id);
        $request->session()->flash('message','Plano excluido com sucesso.');
        return redirect()->route('admin.plans.index');
    }
}
