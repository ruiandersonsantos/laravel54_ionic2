<?php

$tabs = [

    [
        'title' => 'Informações',
        'link' => !isset($video)?route('admin.videos.create'):route('admin.videos.edit',['video' => $video->id])
    ],
    [
        'title' => 'Serie e Categoria',
        'link' => !isset($video)?'#':route('admin.videos.relations.create',['video' => $video->id]),
        'disabled' => !isset($video)?true:false
    ],
    [
        'title' => 'Video e Thumbmail',
        'link' => ''
    ]
];
?>

<h3>Gerenciar Vídeo</h3>
<div class="text-right">
    {!! Button::link('Lista Videos')->asLinkTo(route('admin.videos.index')) !!}
</div>
{!! Navigation::tabs($tabs) !!}

<div>
    {!! $slot !!}
</div>
