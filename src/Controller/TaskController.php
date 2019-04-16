<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\UsersToSchedule;
use App\Repository\UsersToScheduleRepository;
use App\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/schedule/schedule_id={schedule_id}", name="task_management")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     */
    public function index(Schedule $schedule = null, Request $request)
    {
        if ($schedule !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            if ($findScheduleInUser !== null){
                $tasks = $schedule->getTasks();
                return $this->render('task/index.html.twig', [
                    'tasks' => $tasks,
                    'schedule_id' => $schedule->getId()
                ]);
            }
        }
        return $this->redirectToRoute('schedule');
    }

    /**
     * @Route("/schedule/schedule_id={schedule_id}/create", name="task_create")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @Method({"GET", "POST"})
     */
    public function createAction(Schedule $schedule = null, Request $request)
    {
        if ($schedule !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            if ($findScheduleInUser !== null){
                $task = new Task();

                $form = $this->createForm(TaskType::class, $task, array(
                ));
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){
                    $task = $form->getData();
                    $task->setFkSchedule($schedule);


                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($task);
                    $entityManager->flush();

                    $scheduleId = $schedule->getId();
                    return new RedirectResponse("/schedule/schedule_id=$scheduleId");

                }
                return $this->render('task/create.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }
        return $this->redirectToRoute('schedule');
    }

    /**
     * @Route("/schedule/schedule_id={schedule_id}/detail/{task_id}", name="task_detail")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @ParamConverter("task", class="App\Entity\Task", options={"id" = "task_id"})
     * @Method({"GET", "POST"})
     */
    public function detailAction(Schedule $schedule = null, Task $task = null, Request $request)
    {
        if ($schedule !== null && $task !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            $findTask = $this->getDoctrine()->getRepository(Task::class)->findOneBy(array(
                'id' => $task->getId(),
                'fkSchedule' => $scheduleId
            ));
            if ($findScheduleInUser !== null && $findTask !== null){

                return $this->render('task/detail.html.twig', [
                    'task' => $task,
                    'schedule_id' => $schedule->getId()
                ]);
            }
        }
        return $this->redirectToRoute('schedule');
    }

    /**
     * @Route("/schedule/schedule_id={schedule_id}/edit/{task_id}", name="task_edit")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @ParamConverter("task", class="App\Entity\Task", options={"id" = "task_id"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Schedule $schedule = null, Task $task = null, Request $request)
    {
        if ($schedule !== null && $task !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            $findTask = $this->getDoctrine()->getRepository(Task::class)->findOneBy(array(
                'id' => $task->getId(),
                'fkSchedule' => $scheduleId
            ));
            if ($findScheduleInUser !== null && $findTask !== null){
                $form = $this->createForm(TaskType::class, $task, array(
                    'button_label' => 'Edit',
                ));
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->flush();

                    $scheduleId = $schedule->getId();
                    return new RedirectResponse("/schedule/schedule_id=$scheduleId");

                }
                return $this->render('task/edit.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }
        return $this->redirectToRoute('schedule');
    }

    /**
     * @Route("/schedule/schedule_id={schedule_id}/remove/{task_id}", name="task_remove")
     * @ParamConverter("schedule", class="App\Entity\Schedule", options={"id" = "schedule_id"})
     * @ParamConverter("task", class="App\Entity\Task", options={"id" = "task_id"})
     * @Method({"GET", "POST"})
     */
    public function removeAction(Schedule $schedule = null, Task $task = null, Request $request)
    {
        if ($schedule !== null && $task !== null){
            $scheduleId = $schedule->getId();
            $userId = $this->getUser()->getId();
            $findScheduleInUser = $this->getDoctrine()->getRepository(UsersToSchedule::class)
                ->getScheduleByUser($scheduleId, $userId);
            $findTask = $this->getDoctrine()->getRepository(Task::class)->findOneBy(array(
                'id' => $task->getId(),
                'fkSchedule' => $scheduleId
            ));
            if ($findScheduleInUser !== null && $findTask !== null){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($task);
                $entityManager->flush();

                return new RedirectResponse("/schedule/schedule_id=$scheduleId");

            }
        }
        return $this->redirectToRoute('schedule');
    }
}
