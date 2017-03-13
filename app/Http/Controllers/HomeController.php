<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/3/13
 * Time: 15:05
 */

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }
}