<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 12.02.2019
 * Time: 13:54
 */

namespace App\Controller;


use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminUtilityController
 * @IsGranted("ROLE_ADMIN_ARTICLE")
 */
class AdminUtilityController extends AbstractController
{
    /**
     * @Route("/admin/utility/users", methods="GET", name="admin_utility_users")
     */
    public function getUserApi(UserRepository $userRepository, Request $request)
    {

        $users = $userRepository->findAllMatching($request->query->get('query'));
        return $this->json([
            'users' => $users
        ], 200, [], ['groups' => ['main']]);
    }
}