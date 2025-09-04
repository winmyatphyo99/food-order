<?php
class Core
{
  
    protected $currentController = "Pages";
    protected $currentMethod = "home";
    protected $params = [];



    public function __construct()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $url = $this->getURL();


        if (isset($url[0])) {

            if (strtolower($url[0]) === 'admin' && isset($url[1]) && file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
                $this->currentController = ucwords($url[0]) . 'Controller'; // AdminController
                unset($url[0]);
            } elseif (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }
        }

        require_once('../app/controllers/' . $this->currentController . '.php');
        $this->currentController = new $this->currentController;


        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }


        $this->params = $url ? array_values($url) : [];


        $this->runMiddleware();

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
    public function getURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            // FILTER_SANITIZE_URL filter removes all illegal URL characters from a string.
            // This filter allows all letters, digits and $-_.+!*'(),{}|\\^~[]`"><#%;/?:@&=
            $url = filter_var($url, FILTER_SANITIZE_URL); //remove illegal
            $url = explode('/', $url); //Break a string into an array
            return $url;
        }
    }

    private function runMiddleware()
{
    $guestRoutes = [
        'Auth@login',
        'Auth@register',
        'Auth@verify',
    ];

    $authRoutes = [
       
        'OrderController@orderHistory',
        'InvoiceController@userInvoice',
        'UserController@editProfile',
        'UserController@changePassword',
        'CartController@viewCart',
        'CartController@updateCart',
        'CartController@removeFromCart',
        'CustomerController@orderHistory',
        'CartController@orderConfirmation',
    ];

    
    $adminRoutes = [
        'AdminController@dashboard',
        'AdminController@pending',
        'AdminController@confirmOrder',
        'ProductController@index',
        'InvoiceController@adminInvoice',
        'InvoiceController@index',
        'UserController@index',
        'UserController@delete',
        'AdminController@profile',
        'AdminController@editProfile',
        'AdminController@changePassword'
    ];

    $controllerName = is_object($this->currentController) ? get_class($this->currentController) : $this->currentController;
    $routeKey = $controllerName . '@' . $this->currentMethod;

    // Admin Middleware (Highest priority)
    if (in_array($routeKey, $adminRoutes)) {
        require_once APPROOT . '/middleware/AdminMiddleware.php';
        $middleware = new AdminMiddleware();
        $middleware->handle();
        return;
    }
    
    // Auth Middleware (Second priority)
    if (in_array($routeKey, $authRoutes)) {
        require_once APPROOT . '/middleware/AuthMiddleware.php';
        $middleware = new AuthMiddleware();
        $middleware->handle();
        return;
    }
    
    // Guest Middleware (Third and final priority for specific routes)
    if (in_array($routeKey, $guestRoutes)) {
        require_once APPROOT . '/middleware/GuestMiddleware.php';
        $middleware = new GuestMiddleware();
        $middleware->handle();
        return;
    }
    
    // If the route key is not found in any of the above arrays,
    // the code will continue, and the route is considered public by default.
}
}
