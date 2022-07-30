<?php

namespace App\Enums\Project;


enum Status:string
{
    case WAITING_FOR_DEVELOPMENT = 'wfd';
    case IN_PROGRESS = 'inp';
    case DONE = 'd';
}

?>