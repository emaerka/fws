<?php

namespace App\Repositories;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Models\ContactPerson;

class ContactPersonRepository implements ContactPersonRepositoryInterface {
    
    public function getContactPeople()
    {
        return ContactPerson::orderBy('name','asc')->get();
    }

    public function updateContactPerson(ContactPerson $contactPerson, array $contactPersonDetails)
    {      
        $contactPerson->update($contactPersonDetails);
    }

    public function deleteContactPerson(ContactPerson $contactPerson)
    {
        $contactPerson->delete();
    }
}
