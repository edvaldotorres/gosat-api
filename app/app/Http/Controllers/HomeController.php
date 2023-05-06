<?php

namespace App\Http\Controllers;

use App\Repositories\CreditOfferRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    private $creditOfferRepository;

    /**
     * This is a constructor function that initializes a CreditOfferRepository object.
     * 
     * @param CreditOfferRepository creditOfferRepository The parameter `` is an
     * instance of the `CreditOfferRepository` class, which is a repository responsible for handling
     * database operations related to credit offers. It is being injected into the constructor of a class,
     * which means that the class depends on this repository to function properly. This is an
     */
    public function __construct(CreditOfferRepository $creditOfferRepository)
    {
        $this->creditOfferRepository = $creditOfferRepository;
    }

    /**
     * The function retrieves the total number of credit offers per category and passes it to the welcome
     * view.
     * 
     * @return View The `index()` function is returning a view called `welcome` with a variable called
     * `totalOffersCategory` passed to it. The value of `totalOffersCategory` is obtained from the
     * `totalOffersCategory()` function of the `` object.
     */
    public function index(): View
    {
        $totalOffersCategory = $this->creditOfferRepository->totalOffersCategory();
        return view('welcome', compact('totalOffersCategory'));
    }
}
