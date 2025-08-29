<?php
class UserController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();

        // Admin-only routes
        $adminOnly = ['index', 'delete'];
        $currentMethod = $this->currentMethod ?? '';
        if (in_array($currentMethod, $adminOnly)) {
            if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 1) {
                setMessage('error', 'You are not authorized to access this page.');
                redirect('pages/index');
            }
        }
    }

    /**
     * Admin only - List all users
     */
    public function index()
    {
        $users = $this->userRepository->getAllUsersWithOrderCount();
        $this->view('admin/userprofile/index', ['users' => $users]);
    }

    /**
     * Admin only - Delete a user
     */
    public function delete($id)
    {
        $this->userRepository->delete($id);
        setMessage('success', 'User deleted successfully.');
        redirect('user/index');
    }

    /**
     * User - Edit own profile
     */
    public function editProfile()
    {

        //  echo "<pre>";
        // print_r($_SESSION);exit;
        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone_number' => trim($_POST['phone_number'])
            ];

            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $filename = time() . '_' . basename($_FILES['profile_image']['name']);
                $target = APPROOT . '/uploads/profile/' . $filename;
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
                    $data['profile_image'] = $filename;

                    // Update session with new image name
                    $_SESSION['profile_image'] = $filename;
                }
            }



            $this->userRepository->updateUserProfile($userId, $data);
            setMessage('success', 'Profile updated successfully!');
            redirect('Pages/home');
        }

        // send full user row to view
        $this->view('user/userprofile/edit', ['user' => $user]);
    }

    /**
     * User - Change own password
     */
    public function changePassword()
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $current = trim($_POST['current_password']);
            $new = trim($_POST['new_password']);
            $confirm = trim($_POST['confirm_password']);

            if (!password_verify($current, $user['password'])) {
                setMessage('error', 'Current password is incorrect!');
                redirect('user/changePassword');
            } elseif ($new !== $confirm) {
                setMessage('error', 'New password and confirm password do not match!');
                redirect('user/changePassword');
            } else {
                $this->userRepository->updatePassword($userId, $new);
                setMessage('success', 'Password updated successfully!');
                redirect('user/changePassword');
            }
        }

        $this->view('user/userprofile/changePassword');
    }


}
