<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdBannerModel;
use App\Models\CustomerModel;
use App\Models\OnetimePointModel;
use App\Models\AdvertisementModel;
use App\Models\DashboardAdvertisementModel;

class ApiAdvertise extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new AdBannerModel();
        $this->AdvertisementModel = new AdvertisementModel();
        $this->modell = new CustomerModel();
        $this->DashboardAddModel = new DashboardAdvertisementModel();
    }

    //get all category
    public function index() {
         $searchArray = array();
         $arrcompany =  $this->model->getData1($searchArray);
        
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Banner listed successfully'
                    ],
                    'image_base_url' => base_url('advertisement')."/",
                    'banner_default_url' => "https://instagram.com/citycode?utm_medium=copy_link",
                    'banner_list' => $arrcompany,
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No offers available.');
        }
    }

    public function newBanner() {
        // echo "string";exit;
        $user_id    = $this->request->getPost('user_id');
        $language   = $this->request->getPost('language');
        $arruser =  $this->model->getData12($user_id);
        //echo "<pre>";print_r($arruser);exit;
        if ($arruser) {
            $gender=''; 
            foreach ($arruser as $key => $value) {

                $gender = $value->gender;
                $governorate = $value->stateid;
            }
            $arrdata =  $this->model->getfinalData($gender,$governorate,$language);

            if ($arrdata) {
		$data1=$this->modell->select('onetime_point')->where('id',$user_id)->find();
                    $point=$data1[0]['onetime_point'];

                    if($point==0)
                    {
                        $currentdate=date('Y-m-d');
                       $OnetimePointModel = new OnetimePointModel();
                       $get=$OnetimePointModel->find();
                       $startdate=$get[0]['start_date1'];
                       $enddate=$get[0]['end_date1'];
                       $setpoint=$get[0]['initial_point1'];

                       if($currentdate >=$startdate AND $currentdate<=$enddate)
                       {
                      $data2=$this->modell->select('totalpoint')->where('id',$user_id)->find();
                $totalpoint= $data2[0]['totalpoint'];
                $save=$totalpoint+$setpoint;

                      $array=['totalpoint' => $save,
                            'onetime_point' => '1',
                            ];


                            $this->modell->set($array)->where('id',$user_id)->update();
                    
                        // echo"date mateched";
                      }
                    }

                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Banner listed successfully'
                    ],
                    'image_base_url' => base_url('advertisement')."/",
                    'banner_default_url' => "https://instagram.com/citycode?utm_medium=copy_link",
                    'banner_list' => $arrdata,
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No offers available.');
            }
        }
    }

   
    public function getDashboardAdd()
    {
          $searchArray = array();
         $arrcompany =  $this->DashboardAddModel->getDataAll($searchArray);
        
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Add listed successfully'
                    ],
                    'image_base_url' => base_url('advertisement')."/",
                    'banner_default_url' => "https://instagram.com/citycode?utm_medium=copy_link",
                    'banner_list' => $arrcompany,
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No offers available.');
        }
    }

    // create
    public function create() {

       
    }

    // single user
    public function show($id = null) {

        $data = $this->model->where('id', $id)->first();
        if ($data) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ]
            ];
            $response['userdetail'] = $data;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
public function bannerCount(){
            $bannerId = $this->request->getGet('bannerId');
     

        $searchArray = array();
         $searchArray['id'] = $bannerId;
         $data = $this->AdvertisementModel->getDataAll($searchArray);

      
        if ($data && $bannerId) { 

 
         $currentcount = $data[0]->count + 1;

            $updateCount = array('count'=>$currentcount);
            foreach($updateCount as $val){

                 $this->AdvertisementModel->updateCount($val,$bannerId);

            }
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'View updated successfully'
                ],
                
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }

    
}

