<?php

namespace App\Controllers;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

class List_asset extends BaseController
{



    public function index()
    {

       
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
        $data = [
                'titlePage' => 'List Inventaris',
                'dataRole'=>$this->LM->getByNip(session()->nip_emp)
            
            ];
        return view('partials/navbar', $data);
    }


    public function Add_asset()
    {

        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }

        $this->validation->setRules([
            'asset_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'asset name cannot blank',
                ]
            ],
            'asset_type' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'asset type cannot blank',
                    'alpha' => 'asset type not chosed'
                ]
            ],
            'amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Amount tidak boleh kosong'
                ]
            ],
            'asset_status' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'asset status cannot blank',
                    'alpha_space' => 'asset status not chosed'
                ]
            ],
            'asset_location' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'lokasi asset  cannot blank'
                ]
            ],



        ]);


        $isDataValid = $this->validation->withRequest($this->request)->run();
        $image = $this->request->getFile('file_doc');

       if ($isDataValid) {
           
          
              $directoryPath = 'assets/img/asset';

              if (!is_dir($directoryPath)) {
                       mkdir($directoryPath, 0777, true); //Create directory recursively
                     }

            if ($image->isValid() && !$image->hasMoved()) {
           // Generate a unique name for the uploaded file
               $newName = 'Img_'.$this->request->getPost('asset_id'). '_'.$this->request->getPost('asset_name').'_'.date('YmdHis').'.' .$image->getExtension();
               $image->move($directoryPath, $newName);

               } else {
                
                 $newName='default.jpg';
               }

               $data = array(
                'id_asset' => $this->request->getPost('asset_id'),
                'asset_name' => $this->request->getPost('asset_name'),
                'asset_type' => $this->request->getPost('asset_type'),
                'asset_location' => $this->request->getPost('asset_location'),
                'asset_status' => $this->request->getPost('asset_status'),
                'asset_image' => $newName,
                'amount_asset' => $this->request->getPost('amount'),
                    
                 );
           $this->MLA->Add_asset($data);
          
           $callback=json_encode(array('status' => 'ok;', 'text' => ''));
           echo $callback;
       } else {
           $validation = $this->validation;
           $error=$validation->getErrors();
          
           $dataname=$_POST;
                 
           echo json_encode(array('status' => 'error;', 'text' => '', 'data'=>$error,'dataname'=>$dataname));
       }

      

    }

    public function dataJson()
    {
      
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }

            // $periode = $this->request->getPost("periode");
            $lists = $this->MLA->get_datatables();
            //print_r($lists);
            $data = [];
            //$no = $this->request->getPost("start");

            foreach ($lists as $val) {
               // $no++;
                $row = [];
            
                $row[]=$val['id_asset'];
                $row[]=' <img src="'.base_url('').'/assets/img/asset/'.$val['asset_image'].'" alt="" height="52">
                            <p class="d-inline-block align-middle mb-0">
                                <a href="" class="d-inline-block align-middle mb-0 product-name">'.$val['asset_name'].'</a> 
                               
                            </p>';
                $row[]=$val['asset_type'];
                $row[]=$val['asset_location'];
                $row[]=$val['amount_asset'];
                $row[]=' <a href="javascript: void(0)" onclick="ShowImage(\''.base_url('').'/assets/img/asset/qrcode/QrCode_'.$val['id_asset'].'.png'.'\')" class="d-inline-block align-middle mb-0 product-name"><img src="'.base_url('').'/assets/img/asset/qrcode/QrCode_'.$val['id_asset'].'.png" alt="" height="52"></a> ';
                $row[]='<span class="badge badge-soft-'.($val['asset_status']=='to loan'?'success':'').'">'.$val['asset_status'].'</span>';
                $btn='
                        <button type="button" onclick="createQR(\''.$val['id_asset'].'\')" class="btn btn-outline-dark  btn-xs" title="Create Qr code">
                            <i class="fa-solid fa-qrcode"></i>
                         </button>
                         <button type="button" onclick="popupedit(\''.$val['id_asset'].'\')" class="btn btn-outline-dark  btn-xs" title="Edit">
                            <i class="fa-solid fa-pencil"></i>
                         </button>
                <button type="button" onclick="deletedata(\''.$val['id_asset'].'\', \''.$val['asset_image'].'\')" class="btn btn-outline-danger  btn-xs" title="Delete">
                     <i class="fa-solid fa-trash"></i>
                      </button>';
                
                  
                $row[]=$btn;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->MLA->count_all(),
                "recordsFiltered" => $this->MLA->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
 
    }

    public function Edit_asset()
    {

        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
        $this->validation->setRules([
            'asset_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'asset name cannot blank',
                ]
            ],
            'asset_type' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'asset type cannot blank',
                    'alpha' => 'asset type not chosed'
                ]
            ],
            'amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Amount tidak boleh kosong'
                ]
            ],
            'asset_status' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'asset status cannot blank',
                    'alpha_space' => 'asset status not chosed'
                ]
            ],
                'asset_location' => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'lokasi asset  cannot blank'
                    ]
                ],



        ]);

    


        $isDataValid = $this->validation->withRequest($this->request)->run();
        if ($isDataValid) {

            $filefoto = $this->request->getFile('asset_image');
            if ($filefoto->getError() == 4) {
                $namafoto = 'default.jpg';
            } else {
                $filefoto->move('assets/img/asset');
                $namafoto = $filefoto->getName();
            }
            $data = array(
                'asset_name' => $this->request->getPost('asset_name'),
                'asset_type' => $this->request->getPost('asset_type'),
                'asset_location' => $this->request->getPost('asset_location'),
                'asset_status' => $this->request->getPost('asset_status'),
                'asset_image' => $namafoto,
                'amount_asset' => $this->request->getPost('amount'),
            );



            if ($this->MLA->Edit_asset($data, $this->request->getPost('asset_id'))) {

                echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => $data));
            }
        } else {
            $validation = $this->validation;
            $error = $validation->getErrors();
            $dataname = $_POST;
            //print_r($error);
            echo json_encode(array('status' => 'error;', 'text' => '', 'data' => $error, 'dataname' => $dataname));
        }
    }

    public function editInvenProcess()
    {
    

     if (session()->nip_emp==null){
            return false;
        }

        $this->validation->setRules([
            'asset_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'asset name cannot blank',
                ]
            ],
            'asset_type' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'asset type cannot blank',
                    'alpha' => 'asset type not chosed'
                ]
            ],
            'amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Amount tidak boleh kosong'
                ]
            ],
            'asset_status' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'asset status cannot blank',
                    'alpha_space' => 'asset status not chosed'
                ]
            ]



                
            ]);
       $isDataValid = $this->validation->withRequest($this->request)->run();

       $id=$this->request->getPost('asset_id');

       if ($isDataValid) {
        $data = array(
            'asset_name' => $this->request->getPost('asset_name'),
            'asset_type' => $this->request->getPost('asset_type'),
            'asset_status' => $this->request->getPost('asset_status'),
            'asset_location' => $this->request->getPost('asset_location'),
            'amount_asset' => $this->request->getPost('amount'),

        );
        
        $this->MLA->Edit_asset($data, $this->request->getPost('asset_id'));
     

        $image = $this->request->getFile('file_doc');
        $oldimage = $this->request->getPost('file_doc');
        $old_img=$this->request->getPost('old_doc');
       
         $callback=json_encode(array('status' => 'ok;', 'text' => ''));
         if (!isset($oldimage)) {
                 
                   $directoryPath = 'assets/img/asset/';

                 if ($image->isValid() && !$image->hasMoved()) {
             
                    $newName = 'Docs_'.$this->request->getPost('asset_id'). '_'.$this->request->getPost('asset_name').'_'.date('YmdHis').'.' . $image->getExtension();
                     $path_oldimg = 'assets/img/asset/'.$old_img;
     
                        unlink($path_oldimg);
                     
                    $image->move($directoryPath, $newName);
                     $data = array(
                        'url_doc' => $newName,
                    );
                    // // Move the uploaded file to the desired location
                     //$image->move($directoryPath, $newName);
                    
                     $this->MLA->Edit_asset($data, $this->request->getPost('asset_id'));
                    
                    
                    }else{
                     $callback=json_encode(array('status' => 'error;','text' => 'File Dokomen tidak boleh kosong'));
                    } 
               
            }

        echo $callback;
        } else {
            $validation = $this->validation;
            $error=$validation->getErrors();
            $dataname=$_POST;
                  //print_r($error);
            echo json_encode(array('status' => 'error;', 'text' => '', 'data'=>$error,'dataname'=>$dataname));
        }
    
     }
    


    public function Delete_asset()
    {
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }

            $img=$this->request->getPost('img');
            $path_file='assets/img/asset/'.$img;
        
                if (file_exists($path_file)) {
                        unlink($path_file);
                }  
            

        $id = $this->request->getPost('id_docs');

        if ($this->MLA->deleteasset($id)) {
            echo json_encode(array('status' => 'ok;', 'text' => ''));
        }
    }

    public function generate_id_asset()
    {
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }

        $id = $this->MLA->id_asset();

            echo json_encode(array('status' => 'ok;', 'text' => '', 'newId'=>$id));
        
    }

    public function modalEdit()
    {
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }

        $id = $this->request->getPost('id');
        $data = $this->MLA->getDatabyId($id);

        $imgsize=filesize('assets/img/asset/'.$data['asset_image']);

        if ($this->MLA->getDatabyId($id)) {
            echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => $data, 'imagesize'=>$imgsize));
        }
    }

    public function createQrCode(){
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
            
            $qrCode = QrCode::create(base_url('List_loan/addLoanListbyQr/'.$this->request->getPost('id_inventaris')))
           ->setEncoding(new Encoding('UTF-8'))
           ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
           ->setSize(300)
           ->setMargin(10)
           ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
           ->setForegroundColor(new Color(0, 0, 0))
           ->setBackgroundColor(new Color(255, 255, 255));

             $dir ="assets/img/asset/qrcode";
        // Create generic logo
           $logo = Logo::create( FCPATH .'assets_login/images/logo_darsy_notext.png')
           ->setResizeToWidth(100);

        // Create generic label
           $label = Label::create($this->request->getPost('id_inventaris'))
           ->setTextColor(new Color(54, 230, 48));

           $result = $this->writer->write($qrCode, null, $label);
           $namaQr= 'QrCode_'. $this->request->getPost('id_inventaris').'.png';

           
           if (file_exists('assets/img/asset/qrcode/'.$dir.'/'.$namaQr)){
                unlink(base_url('assets/img/asset/qrcode/'.$dir.'/'.$namaQr));
           }
           $result->saveToFile( FCPATH .$dir.'/'.$namaQr);

           echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => ''));
    }

  
}
