<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactPerson\UpdateRequest;
use App\Interfaces\ContactPersonRepositoryInterface;
use App\Models\ContactPerson;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
{
    private ContactPersonRepositoryInterface $contactPersonRepository;

    public function __construct(ContactPersonRepositoryInterface $contactPersonRepository)
    {
        $this->contactPersonRepository = $contactPersonRepository;
    }

    public function delete(ContactPerson $contactPerson)
    {
        $this->contactPersonRepository->deleteContactPerson($contactPerson);
        return redirect()->back();
    }

    public function update(ContactPerson $contactPerson, UpdateRequest $request)
    {
        $this->contactPersonRepository->updateContactPerson($contactPerson, $request->all());
        return redirect()->back();
    }
}
