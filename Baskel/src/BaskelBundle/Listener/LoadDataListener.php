<?php


namespace BaskelBundle\Listener;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use BaskelBundle\Entity\Event;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class LoadDataListener
{
/**
* @param CalendarEvent $calendarEvent
*
* @return FullCalendarEvent[]
*/
/**
* @var EntityManager
*/
private $em;
private $security;
public function __construct(EntityManagerInterface $em,Security $security)
{
$this->em = $em;
$this->security=$security;
}
public function loadData(CalendarEvent $calendarEvent)
{
$startDate = $calendarEvent->getStart();
$endDate = $calendarEvent->getEnd();
$filters = $calendarEvent->getFilters();

//You may want do a custom query to populate the events

$evts = $this->em->getRepository(Event::class)->findAll();
dump($evts);
foreach ($evts as $evt) {
//die("aa");
$calendarEvent->addEvent(new \AncaRebeca\FullCalendarBundle\Model\Event($evt->getNom(), $evt->getDate()));
}
}
}