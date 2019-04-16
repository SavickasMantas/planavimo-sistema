<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Entity\Task;
use Doctrine\Common\Collections\ArrayCollection;
use Google_Client;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class CalendarController extends AbstractController
{

    /**
     * @Route("/calendar", name="calendar")
     */
    public function index()
    {

        $user = $this->getUser();
        $schedules = $this->getDoctrine()->getRepository(Schedule::class)->getAllUserSchedules($user->getId());
        $tasksArray = new ArrayCollection();
        foreach ($schedules as $schedule){
            $tempArray = $this->getDoctrine()->getRepository(Task::class)->findBy(array(
               'fkSchedule' => $schedule['id']
            ));
            if (sizeof($tempArray) > 0){
                foreach ($tempArray as $temp){
                    $tasksArray->add($temp);
                }
            }
        }
        return $this->render('calendar/index.html.twig', [
            'schedules' => $schedules,
            'tasks' => $tasksArray
        ]);
    }
}
