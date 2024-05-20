<?php
namespace App\Http\Controllers\Admin\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    public function __construct()
    {
    }

    public function config()
    {
        return $config = [
            'js' => [
                'js/device.js',
                'js/plugins/dataTables/datatables.min.js',
                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js',
            ],
            'linkjs' => [
              
            ],
            'css' => [
                'css/device.css',
            ],  
            'linkcss' => [
               
            ],
            
            'script' => [
                
                '
                $(document).ready(function(){
                    $(\'.dataTables-example\').DataTable({
                        pageLength: 4,
                        searching: false, 
                        ordering: false, 
                        responsive: true,
                        info: false,  
                        paging: true,
                        lengthChange: false
                    });
        
                });
                ',
            ]
        ];
    }
   
    public function index()
    {
        if(Auth::check())
        {
            $devices=Device::with('deviceType')->get();
            $data = ['devices' => $devices];
            $id = Auth::id();
            $title = 'Device list';
            $employee = Employee::find($id);
            $employee_id = $employee->employee_id;
            $position_name = Position::find($employee_id)->position_name;
    
            $config = $this->config();
            $template = 'admin.device.index';
    
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name',
            ));
        }
        else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }
    public function createView()
    {
        $deviceTypes = DeviceType::all();
        $deviceTypes->prepend((object)['device_type_id' => -1, 'device_type_name' => '']);
        $id = Auth::id();
        $title = 'Create Device';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.device.create';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'deviceTypes',
            'title',
            'employee',
            'position_name',
        ));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'device_name' => 'required|max:255|unique:devices,device_name',
            'quantity' => 'required|integer|min:0',
            'original_price' => 'required|numeric|min:0',
            'device_type_id' => 'required|exists:device_types,device_type_id',
        ]);

        $device = new Device;
        $device->device_name = $validatedData['device_name'];
        $device->quantity = $validatedData['quantity'];
        $device->original_price = $validatedData['original_price'];
        $device->device_type_id = $validatedData['device_type_id'];
        $device->save();
        return redirect()->route('device.index')->with('success', 'Device created successfully!');
    }
    public function editView($id)
    {
        $device = device::find($id);
        $deviceTypes = deviceType::all();

        $authId = Auth::id();
        $title = 'Update device';

        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.device.edit';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'device',
            'deviceTypes',
            'title',
            'employee',
            'position_name'
        ));
    }

    public function edit(Request $request, $id)
    {
        $device = device::find($id);
        $request->validate([
            'device_name' => 'required|max:255|unique:devices,device_name,'.$id.',device_id',
            'quantity' => 'required|integer|min:0',
            'original_price' => 'required|numeric|min:0',
            'device_type_id' => 'required|exists:device_types,device_type_id',
        ]);

        $device->device_name = $request->device_name;
        $device->device_type_id = $request->device_type_id;
        $device->quantity = $request->quantity;
        $device->original_price = $request->original_price;
        $device->save();

        return redirect()->route('device.index');
    }
    public function search(Request $request)
    {
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $devices = Device::with('deviceType')
                            ->where('device_name', 'like', "%$keyword%")
                            ->orWhere('device_id', 'like', "%$keyword%")
                            ->orWhere('quantity', 'like', "%$keyword%")
                            ->orWhere('original_price', 'like', "%$keyword%")
                            ->orWhereHas('deviceType', function($query) use ($keyword) {
                                $query->where('device_type_name', 'like', "%$keyword%");
                            })->get();
        } else {
            $devices = Device::with('deviceType')->get();
        }
    
        $data = ['devices' => $devices];
        $id = Auth::id();
        $title = 'Search Results'; // Tiêu đề có thể thay đổi tùy thuộc vào yêu cầu của bạn
        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->config();
        $template = 'admin.device.index';
    
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'data',
            'title',
            'employee',
            'position_name',
        ));
    }
    public function delete($id)
    {
        $device = Device::find($id);
    
        if (!$device) {
            return redirect()->route('device.index')->with('error', 'Device not found!');
        }
    
        $device->delete();
    
        return redirect()->route('device.index')->with('success', 'Device deleted successfully!');
    }
    
}
