<?php namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\OrdersModel;
use App\Models\OrderslistingModel;
use mPDF;


class Orders extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
    public $orders;
    
   public  $arrType = array('' => 'Select', 'New Ticket' => 'New Ticket', 'Cancellation' => 'Cancellation');
   public $arrOrderstatus = array('' => 'Select', 'CONFIRM' => 'CONFIRM', 'WAITING' => 'WAITING', 'RAC' => 'RAC');
   public $arrTickettype = array("-Select-");
   public $arrClasscode = array("-Select-");
   public $arrStation = array("-Select-");
   public $arrTrain = array("-Select-");
   public $arrTransaction = array("-Select Transaction-");
   public $arrInternetuserlist = array('' => 'Select', 'A' => 'A', 'B' => 'B', 'C' => 'C');
   public $arrSex = array( 'M' => 'M', 'F' => 'F');

   public function __construct()
	{
       
            $this->orders = new OrdersModel();
          
            $this->session = session();
          // echo "<pre>"; print_r($session);die;
            $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn'); 
     
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            
		
	}

	public function index()
	{
     
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
		set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
                $userid = $this->session->get('user_id');
                
                $paginationnew = new \App\Libraries\Paginationnew();
              
                 $searchArray = array('user_id'=>$userid);
                 
                 $searchArray['txtsearch'] = $this->request->getGet('txtsearch');
                    $page = $this->request->getGet('page');
                    $page = $page ? $page : 1;
                    $Limit = PER_PAGE_RECORD;
                    $totalRecord = $this->orders->getData($searchArray,'','',1); // return count value

                    $startLimit = ($page - 1) * $Limit;
                    $data['startLimit'] = $startLimit;

                    $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
                    $data['pagination'] = $pagination;
                    $data["ordersData"] = $this->orders->getData($searchArray, $startLimit, $Limit);
                    $data["searchArray"] = $searchArray;
                   
                    
                 
                    $this->template->render('admintemplate', 'contents' , 'admin/orders/today_list', $data);
				
		
	}

        public function neworder()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
            
            $data = array();
            $data['arrTickettype'] = $this->arrTickettype += $this->orders->getTicketType(); 
            $data['arrClasscode'] = $this->arrClasscode += $this->orders->getClasscode(); 
            $data['arrType'] = $this->arrType; 
            $data['arrSex'] = $this->arrSex; 
            $data['arrTransaction'] = $this->arrTransaction;
            
            $userid =  $this->session->get('user_id');
            $mystid =  $this->request->getPost("id");
            $st_status =  $this->request->getPost("st_status");
            
            $this->template->render('admintemplate', 'contents' , 'admin/orders/add_new', $data);

        }
        
        public function editorder()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            $orderno =  $this->request->getGet("orderno");
            $transactionno =  $this->request->getGet("transactionno");
            $userid =  $this->session->get('user_id');
            
            if(!$orderno)
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
            
            $data = array();
            $orderId ='';
            $data['arrOrderdetail']  = $this->orders->getOrderDetail($orderno,$transactionno);
           
            if(!$data['arrOrderdetail'])
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            else {
                $orderId =$data['arrOrderdetail']['id'];
            }
            
            $data['orderno'] = $orderno; 
            $data['arrTickettype'] = $this->arrTickettype += $this->orders->getTicketType(); 
            $data['arrClasscode'] = $this->arrClasscode += $this->orders->getClasscode(); 
            $data['arrType'] = $this->arrType; 
            $data['arrSex'] = $this->arrSex; 
            $data['arrTransaction'] = $this->arrTransaction+$this->orders->getAllTransaction($orderno);
           
           $orderListing = new OrderslistingModel();
           $data['arrOrderlisting'] = $orderListing->getTicketDetail($orderId);
           // echo "<pre>";print_r($data);
            $this->template->render('admintemplate', 'contents' , 'admin/orders/edit_order', $data);

        }
        
        
        public function addOrder()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            $userid = $this->session->get('user_id');
            
           // echo "<pre>";print_r($this->request->getPost());
            
            $bokkingDate =$this->request->getPost('booking_date'); 
            $journey_date =$this->request->getPost('journey_date'); 
            $journey_date1 =$this->request->getPost('journey_date1'); 
            $journey_date2 =$this->request->getPost('journey_date2'); 
            $ticketorder_trainid =$this->request->getPost('ticketorder_trainid'); 
            $ticketorder_trainid1 =$this->request->getPost('ticketorder_trainid1'); 
            $ticketorder_trainid2 =$this->request->getPost('ticketorder_trainid2'); 
            $class_id =$this->request->getPost('class_id'); 
            $class_id1 =$this->request->getPost('class_id1'); 
            $class_id2 =$this->request->getPost('class_id2'); 
            $ticketorder_fromstation =$this->request->getPost('ticketorder_fromstation'); 
            $ticketorder_tostation =$this->request->getPost('ticketorder_tostation'); 
            $ticketorder_bording =$this->request->getPost('ticketorder_bording'); 
            $tatkal =$this->request->getPost('tatkal'); 
            $tatkal = isset($tatkal) ? 'Y' : 'N';
            $advance =$this->request->getPost('advance'); 
            $customer_name =$this->request->getPost('customer_name'); 
            $customer_code =$this->request->getPost('customer_code'); 
            $phone =$this->request->getPost('phone'); 
            $ticketorder_type =$this->request->getPost('ticketorder_type'); 
            $ticket_type =$this->request->getPost('ticket_type'); 
            $ticketorder_trainname =$this->request->getPost('ticketorder_trainname'); 
            
           $orderNo = $this->orders->getHeighestOrderno($bokkingDate);
           
           $transaction = $this->orders->getMaxTransactionId($orderNo);
           
            $arrSaveData = array(
                
                'orderno'=>$orderNo,
                'transactioncount'=> $transaction,
                'createdate'=>date('Y-m-d H:i:s'),
                'orderdate'=> date('Y-m-d H:i:s', strtotime($bokkingDate)),
                'jurneydate'=>date('Y-m-d H:i:s', strtotime($journey_date)),
                'jurneydate2'=>date('Y-m-d H:i:s', strtotime($journey_date1)),
                'jurneydate3'=>date('Y-m-d H:i:s', strtotime($journey_date2)),
                'trainid'=>$ticketorder_trainid,
                'trainclassid'=>$class_id,
                'train2'=>$ticketorder_trainid1,
                'train3'=>$ticketorder_trainid2,
                'trainclassid2'=>$class_id1,
                'trainclassid3'=>$class_id2,
                'fromstation'=>$ticketorder_fromstation,
                'tostation'=>$ticketorder_tostation,
                'bording'=>$ticketorder_bording,
                'tatkal'=>$tatkal,
                'advamount'=>$advance,
                'customername'=>$customer_name,
                'customerphone'=>$phone,
                'customercode'=>$customer_code,
                'tickettypeid'=>$ticketorder_type,
                'type'=>$ticket_type,
                'trainname'=>$ticketorder_trainname,
                'userid'=>$userid,
            );
            
            $this->orders->save($arrSaveData);
            $orderId = $this->orders->getInsertID();
           
            // insert passenger details
            if($orderId)
            {
                $passengers = array();
                for($i=1;$i <=6;$i++)
                {
                    if($this->request->getPost('name'.$i))
                    {
                        $passengers[] = array(
                            'orderno'=>$orderId,
                            'psgname'=>$this->request->getPost('name'.$i),
                            'sex'=>$this->request->getPost('sex'.$i),
                            'age'=>$this->request->getPost('age'.$i),
                            'idname'=>$this->request->getPost('pid'.$i),
                            'idvalue'=>$this->request->getPost('piv'.$i),
                        );
                    }
                    
                }
                
                $totalPasenger =count($passengers);
                if($totalPasenger)
                {
                    $db = \Config\Database::connect();
                    $builder = $db->table('ticketorderlisting');
                    $builder->insertBatch($passengers);
                    
                    //update passenger count
                    $arrSaveDatanew = array('passangerno'=>$totalPasenger);
                    $this->orders->where('orderno',$orderNo)->where('transactioncount',$transaction)->set($arrSaveDatanew)->update();
                }
            }
            
            
            return redirect()->to(site_url('editorder?orderno='.$orderNo));
           die;

        }
        
         public function updateOrder()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            $userid = $this->session->get('user_id');
            
            $orderNo = $this->request->getPost('orderno')  ;
            
            if(!$orderNo)
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            
           // echo "<pre>";print_r($this->request->getPost());
            
            $newtransaction = $this->request->getPost('newtransaction'); 
            $transaction = $this->request->getPost('transaction'); 
            $bokkingDate = $this->request->getPost('booking_date'); 
            $journey_date =$this->request->getPost('journey_date'); 
            $journey_date1 =$this->request->getPost('journey_date1'); 
            $journey_date2 =$this->request->getPost('journey_date2'); 
            $ticketorder_trainid =$this->request->getPost('ticketorder_trainid'); 
            $ticketorder_trainid1 =$this->request->getPost('ticketorder_trainid1'); 
            $ticketorder_trainid2 =$this->request->getPost('ticketorder_trainid2'); 
            $class_id =$this->request->getPost('class_id'); 
            $class_id1 =$this->request->getPost('class_id1'); 
            $class_id2 =$this->request->getPost('class_id2'); 
            $ticketorder_fromstation =$this->request->getPost('ticketorder_fromstation'); 
            $ticketorder_tostation =$this->request->getPost('ticketorder_tostation'); 
            $ticketorder_bording =$this->request->getPost('ticketorder_bording'); 
            $tatkal =$this->request->getPost('tatkal'); 
            $tatkal = isset($tatkal) ? 'Y' : 'N';
            $advance =$this->request->getPost('advance'); 
            $customer_name =$this->request->getPost('customer_name'); 
            $customer_code =$this->request->getPost('customer_code'); 
            $phone =$this->request->getPost('phone'); 
            $ticketorder_type =$this->request->getPost('ticketorder_type'); 
            $ticket_type =$this->request->getPost('ticket_type'); 
            $ticketorder_trainname =$this->request->getPost('ticketorder_trainname'); 
            
          // $orderNo = $this->orders->getHeighestOrderno($bokkingDate);
            if($newtransaction)
            {
             $transaction = $this->orders->getMaxTransactionId($orderNo);
            }
           
         
           
           
            $arrSaveData = array(
                
                'orderno'=>$orderNo,
                'transactioncount'=> $transaction,
                'orderdate'=> date('Y-m-d H:i:s', strtotime($bokkingDate)),
                'jurneydate'=>date('Y-m-d H:i:s', strtotime($journey_date)),
                'jurneydate2'=>date('Y-m-d H:i:s', strtotime($journey_date1)),
                'jurneydate3'=>date('Y-m-d H:i:s', strtotime($journey_date2)),
                'trainid'=>$ticketorder_trainid,
                'trainclassid'=>$class_id,
                'train2'=>$ticketorder_trainid1,
                'train3'=>$ticketorder_trainid2,
                'trainclassid2'=>$class_id1,
                'trainclassid3'=>$class_id2,
                'fromstation'=>$ticketorder_fromstation,
                'tostation'=>$ticketorder_tostation,
                'bording'=>$ticketorder_bording,
                'tatkal'=>$tatkal,
                'advamount'=>$advance,
                'customername'=>$customer_name,
                'customerphone'=>$phone,
                'customercode'=>$customer_code,
                'tickettypeid'=>$ticketorder_type,
                'type'=>$ticket_type,
                'trainname'=>$ticketorder_trainname,
                'userid'=>$userid,
            );
            
            $orderId ='';
           // print_r($arrSaveData);die;
            if($newtransaction)
            {
              $arrSaveData['createdate']=date('Y-m-d H:i:s');
              $this->orders->save($arrSaveData);
             $orderId = $this->orders->getInsertID();
            }
        else { 
               $this->orders->where('orderno',$orderNo)->where('transactioncount',$transaction)->set($arrSaveData)->update();
                 $orderId = $this->orders->where('orderno',$orderNo)->where('transactioncount',$transaction)->asObject()->first()->id;
             }
            
            
           // $orderId = $this->orders->getInsertID();
         // echo "=="; print_r($orderId) ;die;
            // insert passenger details
            if($orderId)
            {
                
                $passengers = array();
                for($i=1;$i <=6;$i++)
                {
                    if($this->request->getPost('name'.$i))
                    {
                        $passengers[] = array(
                            'orderno'=>$orderId,
                            'psgname'=>$this->request->getPost('name'.$i),
                            'sex'=>$this->request->getPost('sex'.$i),
                            'age'=>$this->request->getPost('age'.$i),
                            'idname'=>$this->request->getPost('pid'.$i),
                            'idvalue'=>$this->request->getPost('piv'.$i),
                        );
                    }
                    
                }
                
            //   echo "<pre>"; print_r($passengers);die;
                $totalPasenger = count($passengers);
                if($totalPasenger)
                {
                    $db = \Config\Database::connect();
                    $builder = $db->table('ticketorderlisting');
                    
                    $builder->where('orderno', $orderId)->delete();
                    
                    $builder->insertBatch($passengers);
                    
                    //update passenger count
                    $arrSaveDatanew = array('passangerno'=>$totalPasenger);
                    $this->orders->where('orderno',$orderNo)->where('transactioncount',$transaction)->set($arrSaveDatanew)->update();
                }
            }
            
             $this->session->setFlashdata('message', 'Order updated succesfully.');
            return redirect()->to(site_url('editorder?orderno='.$orderNo.'&transactionno='.$transaction));
           die;

        }

        public function gettraindetail()
        {
            $session = session();
            
            $tranino =  $this->request->getPost("tranino");
           
            $trainDetails = $this->orders->getTraindetail($tranino); 
            if(!count($trainDetails)){
                $trainDetails['name'] ='';
            }
          
               echo json_encode($trainDetails);
               die;
        }
        
        
         public function booking()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            $orderno =  $this->request->getGet("orderno");
            $transactionno =  $this->request->getGet("transactionno");
            $userid =  $this->session->get('user_id');
            
