<?php



session_start();

use controllers\logincontroller;
use controllers\Logoutcontroller;
use controllers\registercontroller;
use controllers\admincontroller;
use controllers\Dancecontroller;
use controllers\Jazzcontroller;
use controllers\Restaurantcontroller;
use controllers\Historycontroller;
use controllers\accountcontroller;
use controllers\Navigationcontroller;
use controllers\overview;
use controllers\Templatecontroller;
use controllers\yummycontroller;
use controllers\Pagecontroller;
use controllers\Myprogramcontroller;
use controllers\orderoverviewcontroller;
use controllers\EmployeeController;
use controllers\resetpasswordcontroller;

require_once __DIR__ . '/../controllers/overview.php';
require_once __DIR__ . '/../controllers/registercontroller.php';
require_once __DIR__ . '/../controllers/logincontroller.php';
require_once __DIR__ . '/../controllers/logoutcontroller.php';
require_once __DIR__ . '/../controllers/admincontroller.php';
require_once __DIR__ . '/../controllers/accountcontroller.php';
require_once __DIR__ . '/../controllers/restaurantcontroller.php';
require_once __DIR__ . '/../controllers/historycontroller.php';
require_once __DIR__ . '/../controllers/dancecontroller.php';
require_once __DIR__ . '/../controllers/jazzcontroller.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';
require_once __DIR__ . '/../controllers/templatecontroller.php';
require_once __DIR__ . '/../controllers/yummycontroller.php';
require_once __DIR__ . '/../controllers/myprogramcontroller.php';
require_once __DIR__ . '/../controllers/resetpasswordcontroller.php';
require_once __DIR__ . '/../controllers/orderoverviewcontroller.php';
require_once __DIR__ . '/../controllers/employeecontroller.php';


$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

//Please do not touch this
$editPageID = null;
$sectionEdit = null;
$token = null;
$dancePageID = null;
$queryString = parse_url($request, PHP_URL_QUERY);
$queryParams = [];
if ($queryString !== null) {
    parse_str($queryString, $queryParams);
}
$pageID = htmlspecialchars($queryParams["pageid"] ?? '');
$eventID = null;
if (strpos($request, '/manage-event-details/') === 0) {
    $eventID = htmlspecialchars($queryParams["id"] ?? '');
}
if (strpos($request, '/edit-content/') === 0) {
    $editPageID = htmlspecialchars($queryParams['id'] ?? '');
}
if (strpos($request, '/sectionEdit/') === 0) {
    $sectionEdit = htmlspecialchars($queryParams['section_id'] ?? '');
}
if (strpos($request, '/new-passwords/') === 0) {
    $token = htmlspecialchars($queryParams["token"] ?? '');
}
if (strpos($request, '/dance/') === 0) {
    $dancePageID = htmlspecialchars($queryParams["artist"] ?? '');
}

//Please do not touch this
if ($request === '/') {
    $pageID = PAGE_ID_HOME;
}
function respondWith404()
{
    http_response_code(404);
    $navigation = new Navigationcontroller();
    $pagetitle= "404 Page - HAARLEM FESTIVALS";
    $navigation->displayHeader($pagetitle);
    require __DIR__ . '/../views/404.php';
    exit;
}

