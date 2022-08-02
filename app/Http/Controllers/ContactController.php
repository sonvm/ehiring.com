<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showContactForm(Request $request){
        $name  = $request->cookie('name');
        $email = $request->cookie('email');
    
        return view('fontend.contact')->with(['name' => $name, 'email' => $email]);
    }

    public function insertMessage(Request $request){
    $name    = $request->input('name');
    $email   = $request->input('email');
    $title   = $request->input('title');
    $message = $request->input('message');

    // Lưu cookie trong 30 phút
    $minutes = 30;
    $name_cookie = cookie('name', $name, $minutes);
    $email_cookie = cookie('email', $email, $minutes);

    // Insert message vào database, tạm thời coi như đã cập nhật database
    // chúng ta sẽ trở lại phần này trong những bài viết sau

    $data = ['success' => 'Bạn đã gửi tin nhắn thành công!'];
    return response()
        ->view('fontend.contact', $data, 200)
        ->withCookie($name_cookie)
        ->withCookie($email_cookie);
}
}
