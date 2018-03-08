<?php

namespace RPSHRMS\Http\Controllers;

use RPSHRMS\Services\GeneralService;

abstract class AbstractController extends Controller
{
    /**
     * @var string
     */
    protected $viewDir = '';

    /**
     * @var GeneralService
     */
    protected $generalService;

    /**
     * AbstractController constructor.
     *
     * @param string $view
     */
    public function __construct($view = '')
    {
        $this->generalService = new GeneralService();
        if ($view) {
            $this->viewDir = $view;
            view()->share('activeMenu' . ucfirst($view), true);
        }
    }

    /**
     * @param string $view
     * @return string
     */
    public function getView($view) {
        return $this->viewDir ? $this->viewDir . '.' . $view : $view;
    }
}
