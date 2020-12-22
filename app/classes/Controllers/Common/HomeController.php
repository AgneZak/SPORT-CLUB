<?php

namespace App\Controllers\Common;

use App\Views\BasePage;
use Core\View;

class HomeController
{
    protected $page;

    /**
     * Controller constructor.
     *
     * We can write logic common for all
     * other methods
     *
     * For example, create $page object,
     * set it's header/navigation
     * or check if user has a proper role
     *
     * Goal is to prepare $page
     */
    public function __construct()
    {
        $this->page = new BasePage([
            'title' => 'Sport Club'
        ]);
    }

    /**
     * Home Controller Index
     *
     * @return string|null
     * @throws \Exception
     */
    public function index(): ?string
    {
        $content = (new View([
            'title' => 'Welcome to our Sports Club',
            'img-class' => 'hero-image',
            'services' => [
                'Group workouts' => [
                    'description' => "Created and developed by the industry's best minds and taught
                     by talented instructors who test your limits and inspire results.",
                    'img-class' => 'workouts'
                ],
                'Lounge area' => [
                    'description' => "There’s a little corner of peace and indulgence on the first floor. 
                    To get you ready after your workout there’s plenty of space for relaxing.",
                    'img-class' => 'lounge'
                ],
                'Gym' => [
                    'description' => "You and your dedicated personal trainer will create a plan that's tailored to 
                    your goals—and together, you'll work to unlock the results you want.",
                    'img-class' => 'gym'
                ]

            ],
        ]))->render(ROOT . '/app/templates/content/index.tpl.php');

        $this->page->setContent($content);

        return $this->page->render();
    }
}

