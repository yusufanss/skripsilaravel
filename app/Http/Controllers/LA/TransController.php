<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Tran;

class TransController extends Controller
{
	public $show_action = true;
	public $view_col = 'no_faktur';
	public $listing_cols = ['id', 'no_faktur', 'waktu', 'total'];
	public $listing = ['id', 'no_faktur', 'kode_barang', 'jumlah', 'subtotal'];

	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Trans', $this->listing_cols);
				$this->listing = ModuleFields::listingColumnAccessScan('Detail_trans', $this->listing);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Trans', $this->listing_cols);
			$this->listing = ModuleFields::listingColumnAccessScan('Detail_trans', $this->listing);
		}
	}
	
	/**
	 * Display a listing of the Trans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Trans');
		
		if(Module::hasAccess($module->id)) {
			return View('la.trans.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new tran.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created tran in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Trans", "create")) {
		
			$rules = Module::validateRules("Trans", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Trans", $request);
			
			return redirect(config('laraadmin.adminRoute') . '/trans/'.$insert_id);
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified tran.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Trans", "view")) {
			
			$tran = Tran::find($id);
			if(isset($tran->id)) {
				$module = Module::get('Trans');
				$detail = Module::get('Detail_trans');
				$module->row = $tran;
				
				return view('la.trans.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
				'show_actions' => $this->show_action,
				'listing' => $this->listing,
				'detail' => $detail
				])->with('tran', $tran);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("tran"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified tran.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Trans", "edit")) {			
			$tran = Tran::find($id);
			if(isset($tran->id)) {	
				$module = Module::get('Trans');
				
				$module->row = $tran;
				
				return view('la.trans.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('tran', $tran);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("tran"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified tran in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Trans", "edit")) {
			
			$rules = Module::validateRules("Trans", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Trans", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.trans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified tran from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Trans", "delete")) {
			Tran::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.trans.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('trans')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Trans');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/trans/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Trans", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/trans/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Trans", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.trans.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
	
	public function ajax($id)
	{
		$values = DB::table('barangs')->select('harga')->where('id',$id)->first();
		return $values->harga;
	}
	
}
