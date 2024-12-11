<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Endroid\QrCode\Writer\PngWriter;

use Psr\Log\LoggerInterface;

use App\Models\LoginModel;
use \App\Models\EmployeeModel;
use App\Models\M_List_asset;

use App\Models\M_List_Loan;
use App\Models\M_Loan_Req;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{

    
    protected $validation ;
    protected $session;
    protected $email;
    protected $req ;
    protected $MLL ;
    protected $EM ;
    protected $LM ;
    protected $MLA ;
    protected $CDM ;

    protected $MLR;

    protected $writer;
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['html', 'form', 'url', 'filesystem', 'Rupiah', 'file', 'Api'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function __construct()
    {
        // session_start();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->email = \Config\Services::email();
        $this->req = \Config\Services::request();
        // $this->VM = new VerifyModel($this->req);
        $this->LM = new LoginModel();
        // $this->CDM = new CategoryDocModel($this->req);
         $this->EM = new EmployeeModel($this->req);
        // // $this->DIM = new DBigraciasModel();
        $this->MLA = new M_List_asset($this->req);

        $this->MLL = new M_List_Loan();
        $this->MLR = new M_Loan_Req($this->req);
        $this->writer = new PngWriter();
        
        if (base_url('')!='http://localhost:8080/'){

           helper('cookie');
           set_cookie('my_cookie', 'nilai_cookie', 3600, '', '', false, true);
        }

        $response = service('response');

        // Tambahkan header HSTS
        $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->setHeader('X-Frame-Options', 'DENY');
    }
}
