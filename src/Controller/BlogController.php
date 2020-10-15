<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\QuestionRepository;
use App\Repository\PatientRepository;

class BlogController extends AbstractController
{
    
    public function index(PatientRepository $patientRepository, QuestionRepository $questionRepository){
        $patients = $patientRepository->findBy([], ['created' => 'DESC']);
        $questions = $questionRepository->findBy([], ['created' => 'DESC']);
        return $this->render('blog/index.html.twig', [
            'patients' => $patients,
            'questions' => $questions,]);
    }
    
}