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
        $bookings = $repository->findByUser($this->getUser(), ['date' => 'ASC']);

        return $this->render('booking/bookings.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * @Route("/newBooking", name="newBooking")
     */
    public function newBookingAction(Request $request): Response
    {
        return $this->generateForm($request, new Booking());
    }

    /**
     * @Route("/updateBooking/{id}", name="updateBooking")
     */
    public function updateBookingAction(Request $request, $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $booking = $repository->find($id);

        return $this->generateForm($request, $booking);
    }

    public function generateForm(Request $request, Booking $booking)
    {
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

    /**
     * @Route("/deleteBooking/{id}", name="deleteBooking")
     */
    public function deleteBookingAction($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $booking = $repository->find($id);

        if (isset($booking)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bookings');
    }
}
