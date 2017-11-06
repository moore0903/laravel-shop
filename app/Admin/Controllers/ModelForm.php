<?php
/**
 * Created by PhpStorm.
 * User: win 10
 * Date: 2017/11/6
 * Time: 11:29
 */

namespace App\Admin\Controllers;


trait ModelForm
{
    public function show($id)
    {
        return $this->edit($id);
    }

    public function update($id)
    {
        return $this->form('edit')->update($id);
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            return response()->json([
                'status'  => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }

    public function store()
    {
        return $this->form('create')->store();
    }
}