<?php
/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/19/15
 * Time: 2:16 AM
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class CRUDController extends \App\Http\Controllers\Controller {

  private function getClassName($request) {
    $path = explode('/', str_replace('admin/', '', $request->path()))[0];
    return ucfirst($path);
  }

  private function getAdmin($name) {
    return Admin::getByPath($name);
  }

  public function index(Request $request) {

    $cl = $this->getClassName($request);
    $cll = strtolower($cl);
    $data = call_user_func($cl.'::all');
    $admin = $this->getAdmin($cl);

    if(empty($admin->column)) {
      $cols = array_keys($admin->form);
      $cols_name = $admin->form;
    } else {
      $cols_name = $admin->column;
      $cols = array_keys($admin->column);
    }



    return view('crud.index')
      ->with('data', $data)
      ->with('route', $cll)
      ->with('grid', $cols)
      ->with('grid_name', $cols_name)
      ->with('fields', $admin->form)
      ->with('name', $admin->title);
  }

  public function create(Request $request) {
    $cl = $this->getClassName($request);
    $cll = strtolower($cl);
    $admin = $this->getAdmin($cl);
    return view('crud.create')
      ->with('route', $cll)
      ->with('method', 'post')
      ->with('fields', $admin->form)
      ->with('name', $admin->title);
  }

  public function edit($id, Request $request) {
    $cl = $this->getClassName($request);
    $cll = strtolower($cl);
    $admin = $this->getAdmin($cl);
    $data = call_user_func_array($cl.'::find', [$id]);
    $fields = [];
    foreach($admin->form as $key => $value) {
      array_push($value, $data->{$key});
      $fields[$key] = $value;
    }

    return view('crud.create')
      ->with('route', $cll.'/'.$data->id)
      ->with('method', 'put')
      ->with('fields', $fields)
      ->with('name', $admin->title);
  }

  public function store(Request $request) {

    $cl = $this->getClassName($request);
    $cll = strtolower($cl);
    $admin = $this->getAdmin($cl);
    $item = $this->fillObject($admin, $request, new $cl());
    $item->save();
    return redirect('/admin/'.$cll);

  }

  public function update($id, Request $request) {

    $cl = $this->getClassName($request);
    $cll = strtolower($cl);
    $admin = $this->getAdmin($cl);
    $item = call_user_func_array($cl.'::find', [$id]);
    $item = $this->fillObject($admin, $request, $item);
    $item->save();
    return redirect('/admin/'.$cll);

  }

  private function fillObject($admin, $request, $item) {
    foreach($admin->form as $key => $value) {

      $input = null;

      switch($admin->form[$key][1]) {

        case 'file':

          $file = $request->file($key);
          if(!empty($file) && $file->isValid()) {
            $extension = $file->getClientOriginalExtension();
            Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
            $input = $file->getFilename().'.'.$extension;
          }
          break;

        default:
          $input = $request->input($key);

      }

      if(!empty($input))
        $item->{$key} = $input;

    }
    return $item;
  }

  public function destroy($id, Request $request) {
    $cl = $this->getClassName($request);
    $item = call_user_func_array($cl.'::find', [$id]);
    $item->delete();
    return "true";
  }

}
