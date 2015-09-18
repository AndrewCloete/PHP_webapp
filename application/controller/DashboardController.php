<?php

/**
 * This controller shows an area that's only visible for logged in users (because of Auth::checkAuthentication(); in line 16)
 */
class DashboardController extends Controller
{   

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // this entire controller should only be visible/usable by logged in users, so we put authentication-check here
        Auth::checkAuthentication();
    }

    /**
     * This method controls what happens when you move to /dashboard/index in your app.
     */
    public function index()
    {
        $this->View->render('dashboard/index');
    }


   public function command()
    {
	$geyser_id = Request::post('geyser_id');
	$element_select = Request::post('e');
	$gstate_select = Request::post('g');
	$schedule_select = Request::post('s');

	

	$settings_url = "http://localhost:8080/om2m/nscl/applications/geyser_".$geyser_id."/containers/SETTINGS/contentInstances";
	$schedule_url = "http://localhost:8080/om2m/nscl/applications/Scheduler/containers/SCHEDULE_".$geyser_id."/contentInstances";	


	if(!empty($element_select)){
		$data ='{"Gstate":'.'"'.$gstate_select.'"'.'}';
		DashboardController::doPOST($settings_url, $data);
	}
	else if(!empty($gstate_select)){
		$data ='{"Rstate":'.'"'.$element_select.'"'.'}';
		DashboardController::doPOST($settings_url, $data);
	}
	else if(!empty($schedule_select)){
		if(strcmp($schedule_select, "low")==0)		
			$data ="40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40";
		else if(strcmp($schedule_select, "smart")==0)
			$data ="35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,60,60,60,60,60,60,60,60,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,50,50,50,50,50,50,50,50,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35,35";
		else if(strcmp($schedule_select, "high")==0)
			$data = "65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65,65";
	
		DashboardController::doPOST($schedule_url, $data);
	}

	

	
	$this->View->render('dashboard/index');
    }

	public static function doPOST($url, $data){
		$options = array(
		   'http' => array(
			'header'  => 	"Content-type: text/html\r\n".
					"Authorization: Basic YWRtaW46YWRtaW4=\r\n",
			'method'  => 'POST',
			'content' => $data,
		    ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		//var_dump($result);
	}



}