if ($pageID || $eventID || $editPageID || $sectionEdit || $token || $dancePageID) {
    //this has to do with the editing of event details
    if ($eventID) {
        switch ($eventID) {
            case EVENT_ID_DANCE:
                if ($_SESSION['role'] === 'admin') {
                    $controller = new Dancecontroller();
                    if ($method === 'GET') {
                        $controller->editEventDetails();
                    }
                } else {
                    respondWith404();
                }
                break;
            case EVENT_ID_JAZZ:
                if ($_SESSION['role'] === 'admin') {
                    $controller = new Jazzcontroller();
                    if ($method === 'GET') {
                        $controller->showEventDetails();
                    }
                } else {
                    respondWith404();
                }
                break;
            case $eventID > EVENT_ID_HISTORY:
                if ($_SESSION['role'] === 'admin') {
                    $controller = new Restaurantcontroller();
                    if ($method === 'GET') {
                        $controller->editEventDetails($eventID);
                    }
                } else {
                    respondWith404();
                }
                break;
            case EVENT_ID_HISTORY:
                if ($_SESSION['role'] === 'admin') {
                    $controller = new Historycontroller();
                    if ($method === 'GET') {
                        $controller->showeditEventDetails();
                    }
                } else {
                    respondWith404();
                }
                break;
            default:
                $controller = new TemplateController();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;

        }
        exit;
    } elseif ($pageID) {
        //this has to with our own pages
        switch ($pageID) {
            case PAGE_ID_HOME:
                $controller = new overview();
                $controller->show();
                break;
            case PAGE_ID_HISTORY:
                $controller = new Historycontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case PAGE_ID_DANCE:
                $controller = new Dancecontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case PAGE_ID_JAZZ:
                $controller = new Jazzcontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case PAGE_ID_YUMMY:
                $controller = new yummycontroller();
                if ($method === 'GET') {
                    $controller->showYummyOverview();
                }
                break;
            default;
                $controller = new TemplateController();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
        }
        exit;
    } elseif ($editPageID) {
        //this has to with editing pages overview
        switch ($editPageID) {
            default;
                if ($_SESSION['role'] === 'admin') {
                    $controller = new Pagecontroller;
                    if ($method === 'GET') {
                        $controller->editContent();
                    } else if ($method === 'POST') {
                        $controller->deleteSection();
                    }
                } else {
                    respondWith404();
                }
                break;
        }
        exit;
    } elseif ($sectionEdit) {
        //this has to with editing section content
        switch ($sectionEdit) {
            default;
                if ($_SESSION['role'] === 'admin') {
                    $controller = new Pagecontroller;
                    if ($method === 'GET') {
                        $controller->editSectionContent();
                    } else if ($method === 'POST') {
                        $controller->updateContent();
                    }
                } else {
                    respondWith404();
                }
                break;
        }
        exit;
    } elseif ($token) {
        switch ($token) {
            default;
                $controller = new resetpasswordcontroller();
                if ($method === 'GET' && $token !== null) {
                    $controller->showNewPasswordForm();
                }
                break;
        }
        exit;
    } elseif ($dancePageID) {
        switch ($dancePageID) {
            default;
                $controller = new Dancecontroller();
                if ($method === 'GET') {
                    $controller->showArtist($dancePageID);
                }
                break;
        }
        exit;
    }
}

// if (strpos($request, '/share-cart/') === 0) {
//     $encodedCart = htmlspecialchars($queryParams["cart"] ?? '');
//     $hash = htmlspecialchars($queryParams["hash"] ?? '');

//     $controller = new Myprogramcontroller();
//     if ($method === 'GET' && $encodedCart !== null && $hash !== null) {
//         $controller->showSharedCart($encodedCart, $hash);
//     }
//     exit;
// }


