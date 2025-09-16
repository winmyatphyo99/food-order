<?php
require_once APPROOT . '/repositories/ContactRepository.php';
class ContactController extends Controller {

    public function index() {
        $data = [
            'success' => '',
            'errors' => [],
            'old' => []
        ];
        $this->view('pages/contactus', $data);
    }

    public function send() {
       $oldData = [
        'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
        'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
        'subject' => isset($_POST['subject']) ? trim($_POST['subject']) : '',
        'message' => isset($_POST['message']) ? trim($_POST['message']) : '',
    ];
        $errors = [];

        // Validation
        if(empty($oldData['name'])) $errors['name'] = "Name is required.";
        if(empty($oldData['email']) || !filter_var($oldData['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = "Valid email is required.";
        if(empty($oldData['subject'])) $errors['subject'] = "Subject is required.";
        if(empty($oldData['message'])) $errors['message'] = "Message is required.";

        $data = [
            'success' => '',
            'errors' => $errors,
            'old' => $oldData
        ];

        if(empty($errors)) {
            $contact = new ContactModel();
            $contact->setName($oldData['name']);
            $contact->setEmail($oldData['email']);
            $contact->setSubject($oldData['subject']);
            $contact->setMessage($oldData['message']);
            $contact->setCreatedAt(date('Y-m-d H:i:s'));

            $repo = new ContactRepository();
            if($repo->save($contact)) {
                $data['success'] = "Your message has been sent successfully!";
                $data['old'] = [];
            } else {
                $data['errors']['general'] = "Something went wrong. Please try again.";
            }
        }

        $this->view('pages/contactus', $data);
    }
}
