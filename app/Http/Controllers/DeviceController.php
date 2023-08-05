<?php

namespace App\Http\Controllers;

use App\Helpers\AESEncryption;
use App\Http\Requests\Device\DeviceCreateRequest;
use App\Models\Device;
use App\Traits\ResponseAPI;


class DeviceController extends Controller
{
 
    use ResponseAPI;
    
    public function createDevicesPage()
    {
        try {
            return view('devices.create');
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(DeviceCreateRequest $request)
    {        
        try {
            $device = new Device();
            $device_random_id = $this->generateRandomHexa(6, 'device_random_id');
            $device_wifi_name = env('WIFI_NAME_CONSTANT_CHARS') . $this->generateRandomString(6, 'device_wifi_name');
            $device_wifi_pass = $this->generateRandomString(8, 'lower', 'device_wifi_pass');
            $device_first_key = $this->generateRandomHexa(16, 'device_first_key');
            $device_serial = env('DEVICE_SERIAL_CONSTANT') . $this->constructDeviceVersion($request->version) .
            $this->constructDeviceDateForDeviceSerial($request->date) . substr($device_random_id,0 ,2) . 
            sprintf('%07s', $device->getNextId());
            $device_mqtt_topic = $this->generateRandomHexa(4, 'device_mqtt_topic');
            $qrc_all_bytes =  $this->constructDeviceQRCBytes($request->date, $device_wifi_name, $device_wifi_pass, $device_random_id, $device_first_key);
            $objAes = new AESEncryption($qrc_all_bytes, env('KEY'), env('IV'), 256);
            $base_64_qrc = base64_encode($objAes->encrypt());
            $device->device_random_id = $device_random_id;
            $device->device_wifi_name = $device_wifi_name;
            $device->device_wifi_pass = $device_wifi_pass;
            $device->device_first_key = $device_first_key;
            $device->device_status = $request->status;
            $device->device_version = $request->version;
            $device->device_date = $request->date;
            $device->device_qr_printed = $request->printed;
            $device->device_serial = $device_serial;
            $device->device_mqtt_topic = $device_mqtt_topic;
            $device->device_qr = $base_64_qrc;
            $rslt = $device->save();
            if(!$rslt) throw new \Exception("Device Creation Failed", 401);
            return $this->success("Device Created Successfully", $device);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }        
    }

    protected function constructDeviceQRCBytes($device_date, $device_wifi_name, $device_wifi_pass, $device_random_id, $device_first_key){
        $all_qrc_bytes = env('MASTER_HEADER') . $this->constructDeviceDateForDeviceQRC($device_date) .
                        $this->generateStringHexa($device_wifi_name) . $this->generateStringHexa($device_wifi_pass) . 
                        $device_random_id . $device_first_key;
        return $all_qrc_bytes;
    }

    protected function generateStringHexa($str){
        $bytes = strtoupper(bin2hex($str));
        return $bytes;
    }

    protected function generateRandomHexa($length, $col){
        $bytes = random_bytes($length);
        $bytes = strtoupper(bin2hex($bytes));
                
        if (is_string($col)) {
            $device = Device::where($col, $bytes)->first();
            if ($device) $this->generateRandomHexa($length, $col);
        }
        return $bytes;
    }

    protected function constructDeviceDateForDeviceQRC($strDate){
        $strDate = str_replace(['/',' ',':'], '', $strDate);
        $strYear = substr(substr($strDate, -8), -6);
        $strDate[-8] = '.';
        $strDate = explode('.',$strDate)[0];
        $strDate = $strDate . $strYear;        
        $bytes = strtoupper(bin2hex($strDate));
        return $bytes;
    }

    protected function constructDeviceDateForDeviceSerial($date){
        $strDate = explode(' ',$date)[0];
        $strDate = str_replace('/', '', $strDate);
        $strYear = substr(substr($strDate, -4), -2);
        $strDate[-4] = '.';
        $strDate = explode('.',$strDate)[0];
        $strDate = $strDate . $strYear;
        return $strDate;
    }

    protected function constructDeviceVersion($version){
        return str_replace('.','',$version);
    }

    protected function generateRandomString($length = 10, $case = 'upper', $col = null) {
        if ($case = 'upper') $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        else $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        if (is_string($col)) {
            $device = Device::where($col, $randomString)->first();
            if ($device) $this->generateRandomString($length = 10, $case, $col);
        }
        if (is_string($col) && $col == 'device_wifi_name') {
            $device = Device::where($col, env('WIFI_NAME_CONSTANT_CHARS') . $randomString)->first();
            if ($device) $this->generateRandomString($length = 10, $case, $col);
        }
        return $randomString;
    }
}
