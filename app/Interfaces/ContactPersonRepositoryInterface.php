<?php

namespace App\Interfaces;

use App\Models\ContactPerson;

interface ContactPersonRepositoryInterface {
    public function getContactPeople();
    public function updateContactPerson(ContactPerson $contactPerson, array $contactPersonDetails);
    public function deleteContactPerson(ContactPerson $contactPerson);
}

?>