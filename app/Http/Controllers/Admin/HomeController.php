<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Trainer;
use App\Models\Hr;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class HomeController extends Controller
{

    public function __construct(Request $request)
    {
        if(session()->get('user')):
            if(session()->get('user')['type']!='admin'):
                return redirect()->route('notauthorised');
            endif;
        else:    
            return redirect()->route('admin.login');
        endif;
    }

    
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function dashboard(){
        return view('admin.home',
        [
            'page'=>'dashboard'
        ]);
    }

    public function trainers(){
        return view('admin.trainers',
                    [
                        'page'=>'trainers',
                        'trainers' => Trainer::all()->toArray()
                    ]
        );
    }

    public function employees(){
        return view('admin.employees',
        [
            'page'=>'employees',
            'employees' => Employee::all()->toArray()
        ]
      );
    }

    public function hrs(){
        return view('admin.hrs',
        [
            'page'=>'hrs',
            'hrs' => Hr::all()->toArray()
        ]
      );
    }

    public function profile(){
        return view('admin.profile',
        [
            'page'=>'profile',
            'profile' => session()->get('user')['data']
        ]
      );
    }

    public function addEmployee(){
        return view('admin.add_employee',
        [
            'page'=>'employee/add'
        ]
      );
    }

    public function addEmployeeReg(Request $request){
       
        if($this->validator($request,'employee')):
            $input = $request->all();
            
            $insert = array(
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['username'],
                    'password' => Hash::make($input['password']),
                    'mobile' => $input['mobile'],
                    'pan' => $input['pan'],
                    'aadhar' => $input['aadhar'],
                    'role' => 'employee',
                    'status' => 'active',
                    'employee_code' => 'EMP'.str_pad(Employee::get()->count()+1, 8, '0', STR_PAD_LEFT),
                    'accountname' => $input['accountname'],
                    'accountnumber' => $input['accountnumber'],
                    'bankname' => $input['bankname'],
                    'ifsc' => $input['ifsc'],
                    'profile_image' => Utils::uploadFile($request,'profilefile','employee/profile/'.$input['username']),
                    'panfile' => Utils::uploadFile($request,'panfile','employee/pan/'.$input['username']),
                    'aadharfile' => Utils::uploadFile($request,'aadharfile','employee/aadhar/'.$input['username']),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_date' => date('Y-m-d H:i:s')

            );
           Employee::insert($insert);
           return redirect()->route('admin.employees');

        endif;
    }

    public function addTrainer(){
        return view('admin.add_trainer',
        [
            'page'=>'trainer/add'
        ]
      );
    }

    public function addTrainerReg(Request $request){
       
        if($this->validator($request,'trainer')):
            $input = $request->all();
            
            $insert = array(
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['username'],
                    'password' => Hash::make($input['password']),
                    'mobile' => $input['mobile'],
                    'pan' => $input['pan'],
                    'aadhar' => $input['aadhar'],
                    'role' => 'trainer',
                    'status' => 'active',
                    'employee_code' => 'TRN'.str_pad(Trainer::get()->count()+1, 8, '0', STR_PAD_LEFT),
                    'accountname' => $input['accountname'],
                    'accountnumber' => $input['accountnumber'],
                    'bankname' => $input['bankname'],
                    'ifsc' => $input['ifsc'],
                    'profile_image' => Utils::uploadFile($request,'profilefile','trainer/profile/'.$input['username']),
                    'panfile' => Utils::uploadFile($request,'panfile','trainer/pan/'.$input['username']),
                    'aadharfile' => Utils::uploadFile($request,'aadharfile','trainer/aadhar/'.$input['username']),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_date' => date('Y-m-d H:i:s')

            );
           Trainer::insert($insert);
           return redirect()->route('admin.trainers');

        endif;
    }

    public function addDataReg(Request $request){
       
        if($this->datavalidator($request)):
            $input = $request->all();
            
            $insert = array(
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'mobile' => $input['mobile'],
                    'address' => $input['address'],
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_date' => date('Y-m-d H:i:s')

            );
           Customer::insert($insert);
           return redirect()->route('admin.data');

        endif;
    }

     public function dataAssignApprove(Request $request){
       $input  = $request->input();
       $assign = $input['assignTo'];
       $data   = $input['selectedData']; 
       if(count($data)>0):
        if($assign == 'trainer'):
            $to = $input['selectedTrainer'];
            foreach($data as $d):
                Customer::where('customer_id','=',$d)
                ->update(['trainer_id'=>$to]);
            endforeach;
        elseif($assign == 'employee'):
            $to = $input['selectedEmployee'];
            foreach($data as $d):
                Customer::where('customer_id','=',$d)
                ->update(['employee_id'=>$to]);
            endforeach;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'assignee not defined'
            ]);
        endif;
        return json_encode([
            'error'=>false,
            'message'=>'successfuly assigned'
        ]);
       else:
         return json_encode([
             'error'=>true,
             'message'=>'Select customer data to assign'
         ]);
       endif;
       
       
    }

    public function dataAssign(){
        return view('admin.data_assign',
        [
            'page'=>'data/assign',
            'data'=>Customer::where('status','active')->get()->toArray(),
            'trainer'=>Trainer::where('status','active')->get()->toArray(),
            'employee'=>Employee::where('status','active')->get()->toArray()
        ]
      );
      
    }

    public function addDataRegxl(Request $request){
       $valid = $this->datavalidatorxl($request);
               if(!$valid['error']):
            $file = $request->file('file');
            $filename = time().$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get 
            $location = 'temp'; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            
            $file = fopen($location.'/'.$filename, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0) {
            $i++;
            continue;
            }
            for ($c = 0; $c < $num; $c++) {
            $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            foreach ($importData_arr as $importData):
            $j++;
            if(Customer::where('email', '=', $importData[1])->exists() || Customer::where('mobile', '=', $importData[2])->exists()):
            else:    // user found
                Customer::create([
                    'name' => $importData[0],
                    'email' => $importData[1],
                    'mobile' => $importData[2],
                    'address' => $importData[3]
                    ]);     
            endif;
            endforeach;
            unlink($location.'/'.$filename);
            return json_encode($valid);
        else:
            return json_encode($valid);
        endif;
    }

    public function addHr(){
        return view('admin.add_hr',
        [
            'page'=>'hr/add'
        ]
      );
    }

    public function data(){
        return view('admin.data',
        [
            'page'=>'data',
            'data'=>Customer::all()->toArray()
        ]
      );
    }

    public function dataAdd(){
        return view('admin.add_data',
        [
            'page'=>'data/add'
        ]
      );
    }

    public function addHrReg(Request $request){
       
        if($this->validator($request,'hr')):
            $input = $request->all();
            
            $insert = array(
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['username'],
                    'password' => Hash::make($input['password']),
                    'mobile' => $input['mobile'],
                    'pan' => $input['pan'],
                    'aadhar' => $input['aadhar'],
                    'role' => 'hr',
                    'status' => 'active',
                    'employee_code' => 'HRS'.str_pad(Trainer::get()->count()+1, 8, '0', STR_PAD_LEFT),
                    'accountname' => $input['accountname'],
                    'accountnumber' => $input['accountnumber'],
                    'bankname' => $input['bankname'],
                    'ifsc' => $input['ifsc'],
                    'profile_image' => Utils::uploadFile($request,'profilefile','hr/profile/'.$input['username']),
                    'panfile' => Utils::uploadFile($request,'panfile','hr/pan/'.$input['username']),
                    'aadharfile' => Utils::uploadFile($request,'aadharfile','hr/aadhar/'.$input['username']),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_date' => date('Y-m-d H:i:s')

            );
           Hr::insert($insert);
           return redirect()->route('admin.hrs');

        endif;
    }


    
    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function datavalidatorxl(Request $request)
    {
        $file = $request->file('file');
        if($file):
            $extension = $file->getClientOriginalExtension();
            $fileSize  = $file->getSize();  
            if($fileSize>10000000):
                return ['error'=>true, 'msg'=>'File size is not more then 10MB.']; 
            endif;
            if($extension!='csv'):
                return ['error'=>true, 'msg'=>'Choose valid csv file.']; 
            endif;
            return ['error'=>false];
        else:
            return ['error'=>true, 'msg'=>'Upload file is requred.'];    
        endif;
            
    }
    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function datavalidator(Request $request)
    {
       // dd($request->all());
      //validation rules.
            $rules = [
                'name'     => 'required|min:3|max:100',
                'mobile'   => 'required|unique:customer_data|size:10',
                'email'    => 'required|email|unique:customer_data|min:5|max:191'
            ];

            //custom validation error messages.
            $messages = [
                'email.unique' => 'Email already exists in our Records.',
                'mobile.unique' => 'Mobile already exists in our Records.',
                'username.unique' => 'Username already exists in our Records.'
            ];

            //validate the request.
            return Validator::make($request->all(),[$rules,$messages]);
            
            //$request->validate($rules,$messages);
    }
    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request, $table)
    {
       // dd($request->all());
      //validation rules.
            $rules = [
                'name'     => 'required|min:3|max:100',
                'mobile'   => 'required|unique:'.$table.'|size:10',
                'email'    => 'required|email|unique:'.$table.'|min:5|max:191',
                'username' => 'required|alpha_numeric|unique:'.$table.'|min:6|max:16',
                'password' => 'required|string|min:4|max:255',
                'pan'      => 'required|string|unique:'.$table.'|min:10|max:10',
                'aadhar'   => 'required|unique:'.$table.'|min:12|max:12',
                'profilefile' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
                'aadharfile' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
                'panfile'    => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
                'accountname'     => 'required|min:3|max:100',
                'accountnumber'     => 'required|min:12|max:20',
                'ifsc'     => 'required|min:10|max:15',
                'bankname'     => 'required|min:3|max:100'

            ];

            //custom validation error messages.
            $messages = [
                'email.unique' => 'Email already exists in our Records.',
                'mobile.unique' => 'Mobile already exists in our Records.',
                'username.unique' => 'Username already exists in our Records.',
                'pan.unique' => 'Pan number already exists in our Records.',
                'aadhar.unique' => 'Aadhar number already exists in our Records.',
                'profilefile.mimes' => 'Please insert image only A',
                'profilefile.max' => 'Image should be less than 4 MB',
                'aadharfile.mimes' => 'Please insert image only B',
                'aadharfile.max' => 'Image should be less than 4 MB',
                'panfile.mimes' => 'Please insert image only c',
                'panfile.max' => 'Image should be less than 4 MB'

            ];

            //validate the request.
            return Validator::make($request->all(),[$rules,$messages]);
            
            //$request->validate($rules,$messages);
    }


    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}