//            if(!$orderno)
//            {
//                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');
//
//                return redirect()->to(site_url('neworder'));
//            }
            set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
            
            $data = array();
            
            $data['arrOrderdetail']  = $this->orders->getOrderDetail($orderno,$transactionno);
           
//            if(!$data['arrOrderdetail'])
//            {
//                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');
//
//                return redirect()->to(site_url('neworder'));
//            }
            
            $data['orderno'] = $orderno; 
            $data['arrTickettype'] = $this->arrTickettype += $this->orders->getTicketType(); 
            $data['arrClasscode'] = $this->arrClasscode += $this->orders->getClasscode(); 
            $data['arrType'] = $this->arrType; 
            $data['arrSex'] = $this->arrSex; 
            $data['arrTransaction'] = $this->arrTransaction+$this->orders->getAllTransaction($orderno);
            $data['arrOrderstatus'] = $this->arrOrderstatus;
            $data['arrInternetuserlist'] = $this->arrInternetuserlist;
           
           $orderListing = new OrderslistingModel();
           $data['arrOrderlisting'] = $orderListing->getTicketDetail($orderno);
           // echo "<pre>";print_r($data);
            $this->template->render('admintemplate', 'contents' , 'admin/orders/booking', $data);

        }

         public function updatebooking()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            $userid = $this->session->get('user_id');
            
            $orderNo = $this->request->getPost('orderno')  ;
            
            if(!$orderNo)
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            
       //     echo "<pre>";print_r($this->request->getPost());die;
            
           
            $transaction = $this->request->getPost('transaction'); 
            $bookingDate = $this->request->getPost('booking_date'); 
            $pnrno =$this->request->getPost('pnrno'); 
            $status =$this->request->getPost('status'); 
            $ticketamount =$this->request->getPost('ticketamount'); 
            $booking_date =$this->request->getPost('booking_date'); 
            $servicecharge =$this->request->getPost('servicecharge'); 
            $makingcharge =$this->request->getPost('makingcharge'); 
            $tickettypeid =$this->request->getPost('tickettypeid'); 
            $finalrec =$this->request->getPost('finalrec'); 
            $refundamount =$this->request->getPost('refundamount'); 
            $information =$this->request->getPost('information'); 
            $finaldate =$this->request->getPost('finaldate'); 
            $internetid =$this->request->getPost('internetid'); 
            
           
            $arrSaveData = array(
                'pnrno'=>$pnrno,
                'status'=>$status,
                'ticketamount'=>$ticketamount,
                'servicecharge'=>$servicecharge,
                'makingcharge'=>$makingcharge,
                'finalamount'=>$finalrec,
                'finalrec'=>$finalrec,
                'refundamount'=>$refundamount,
                'tickettypeid'=>$tickettypeid,
                'info'=>$information,
                'internetid'=>$internetid,
                'bookingdate'=> date('Y-m-d H:i:s', strtotime($bookingDate)),
                'finaldate'=> date('Y-m-d H:i:s', strtotime($finaldate))
            );
            