if (preg_match("/^\/restaurant\/details\/(\d+)$/", $request, $matches)) {
    $restaurantId = $matches[1]; // This captures the numeric ID from the URL.
    $controller = new yummycontroller();
    if ($method === 'GET') {
        $controller->showChoseResturant($restaurantId);
    }
    exit;
}
//Add routes for actions or admin routes that do not have to do with displaying detail pages or overview pages for your individual events
switch ($request) {
    case '/login':
        $controller = new logincontroller();
        if ($method === 'GET') {
            $controller->show();
        } elseif ($method === 'POST') {
            $controller->loginAction();
        }
        break;

    case '/reset-password':
        $controller = new resetpasswordcontroller();
        if ($method === 'GET') {
            $controller->showResetPasswordForm();
        } elseif ($method === 'POST') {
            $controller->resetpasswordAction();
        }
        break;

    case '/new-passwords':
        $controller = new resetpasswordcontroller();
        if ($method === 'GET') {
            $controller->showNewPasswordForm();
        } else if ($method === 'POST') {
            $controller->updatePasswordAction();
        }
        break;

    case '/success-reset-password':
        $controller = new resetpasswordcontroller();
        if ($method === 'GET') {
            $controller->successfulNewPassword();
        }
        break;
    case '/register':
        $controller = new registercontroller();
        if ($method === 'GET') {
            $controller->show();
        } elseif ($method === 'POST') {
            $controller->registerAction();
        }
        break;
    case '/logout':
        $logoutController = new Logoutcontroller();
        $logoutController->logout();
        break;
    case '/dance/addNewEvent':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->addNewEvent();
        } else {
            respondWith404();
        }
        break;
    case '/dance/updateEvent':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->updateEvent();
        } else {
            respondWith404();
        }
        break;
    case '/dance/addNewArtist':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->addNewArtist();
        } else {
            respondWith404();
        }
        break;
    case '/dance/updateArtist':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->updateArtist();
        } else {
            respondWith404();
        }
        break;
    case '/dance/deleteArtist':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->deleteArtist();
        } else {
            respondWith404();
        }
        break;
    case '/dance/deleteEvent':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->deleteEvent();
        } else {
            respondWith404();
        }
        break;
    case '/dance/addNewVenue':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->addVenue();
        } else {
            respondWith404();
        }
        break;
    case '/dance/updateVenue':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->updateVenue();
        } else {
            respondWith404();
        }
        break;
    case '/dance/deleteVenue':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Dancecontroller();
            $controller->deleteVenue();
        } else {
            respondWith404();
        }
        break;
    case '/admin/dashboard':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->show();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/manage-users':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->manageUsers();

            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/delete-user':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'POST' && isset($_POST['user_id'])) {
                $controller->deleteUsers();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/filter-users':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->filterUsers();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/sort-users':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->sortUsers();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/fetch-all-users':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->getAllUsers();
            }
        } else {
            respondWith404();
        }
        break;
    case '/account':
        $controller = new accountcontroller();
        if ($method === 'GET') {
            $controller->show();
        } else if ($method === 'POST') {
            $controller->handlingPost();
        }
        break;
    case '/admin/add-user':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->addUsers();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/edit-user':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'POST') {
                $controller->editUsers();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/managefestival':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->manageFestivals();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/page-management/editfestival':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->editFestivals();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/orders':
        if ($_SESSION['role'] === 'admin') {
            $controller = new admincontroller();
            if ($method === 'GET') {
                $controller->manageOrders();
            }
        } else {
            respondWith404();
        }
        break;
    case '/editDetailsHistory/addNewTimeSlot':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Historycontroller();
            if ($method === 'POST') {
                $controller->addNewTimeSlot();
            }
        } else {
            respondWith404();
        }
        break;
    case '/editDetailsHistory/editEventDetails':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Historycontroller();
            if ($method === 'POST') {
                $controller->editEventDetails();
            }
        } else {
            respondWith404();
        }
        break;
    case '/editDetailsHistory/deleteTimeSlot':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Historycontroller();
            if ($method === 'POST') {
                $controller->removeTimeslot();
            }
        } else {
            respondWith404();
        }
        break;
    case '/modify-navigation/edit-navigation':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Navigationcontroller();
            if ($method === 'GET') {
                $controller->modifyNavigationPage();
            }
        } else {
            respondWith404();
        }
        break;
    case '/edit-navigation/modified':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Navigationcontroller();
            if ($method === 'POST') {
                $controller->updateNavigation();
            }
        } else {
            respondWith404();
        }
        break;
    case '/add-page':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Pagecontroller();
            if ($method === 'POST') {
                $controller->addNewPage();
            }
        } else {
            respondWith404();
        }
        break;
    case '/sectionDelete':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Pagecontroller();
            if ($method === 'POST') {
                $controller->deleteSection();
            }
        } else {
            respondWith404();
        }
        break;
    case '/delete-page':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Pagecontroller();
            if ($method === 'POST') {
                $controller->deletePage();
            }
        } else {
            respondWith404();
        }
        break;
    case "/editResturantDetails/updateRestaurantDetails":
        if ($_SESSION['role'] === 'admin') {
            $controller = new Restaurantcontroller();
            if ($method === 'POST') {
                $controller->updateRestaurantDetails();
            }
        } else {
            respondWith404();
        }
        break;
    case "/editResturantDetails/addTimeSlot":
        if ($_SESSION['role'] === 'admin') {
            $controller = new Restaurantcontroller();
            if ($method === 'POST') {
                $controller->addTimeSlot();
            }
        } else {
            respondWith404();
        }
        break;
    case "/editRestaurantDetails/addRestaurant":
        if ($_SESSION['role'] === 'admin') {
            $controller = new Restaurantcontroller();
            if ($method === 'POST') {
                $controller->addRestaurant();
            }
        } else {
            http_response_code(404);
        }
        break;

    case '/admin/add-section':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Pagecontroller();
            if ($method === 'POST') {
                $controller->addNewSection();
            }
        } else {
            respondWith404();
        }
        break;
    case "/restaurant/delete":
        if ($_SESSION['role'] === 'admin') {
            $controller = new Restaurantcontroller();
        }
        break;
    case '/submit-reservation':
        $controller = new Myprogramcontroller();
        if ($method === 'POST') {
            $controller->createReservation();
        }
        break;
    case "/restaurant/deletetimeslot":
        if ($_SESSION['role'] === 'admin') {
            $controller = new Restaurantcontroller();
            if ($method === 'POST') {
                $controller->deleteTimeSlot();
            }
        } else {
            http_response_code(404);
        }
        break;
    case '/my-program':
        $controller = new Myprogramcontroller();
        if ($method === 'GET') {
            $controller->show();
        }
        break;
    case '/modifyQuantity':
        $controller = new Myprogramcontroller();
        if ($method === 'POST') {
            $controller->modifyItemQuantity();
        }
        break;
    case '/deleteItem':
        $controller = new Myprogramcontroller();
        if ($method === 'POST') {
            $controller->deleteItemFromCart();
        }
        break;
    case '/getTotalCartPrice':
        $controller = new Myprogramcontroller();
        if ($method === 'GET') {
            $controller->updateTotalCartPrice();
        }
        break;
    case '/my-program/payment':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->showPayment();
        }
        break;
    case '/create-payment':
        $controller = new Myprogramcontroller();
        if ($method == 'POST') {
            $controller->initiatePayment();
        }
        break;
    case '/my-program/payment-success':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->paymentSuccess();
        }
        break;
    case '/my-program/order-confirmation':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->showSuccess();
        }
        break;
    case '/my-program/payment-failure':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->showFailure();
        }
        break;

    case '/admin/order-overview':
        if ($_SESSION['role'] === 'admin') {
            $controller = new orderoverviewcontroller();
            if ($method == 'GET') {
                $controller->showOverviewTable();
            }
        } else {
            respondWith404();
        }
        break;
    case '/admin/order-overview/export':
        if ($_SESSION['role'] === 'admin') {
            $controller = new orderoverviewcontroller();
            if ($method == 'POST') {
                $controller->exportExcel();
            }
        } else {
            respondWith404();
        }
        break;
    case '/employee/dashboard':
        if ($_SESSION['role'] === 'employee') {
            $controller = new EmployeeController();
            if ($method === 'GET') {
                $controller->showScanner();
            } elseif ($method === 'POST') {
                $controller->scanTicket();
            }
        } else {
            respondWith404();
        }
    case '/reservation/updateStatus':
        if ($_SESSION['role'] === 'admin') {
            $controller = new Restaurantcontroller();
            if ($method === "POST") {
                $controller->updateStatus();
            } else {
                respondWith404();
            }
            break;
        }

    default:
        respondWith404();
        break;
}