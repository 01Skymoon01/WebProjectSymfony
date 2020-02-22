<?php


namespace FriteBundle;


use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\Event;

use FriteBundle\Entity\RDV;
use FriteBundle\Repository\RDVRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FullCalendarListener
{
    private $RDVRepository;
    private $router;

    public function __construct(

        UrlGeneratorInterface $router
    ) {

        $this->router = $router;
    }


    public function loadEvents(CalendarEvent $calendar): void
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $rdvs = $this->getDoctrine()->getRepository(RDV::class)->findAll();

        foreach ($rdvs as $rdv) {
            // this create the events with your own entity (here booking entity) to populate calendar
            $bookingEvent = new Event(
                $rdv->getDateRDV(),
                $rdv-> getIdRDV()
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setUrl('http://www.google.com');
            // $bookingEvent->setBackgroundColor($booking->getColor());
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            $bookingEvent->setUrl(
                $this->router->generate('rdv', [
                    'id' => $rdv-> getIdRDV(),
                ])
            );

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($bookingEvent);
        }
    }

}