//echo "<pre>";           print_r($arrSaveData);
               $this->orders->where('orderno',$orderNo)->where('transactioncount',$transaction)->set($arrSaveData)->update();
              
            
             $this->session->setFlashdata('message', 'Booking updated succesfully.');
            return redirect()->to(site_url('booking?orderno='.$orderNo.'&transactionno='.$transaction));
           die;

        }
        
         public function cancelbooking()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            $orderno =  $this->request->getGet("orderno");
            $transactionno =  $this->request->getGet("transactionno");
            $userid =  $this->session->get('user_id');
            
//            if(!$orderno)
//            {
//                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');
//
//                return redirect()->to(site_url('neworder'));
//            }
            set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
            
            $data = array();
            
            $data['arrOrderdetail']  = $this->orders->getOrderDetail($orderno,$transactionno);
           
//            if(!$data['arrOrderdetail'])
//            {
//                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');
//
//                return redirect()->to(site_url('neworder'));
//            }
            
            $data['orderno'] = $orderno; 
            $data['arrTickettype'] = $this->arrTickettype += $this->orders->getTicketType(); 
            $data['arrClasscode'] = $this->arrClasscode += $this->orders->getClasscode(); 
            $data['arrType'] = $this->arrType; 
            $data['arrSex'] = $this->arrSex; 
            $data['arrTransaction'] = $this->arrTransaction+$this->orders->getAllTransaction($orderno);
            $data['arrOrderstatus'] = $this->arrOrderstatus;
            $data['arrInternetuserlist'] = $this->arrInternetuserlist;
           
           $orderListing = new OrderslistingModel();
           $data['arrOrderlisting'] = $orderListing->getTicketDetail($orderno);
           // echo "<pre>";print_r($data);
            $this->template->render('admintemplate', 'contents' , 'admin/orders/cancelbooking', $data);

        }

         public function updatecancel()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            $userid = $this->session->get('user_id');
            
            $orderNo = $this->request->getPost('orderno')  ;
            
            if(!$orderNo)
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            
        //    echo "<pre>";print_r($this->request->getPost());die;
            
           
            $transaction = $this->request->getPost('transaction'); 
            $refundamount =$this->request->getPost('refundamount'); 
            $cancelcharge =$this->request->getPost('cancelcharge'); 
            $cancelmakingcharge =$this->request->getPost('cancelmakingcharge'); 
            $canceldate =$this->request->getPost('canceldate');
            
           
            $arrSaveData = array(
               
                'refundamount'=>$refundamount,
                'cancelcharge'=>$cancelcharge,
                'cancelmakingcharge'=>$cancelmakingcharge,
                'canceldate'=> date('Y-m-d H:i:s', strtotime($canceldate))
            );
            

               $this->orders->where('orderno',$orderNo)->where('transactioncount',$transaction)->set($arrSaveData)->update();
              
             $this->session->setFlashdata('message', 'Cancell updated succesfully.');
            return redirect()->to(site_url('cancelbooking?orderno='.$orderNo.'&transactionno='.$transaction));
           die;

        }
        
        
         public function delorder()
        {
            $session = session();
            
            $id =  $this->request->getGet("id");
           if($id)
           {
                $this->orders->where('id',$id)->delete();
//               echo $this->orders->getLastQuery();
//              die;
//              
                
                $db = \Config\Database::connect();
                $builder = $db->table('ticketorderlisting');

                $builder->where('orderno', $id)->delete();
                    
            $this->session->setFlashdata('message', 'Order deleted succesfully.');
           }
        else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
            return redirect()->to(site_url('orders'));
        }
        
        public function printorder()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            $orderno =  $this->request->getGet("orderno");
            $transactionno =  $this->request->getGet("transactionno");
            $userid =  $this->session->get('user_id');
            
            if(!$orderno)
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            
           
            $orderId ='';
            $arrOrderdetail  = $this->orders->getOrderDetail($orderno,$transactionno);
           
            if(!$arrOrderdetail)
            {
                $this->session->setFlashdata('errmessage', 'Order number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            else {
                $orderId =$arrOrderdetail['id'];
            }
           $orderListing = new OrderslistingModel();
           $arrOrderlisting = $orderListing->getTicketDetail($orderId);
          
           
           $filepath = APPPATH . "/Views/admin/orders/ordertemplate.html";
           $orderTemplate = file_get_contents($filepath);
          
        $orderTemplate = str_replace('##COMPANY_NAME##', SITE_NAME, $orderTemplate);
        $orderTemplate = str_replace('##COMPANY_SLOGAN##', nl2br(COMPANY_DESC), $orderTemplate);
        $orderTemplate = str_replace('##COMPANY_ADRESS##', nl2br(COMPANY_ADD1) . '<br>' . nl2br(COMPANY_ADD2), $orderTemplate);
        $orderTemplate = str_replace('##COMPANY_PHONE##', CONTACT_PHONE, $orderTemplate);
        $orderTemplate = str_replace('##COMPANY_EMAIL##', CONTACT_EMAIL, $orderTemplate);
        $orderTemplate = str_replace('##COMPANY_OPEN_TIME##', COMPANY_TIME, $orderTemplate);

        ##Ticket Info
        # $orderTemplate = str_replace('##TRAIN_NO##', $arrOrderdetail['trainname'], $orderTemplate);
        $orderTemplate = str_replace('##ORDER_NO##', $arrOrderdetail['orderno'], $orderTemplate);
       

        $jdate = $arrOrderdetail['jurneydate'] ? date('d-m-Y', strtotime($arrOrderdetail['jurneydate'])) : '';
        $jdate .= ($arrOrderdetail['jurneydate2'] && $arrOrderdetail['jurneydate2'] != "0000-00-00 00:00:00") ? ", " . date('d-m-Y', strtotime($arrOrderdetail['jurneydate2'])) : '';
        $jdate .= ($arrOrderdetail['jurneydate3'] && $arrOrderdetail['jurneydate3'] != "0000-00-00 00:00:00") ? ", " . date('d-m-Y', strtotime($arrOrderdetail['jurneydate3'])) : '';


		$customercode = $arrOrderdetail['customercode'];
        
         $ourrate = CHARGES_NOTE;
        if(strtolower($customercode)=='police')
        {
          $ourrate = "Free service for city police and others.";
        }
        
		 $orderTemplate = str_replace('##OUR_CHARGES##', $ourrate, $orderTemplate);


        $orderTemplate = str_replace('##JOURNEY_DATE##', $jdate, $orderTemplate);
        $orderTemplate = str_replace('##ORDER_DATE##', $arrOrderdetail['createdate'], $orderTemplate);

        $trainNo = $arrOrderdetail['trainid'];
        if ($arrOrderdetail['train2'])
            $trainNo .="," . $arrOrderdetail['train2'];
        if ($arrOrderdetail['train3'])
            $trainNo .="," . $arrOrderdetail['train3'];

        if ($arrOrderdetail['tatkal'] == 'Y')
            $trainNo .=" TS";
        $orderTemplate = str_replace('##TRAIN_NO##', $trainNo, $orderTemplate);
           
        $orderTemplate = str_replace('##FROM_STATION##', $arrOrderdetail['fromstation'], $orderTemplate);
        $orderTemplate = str_replace('##TO_STATION##', $arrOrderdetail['tostation'], $orderTemplate);
        
          $orderTemplate = str_replace('##CONTACT_NUMBER##', $arrOrderdetail['customerphone'], $orderTemplate);
        $orderTemplate = str_replace('##TICKET_AMOUNT##', '', $orderTemplate);
        $orderTemplate = str_replace('##ADVANCE_AMOUNT##', number_format($arrOrderdetail['advamount']), $orderTemplate);
        $orderTemplate = str_replace('##FINAL_AMOUNT##', '', $orderTemplate);
        ## Instruction ##
        $instructions = INSTRUCTION_NOTE;
        $orderTemplate = str_replace('##INSTRUCTIONS##', $instructions, $orderTemplate);
        
        // passangers details here
        
        $orderTemplate = str_replace('##PASSENGER_NAME1##', isset($arrOrderlisting[0]) ? ucwords(strtolower($arrOrderlisting[0]['psgname'])) : '', $orderTemplate);
        $orderTemplate = str_replace('##PASSENGER_NAME2##', isset($arrOrderlisting[1]) ? ucwords(strtolower($arrOrderlisting[1]['psgname'])) : '', $orderTemplate);
        $orderTemplate = str_replace('##PASSENGER_NAME3##', isset($arrOrderlisting[2]) ? ucwords(strtolower($arrOrderlisting[2]['psgname'])) : '', $orderTemplate);
        $orderTemplate = str_replace('##PASSENGER_NAME4##', isset($arrOrderlisting[3]) ? ucwords(strtolower($arrOrderlisting[3]['psgname'])) : '', $orderTemplate);
        $orderTemplate = str_replace('##PASSENGER_NAME5##', isset($arrOrderlisting[4]) ? ucwords(strtolower($arrOrderlisting[4]['psgname'])) : '', $orderTemplate);
        $orderTemplate = str_replace('##PASSENGER_NAME6##', isset($arrOrderlisting[5]) ? ucwords(strtolower($arrOrderlisting[5]['psgname'])) : '', $orderTemplate);
        $orderTemplate = str_replace('##GENDER1##', $arrOrderlisting[0]['sex'], $orderTemplate);
        $orderTemplate = str_replace('##GENDER2##', isset($arrOrderlisting[1]) ? $arrOrderlisting[1]['sex'] : '', $orderTemplate);
        $orderTemplate = str_replace('##GENDER3##', isset($arrOrderlisting[2]) ? $arrOrderlisting[2]['sex'] : '', $orderTemplate);
        $orderTemplate = str_replace('##GENDER4##', isset($arrOrderlisting[3]) ? $arrOrderlisting[3]['sex'] : '', $orderTemplate);
        $orderTemplate = str_replace('##GENDER5##', isset($arrOrderlisting[4]) ? $arrOrderlisting[4]['sex'] : '', $orderTemplate);
        $orderTemplate = str_replace('##GENDER6##', isset($arrOrderlisting[5]) ? $arrOrderlisting[5]['sex'] : '', $orderTemplate);
        $orderTemplate = str_replace('##AGE1##', isset($arrOrderlisting[0]) ? $arrOrderlisting[0] ['age'] : '', $orderTemplate);
        $orderTemplate = str_replace('##AGE2##', isset($arrOrderlisting[1]) ? $arrOrderlisting[1]['age'] : '', $orderTemplate);
        $orderTemplate = str_replace('##AGE3##', isset($arrOrderlisting[2]) ? $arrOrderlisting[2]['age'] : '', $orderTemplate);
        $orderTemplate = str_replace('##AGE4##', isset($arrOrderlisting[3]) ? $arrOrderlisting[3]['age'] : '', $orderTemplate);
        $orderTemplate = str_replace('##AGE5##', isset($arrOrderlisting[4]) ? $arrOrderlisting[4]['age'] : '', $orderTemplate);
        $orderTemplate = str_replace('##AGE6##', isset($arrOrderlisting[5]) ? $arrOrderlisting[5]['age'] : '', $orderTemplate);

        // passange id detals
        
        $idname = $arrOrderlisting['0']['idname'];
        $idvalue = $arrOrderlisting['0']['idvalue'];

        if (isset($arrOrderlisting['1']) && $idname == '') {
            $idname = $arrOrderlisting['1']['idname'];
            $idvalue = $arrOrderlisting['1']['idvalue'];
        }

        if (isset($arrOrderlisting['2']) && $idname == '') {
            $idname = $arrOrderlisting['2']['idname'];
            $idvalue = $arrOrderlisting['2']['idvalue'];
        }

        if (isset($arrOrderlisting['3']) && $idname == '') {
            $idname = $arrOrderlisting['3']['idname'];
            $idvalue = $arrOrderlisting['3']['idvalue'];
        }
        if (isset($arrOrderlisting['4']) && $idname == '') {
            $idname = $arrOrderlisting['4']['idname'];
            $idvalue = $arrOrderlisting['4']['idvalue'];
        }
        if (isset($arrOrderlisting['5']) && $idname == '') {
            $idname = $arrOrderlisting['5']['idname'];
            $idvalue = $arrOrderlisting['5']['idvalue'];
        }
        
        $orderTemplate = str_replace('##ID_NAME##', $idname, $orderTemplate);
        $orderTemplate = str_replace('##ID_NUMBER##', $idvalue, $orderTemplate);
        
        //class name
        $classCode = '';
        $db = \Config\Database::connect();
        $builder = $db->query('SELECT * FROM classcode  WHERE id='.$arrOrderdetail['trainclassid']);
        $arrResult =  $builder->getResult();
        
          $classCode .= isset($arrResult[0]->code) ? $arrResult[0]->code : '';
          
          $builder = $db->query('SELECT * FROM classcode  WHERE id='.$arrOrderdetail['trainclassid2']);
         $arrResult =  $builder->getResult();
        
          $classCode .= isset($arrResult[0]->code) ? ', '.$arrResult[0]->code : '';
          
          $builder = $db->query('SELECT * FROM classcode  WHERE id='.$arrOrderdetail['trainclassid3']);
        $arrResult =  $builder->getResult();
        
          $classCode .= isset($arrResult[0]->code) ? ', '.$arrResult[0]->code : '';
          
          $orderTemplate = str_replace('##TICKET_CLASS##', $classCode . ' / ' . $arrOrderdetail['passangerno'], $orderTemplate);

          
              
       // echo $orderTemplate;die;
        
        
       $pdf = new \TCPDF('L', PDF_UNIT, 'MediaBox', true, 'UTF-8', false);
        
                // remove default header/footer
             $pdf->setPrintHeader(false);
             $pdf->setPrintFooter(false);
             // set image scale factor
             $pdf->setImageScale('1.5');
             // set font
             $pdf->SetFont('helvetica', '', 7);

             // add a page
             $pdf->AddPage('L','A6');
             // output the HTML content
             $pdf->writeHTML($orderTemplate, true, 0, true, 0);

             // reset pointer to the last page
             $pdf->lastPage();
             //Close and output PDF document
             $pdf->Output($orderno.'_ticket.pdf', 'I');

  
           die;
            

        }
        
        
        
    
    
        
      
	
}