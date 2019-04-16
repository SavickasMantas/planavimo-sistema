<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Entity\UsersToSchedule;
use App\Form\ScheduleType;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Knp\Component\Pager\PaginatorInterface;


class ScheduleController extends AbstractController
{
    /**
     * @Route("/schedule", name="schedule")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();
        $result = $this->getDoctrine()->getRepository(Schedule::class)->getAllUserSchedules($user->getId());

        $schedules = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('schedule/index.html.twig', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * @Route("/schedule/create", name="schedule_create")
     * @Method({"GET", "POST"})
     */
    public function createSchedule(Request $request){
        $user = $this->getUser();
        $schedule = new Schedule();

        $form = $this->createForm(ScheduleType::class, $schedule, array(
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $schedule = $form->getData();
            $UsersToSchedule = new UsersToSchedule();
            $UsersToSchedule->setFkUser($user);
            $UsersToSchedule->setFkSchedule($schedule);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($schedule);
            $entityManager->persist($UsersToSchedule);
            $entityManager->flush();


            return $this->redirectToRoute('schedule');

        }
        return $this->render('schedule/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/schedule/detail/{schedule_id}", name="schedule_detail")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @Method({"GET", "POST"})
     */
    public function detailSchedule(Schedule $schedule = null, Request $request)
    {
        if ($schedule !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            if ($findScheduleInUser !== null){

                return $this->render('schedule/detail.html.twig', [
                    'schedule' => $schedule,
                ]);
            }
        }
        return $this->redirectToRoute('schedule');
    }

    /**
     * @Route("/schedule/edit/{schedule_id}", name="schedule_edit")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @Method({"GET", "POST"})
     */
    public function editPage(Schedule $schedule = null, Request $request)
    {
        if ($schedule !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            if ($findScheduleInUser !== null){
                $form = $this->createForm(ScheduleType::class, $schedule, array(
                    'button_label' => 'Edit',
                ));
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->flush();

                    return $this->redirectToRoute('schedule');

                }
                return $this->render('schedule/edit.html.twig', [
                    'schedule' => $schedule,
                    'form' => $form->createView()
                ]);
            }
        }
        return $this->redirectToRoute('schedule');
    }

    /**
     * @Route("/schedule/remove/{schedule_id}", name="schedule_remove")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @Method({"GET", "POST"})
     */
    public function removeAction(Schedule $schedule = null, Request $request)
    {
        if ($schedule !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            if ($findScheduleInUser !== null){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($schedule);
                $entityManager->flush();

                return $this->redirectToRoute('schedule');

            }
        }
        return $this->redirectToRoute('schedule');
    }
}
