<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class ManagementBookingController extends Controller
{
    /**
     * @Route("/", name="bookings")
     */
    public function bookingsAction(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $bookings = $repository->findAll();

        return $this->render('booking/bookings.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * @Route("/newBooking", name="newBooking")
     */
    public function newBookingAction(Request $request): Response
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $booking->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('bookings');
        }

        return $this->render('booking/new_booking.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
