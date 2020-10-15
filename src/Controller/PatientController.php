<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Form\PatientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PatientRepository;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient/{id}", name="app_patient", requirements={"id"="\d+"})
     */
    public function index(Patient $patient)
    {
        return $this->render('patient/index.html.twig', [
            'patient' => $patient,
        ]);
    }
    
   /**
    * @Route("/patient/create", name="app_patient_create")
    * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
    public function createPatient(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $patient->setUser($this->getUser());
            $patient->setCreated(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            return $this->redirectToRoute("app_patient_display");
        }

        return $this->render('patient/createpatient.html.twig', [
            'patientForm' => $form->createView()
        ]);
}
   /**
    * @Route("/patient/display", name="app_patient_display")
    * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
public function displayPatient(PatientRepository $patientRepository){
    $patients = $patientRepository->findBy([], ['created' => 'DESC']);
    return $this->render('patient/displaypatient.html.twig', [
        'patients' => $patients,]);
}

}
