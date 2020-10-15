<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calendar;
use App\Form\AddCalendarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CalendarRepository;

class FullCalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="app_full_calendar")
     */
    public function index(CalendarRepository $calendar)
    {
        $events = $calendar->findAll();
        //dd($events);
        $taches = [];

        foreach($events as $event){
            $taches[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'fin' => $event->getFin()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllDay(),
            ];
        }

        $data = json_encode($taches);

        return $this->render('full_calendar/index.html.twig', compact('data'));
    }

   /**
    * @Route("/calendar/create", name="app_calendar_create")
    * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
    public function createEvent(Request $request)
    {
        $calendar = new Calendar();
        $form = $this->createForm(AddCalendarType::class, $calendar);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $calendar->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();
            return $this->redirectToRoute("app_full_calendar");
        }

        return $this->render('full_calendar/addevent.html.twig', [
            'calendarForm' => $form->createView()
        ]);
}
}
