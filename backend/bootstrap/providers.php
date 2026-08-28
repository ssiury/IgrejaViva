<?php

use App\Modules\Culto\Providers\CultoServiceProvider;
use App\Modules\InformacaoIgreja\Providers\InformacaoIgrejaServiceProvider;
use App\Modules\Ministerio\Providers\MinisterioServiceProvider;
use App\Modules\SolicitacaoVisita\Providers\SolicitacaoVisitaServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    CultoServiceProvider::class,
    MinisterioServiceProvider::class,
    InformacaoIgrejaServiceProvider::class,
    SolicitacaoVisitaServiceProvider::class,
];
