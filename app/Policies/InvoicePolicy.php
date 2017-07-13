<?php

namespace App\Policies;

use App\Demand\Invoice;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Invoice $invoice)
    {
        return $user->company_id == $invoice->response->company_id and $invoice->response->demand->isActive();
    }

}
