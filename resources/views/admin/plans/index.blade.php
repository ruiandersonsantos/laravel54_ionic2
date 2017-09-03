@extends('layouts.admin')

@section('content')
    <div class="container">

        <div class="row">
            <h3>Listagem de Planos</h3>
            {!! Button::primary('Novo Plano')->asLinkTo(route('admin.plans.create')) !!}
        </div>

        <div class="row">
           {!!
                Table::withContents($plans->items())->striped()
                ->callback('Ações', function($field, $plan){
                    $linkEdit = route('admin.plans.edit',['plan' => $plan->id]);
                    $linkShow = route('admin.plans.show',['plan' => $plan->id]);
                    return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit).'|'.
                    Button::link(Icon::create('remove'))->asLinkTo($linkShow);
                })
           !!}
        </div>

        {!! $plans->links() !!}
    </div>
@endsection
