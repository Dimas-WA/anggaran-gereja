<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
      $text = '';
      return view('login', compact('text'));
    }

    public function forgot_pass()
    {
      $text = '';
      return view('forgot_pass', compact('text'));
    }

    public function login(Request $request)
    {

        // dd($request->all());

        $this->validate(
            $request,
            [
                'username' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ],
            [
                'username.required' => 'Please input name, Thank You.',
                'password.required' => 'Please input password, Thank You.',
                'captcha.captcha' => 'incorrect capcha'
            ]
        );

      $this->validateLogin($request);

      $username = $request->username;
      $password = $request->password;

      if(Auth::attempt(['email'=>$username,'password'=>$password]))
      {
        return redirect('dashboard');
      }
      else
      {
        $text = 'Please insert correct username & password';
        return view('login', compact('text'));
      }
    }


    protected function validateLogin(Request $request)
    {
      $this->validate($request, [
        'username' => 'required', 'password' => 'required',
      ]);
    }


    public function logout()
    {
      # code...

      Session::flush();
      Auth::logout();

      return Redirect('login');

    }

    public function change_pass ()
    {
        return view('change-pass');
    }
    public function store_change_pass (Request $request)
    {
        // return view('change-pass');


        $this->validate(
            $request,
            [
                'password' => 'required',
                're_password' => 'required',
            ],
            [
                'password.required' => 'Please input name, Thank You.',
                're_password.required' => 'Please input tanggal lahir, Thank You.',
            ]
        );

        if ($request->password == $request->re_password) {
            # code...

            $user = User::find(auth()->user()->id);
            // dd($user);
            $user->update([
                // "name" => "User Update",
                'password' => bcrypt($request->password),
                'change_pass' => 0,
            ]);
            $user->save();

        }

        return redirect()->route('login');
        // dd($request->all());

    }

    public function forgot_pass_store(Request $request)
    {
        // dd($request->all());
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'captcha' => 'required|captcha'
            ],
            [
                'email.required' => 'Please input name, Thank You.',
                'captcha.captcha' => 'incorrect capcha'
            ]
        );
        // dd($request->all());

        try {
            //code...
            $cekUser = User::where('email', $request->email)->firstOrFail();
            $createNewPassword = Str::random(10);

            $cekUser->update([
                'password' => bcrypt($createNewPassword),
                'change_pass' => 1,
            ]);
            $cekUser->save();

            $saveLog = new LogApp([
                'user_id' => $cekUser->id,
                'module' => 'Reset Password',
                'description' => 'User melakukan reset password ke email yang terdaftar'
            ]);
            $saveLog->save();
            //email user

            $subject = 'AAUI APP Reset User Password';
            $body = '
                <div>
                    Dear Mr/Mrs. '.$cekUser->name.',<br><br>
                    Below is your new password the AAUI APP<br><br>
                    <strong>'.$createNewPassword.'</strong><br><br>
                    Immediately change the password in your profile for mutual security and comfort.<br><br>
                    Regards,<br>
                    AAUI
                </div>
            ';

            $mail = new PHPMailer();
            $mail->isSMTP();

            $mail->Host = 'duniacerita.com';
            $mail->SMTPAuth = true;
            $mail->Username   = 'userdev@duniacerita.com';                     //SMTP username
            $mail->Password   = 'YPLmt9MAff7j';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('noreply@duniacerita.com', 'AAUI APP');
            $mail->addReplyTo('noreply@duniacerita.com', 'AAUI APP');
            $mail->addAddress($cekUser->email, $cekUser->name);
            $mail->addBcc('dimaswisnuaryadi@gmail.com', 'Dimas WA');

            $mail->isHTML(true);
            $mail->Subject = $subject;

            $mail->Body = $body;
            $mail->AltBody = $body;

            if (!$mail->send()) {
                echo 'Mailer Error: '. $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }

            session()->flash('message', ' password successfully sent to your email.');
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('message', ' user not found');
        }

        return redirect(route('login'));
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

}
